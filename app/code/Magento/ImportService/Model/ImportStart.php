<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\ImportService\Api\Data\ImportConfigInterface;
use Magento\ImportService\Api\Data\ImportStartResponseInterface;
use Magento\ImportService\Api\ImportStartInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\Model\Import\SourceTypePool;
use Magento\ImportService\Model\Source\ParserPool;
use Magento\ImportService\Model\Config\Reader as ImportServiceConfig;

/**
 * Class ImportStart
 */
class ImportStart implements ImportStartInterface
{
    /**
     * @var ImportStartResponseFactory
     */
    private $importStartResponseFactory;
    /**
     * @var \Magento\ImportService\Api\SourceRepositoryInterface
     */
    private $sourceRepository;
    /**
     * @var \Magento\ImportService\Model\Import\SourceTypePool
     */
    private $sourceTypePool;
    /**
     * @var \Magento\ImportService\Model\Source\ParserPool
     */
    private $parserPool;
    /**
     * @var \Magento\ImportService\Model\Config\Reader
     */
    private $importServiceConfig;

    /**
     * ImportStart constructor.
     *
     * @param \Magento\ImportService\Model\ImportStartResponseFactory $importStartResponseFactory
     * @param \Magento\ImportService\Api\SourceRepositoryInterface $sourceRepository
     * @param \Magento\ImportService\Model\Source\ParserPool $parserPool
     */
    public function __construct(
        ImportServiceConfig $importServiceConfig,
        ImportStartResponseFactory $importStartResponseFactory,
        SourceRepositoryInterface $sourceRepository,
        ParserPool $parserPool
    ) {
        $this->importServiceConfig = $importServiceConfig;
        $this->importStartResponseFactory = $importStartResponseFactory;
        $this->sourceRepository = $sourceRepository;
        $this->parserPool = $parserPool;
    }

    /**
     *  {@inheritdoc}
     */
    public function execute($uuid, $type, ImportConfigInterface $importConfig)
    {
        $importStartResponse = $this->importStartResponseFactory->create();

        $source = $this->sourceRepository->getByUuid($uuid);
        $parser = $this->parserPool->getParser($source);

        $config = $this->importServiceConfig->read();
        $parser->rewind();
        foreach ($parser as $rawItem) {
            $t=1;
        }

        $importStartResponse->setError('');
        $importStartResponse->setStatus('processing');
        $importStartResponse->setUuid($uuid);
        return $importStartResponse;
    }
}
