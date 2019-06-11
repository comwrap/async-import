<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceXml\Model\Reader;

use Magento\ImportExport\Model\Import\AbstractEntity;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Model\Source\ReaderAbstract;
use Magento\ImportService\Model\Source\ReaderInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\ImportServiceXml\Model\SourceXml;
use Magento\ImportServiceXml\Model\SourceXmlFactory;
use Magento\ImportServiceXml\Model\SourceFormatXml;

/**
 * CSV Reader Implementation
 */
class Xml extends ReaderAbstract implements ReaderInterface
{

    /**
     * Current row
     *
     * @var array
     */
    protected $_row = [];

    /**
     * Current row number
     * -1 means "out of bounds"
     *
     * @var int
     */
    protected $_key = -1;

    /**
     * @var bool
     */
    protected $_foundWrongQuoteFlag = false;

    /**
     * @var \Magento\Framework\Filesystem\File\Read
     */
    protected $_file;

    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;
    /**
     * @var \Magento\ImportServiceXml\Model\Readerr\SourceXmlFactory
     */
    private $sourceXmlFactory;

    /**
     * @var \Magento\ImportService\Api\Data\SourceInterface
     */
    private $source;

    /**
     * @var \SimpleXMLElement[]
     */
    //private $items;
    /**
     * @var string
     */
    private $itemXpath;
    /**
     * @var \SimpleXMLIterator
     */
    private $xml;

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        SourceXmlFactory $sourceXmlFactory
    ) {
        register_shutdown_function([$this, 'destruct']);
        $this->filesystem = $filesystem;
        $this->sourceXmlFactory = $sourceXmlFactory;
    }

    public function init(SourceInterface $source, $filePath)
    {
        /** @var SourceXml $source */
        $source = $this->sourceXmlFactory->create()->load($source->getData(SourceInterface::ENTITY_ID));
        try {
            $directory = $this->filesystem->getDirectoryRead('var');
            $this->_file = $directory->openFile($directory->getRelativePath($filePath), 'r');
        } catch (\Magento\Framework\Exception\FileSystemException $e) {
            throw new \LogicException("Unable to open file: '{$filePath}'");
        }

        //$this->xml = simplexml_load_string($this->_file->readAll());
        $this->xml = new \SimpleXMLIterator($this->_file->readAll());

        $this->source = $source;
        $this->itemXpath = $source->getFormat()->getItemsXpath();
        $this->_key = 0;
        $this->next();
        //$this->items = $this->xml->xpath($this->itemXpath);
    }

    /**
     * Close file handle
     *
     * @return void
     */
    public function destruct()
    {
        if (is_object($this->_file)) {
            $this->_file->close();
        }
    }

    /**
     * Rewind the \Iterator to the first element (\Iterator interface)
     *
     * @return void
     */
    public function rewind()
    {
        $this->_key = 0;
        $this->next();
    }

    /**
     * Return the current element
     * Returns the row in associative array format: array(<col_name> =>
     * <value>, ...)
     *
     * @return array
     */
    public function current()
    {
        return $this->_row;
    }

    /**
     * Move forward to next element (\Iterator interface)
     *
     * @return void
     */
    public function next()
    {
        $this->_key++;
        $row = $this->xml->xpath($this->itemXpath . '[' . $this->_key . ']');
        if (false === $row || [] === $row) {
            $this->_row = [];
            $this->_key = -1;
        } else {
            if(empty($row)){
                $this->_row = [];
                $this->_key = -1;
                return;
            }
            $xml = new \SimpleXMLElement($row[0]->asXML());
            $this->_row = $xml;
        }
    }

    /**
     * Return the key of the current element (\Iterator interface)
     *
     * @return int -1 if out of bounds, 0 or more otherwise
     */
    public function key()
    {
        return $this->_key;
    }

    /**
     * Checks if current position is valid (\Iterator interface)
     *
     * @return bool
     */
    public function valid()
    {
        return -1 !== $this->_key;
    }

    /**
     * Seeks to a position (Seekable interface)
     *
     * @param int $position The position to seek to 0 or more
     * @return void
     * @throws \OutOfBoundsException
     */
    public function seek($position)
    {
        if ($position == $this->_key) {
            return;
        }
        if (0 == $position || $position < $this->_key) {
            $this->rewind();
        }
        if ($position > 0) {
            $this->_key = $this->_key - 1;
            $this->next();
            if ($this->_key != -1) {
                return;
            }
        }
        throw new \OutOfBoundsException('Please correct the seek position.');
    }
}
