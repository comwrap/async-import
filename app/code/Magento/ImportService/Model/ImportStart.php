<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\ObjectManagerInterface;
use Magento\ImportService\Api\Data\ImportConfigInterface;
use Magento\ImportService\Api\Data\ImportStartResponseInterface;
use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\Api\ImportStartInterface;
use Magento\ImportService\Api\SourceRepositoryInterface;
use Magento\ImportService\Model\Import\SourceTypePool;
use Magento\ImportService\Model\Config\Converter as ImportServiceConverter;
use Magento\ImportService\Model\Source\RulesProcessorFactory;
use Magento\ImportService\Model\Storage\MagentoRest;
use Magento\ImportServiceCsv\Model\CsvPathResolver;
use Magento\ImportServiceCsv\Model\JsonPathResolver;
use Magento\ImportServiceXml\Model\XmlPathResolver;
use Magento\ImportService\Model\ConfigInterface;
use Psr\Log\LoggerInterface;
use Magento\ImportService\Model\Import\Command\StartInterface as ImportRunner;

/**
 * Class ImportStart
 */
class ImportStart implements ImportStartInterface
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;
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
     * @var \Magento\ImportService\Model\Source\RulesProcessorFactory
     */
    private $rulesProcessorFactory;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * @var \Magento\ImportService\Model\Import\Command\Run
     */
    private $importRunner;

    /**
     * ImportStart constructor.
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\ImportService\Model\ConfigInterface $importConfig
     * @param \Magento\ImportService\Model\ImportStartResponseFactory $importStartResponseFactory
     * @param \Magento\ImportService\Api\SourceRepositoryInterface $sourceRepository
     * @param \Magento\ImportService\Model\Source\RulesProcessorFactory $rulesProcessorFactory
     * @param \Magento\ImportService\Model\Source\ReaderPool $readerPool
     */
    public function __construct(
        ImportRunner $importRunner,
        ObjectManagerInterface $objectManager,
        ConfigInterface $importConfig,
        ImportStartResponseFactory $importStartResponseFactory,
        SourceRepositoryInterface $sourceRepository,
        RulesProcessorFactory $rulesProcessorFactory,
        LoggerInterface $logger
    ) {
        $this->objectManager = $objectManager;
        $this->importStartResponseFactory = $importStartResponseFactory;
        $this->sourceRepository = $sourceRepository;
        $this->rulesProcessorFactory = $rulesProcessorFactory;
        $this->logger = $logger;
        $this->importRunner = $importRunner;
    }

    /**
     *  {@inheritdoc}
     */
    public function execute($uuid, $type, ImportConfigInterface $importConfig)
    {
        $importStartResponse = $this->importStartResponseFactory->create();

        $source = $this->sourceRepository->getByUuid($uuid);
        $source->setData('config_type', $type);

        $this->importRunner->execute($source, $importConfig);

        $importStartResponse->setError('');
        $importStartResponse->setStatus('processing');
        $importStartResponse->setUuid($uuid);
        return $importStartResponse;
    }

}
