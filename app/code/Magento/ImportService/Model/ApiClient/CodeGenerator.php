<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\ApiClient;

use Jane\JsonSchema\Printer;
use Jane\OpenApi\JaneOpenApi;
use Jane\JsonSchema\Registry;
use Jane\JsonSchema\Schema;
use PhpParser\PrettyPrinter\Standard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Console\Exception\GenerationDirectoryAccessException;
use Magento\Framework\Console\GenerationDirectoryAccess;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Phrase;
use Magento\Setup\Console\Command\DiCompileCommand;
use Magento\Setup\Mvc\Bootstrap\InitParamListener;
use Symfony\Component\Console\Input\ArgvInput;
use Zend\ServiceManager\ServiceManager;

use Magento\ImportService\Model\UnreachableFunctions;

class CodeGenerator
{
    const NAMESPACE = 'Magento\ApiClientGenerated';
    const SWAGER_URI = 'rest/all/schema?services=all';
    const DIR_TO_GENERATED = 'Magento/ApiClientGenerated';

    const PATH_REST_CLIENT = 'Rest';
    const PATH_ASYNC_CLIENT = 'Async';
    const PATH_BULK_ASYNC_CLIENT = 'AsyncBulk';

    private $swagerUriToGenerate = [
        self::PATH_REST_CLIENT => 'rest/all/schema?services=all',
        self::PATH_ASYNC_CLIENT => 'rest/all/async/schema?services=all',
        self::PATH_BULK_ASYNC_CLIENT => 'rest/all/async/bulk/schema?services=all',
    ];
    /**
     * @var File
     */
    private $filesystemDriver;
    /**
     * @var \Magento\ImportService\Model\UnreachableFunctions
     */
    private $unreachableFunctions;
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    private $directoryList;

    /**
     * CodeGenerator constructor.
     *
     * @param \Magento\Framework\Filesystem\Driver\File $filesystemDriver
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     * @param \Magento\ImportService\Model\UnreachableFunctions $unreachableFunctions
     */
    public function __construct(
        File $filesystemDriver,
        DirectoryList $directoryList,
        UnreachableFunctions $unreachableFunctions
    ) {
        $this->filesystemDriver = $filesystemDriver;
        $this->unreachableFunctions = $unreachableFunctions;
        $this->directoryList = $directoryList;
    }

    /**
     * Generate a Magento PHP Client API (PSR7 compatible)
     * given a OpenAPI (Swagger) specification
     */
    public function generate()
    {
        foreach ($this->swagerUriToGenerate as $subPath => $schemaPath) {
            $options = $this->resolveConfiguration($this->getOptions($subPath, $schemaPath));
            $registry = new Registry();

            if (array_key_exists('openapi-file', $options)) {
                $registry->addSchema($this->resolveSchema($options['openapi-file'], $options));
            } else {
                foreach ($options['mapping'] as $schema => $schemaOptions) {
                    $registry->addSchema($this->resolveSchema($schema, $schemaOptions));
                }
            }

            $janeOpenApi = JaneOpenApi::build($options);
            $printer = new Printer(new Standard());

            $janeOpenApi->generate($registry);
            $printer->output($registry);
        }
    }

    private function getOptions($subPath, $schemaPath)
    {
        $swagerUrl = $this->unreachableFunctions->getBaseUrl() . $schemaPath;
        if (!$this->filesystemDriver->isExists($this->getDirForGenerated($subPath))) {
            $this->filesystemDriver->createDirectory($this->getDirForGenerated($subPath));
        }
        $schemaContent = file_get_contents($swagerUrl);
        if (!$schemaContent) {
            throw new \Exception('Swager schema not available');
        }
        $swagerFile = $this->getDirForGenerated($subPath) . DIRECTORY_SEPARATOR . $subPath.'.json';
        file_put_contents($swagerFile, $schemaContent);
        return [
            'openapi-file' => $swagerFile,
            'namespace' => self::NAMESPACE,
            'directory' => $this->getDirForGenerated($subPath),
        ];
    }

    private function resolveConfiguration(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $optionsResolver->setDefaults(
            [
                'reference' => false,
                'date-format' => \DateTime::RFC3339,
                'async' => false,
                'strict' => true,
            ]
        );

        if (array_key_exists('openapi-file', $options)) {
            $optionsResolver->setRequired(
                [
                    'openapi-file',
                    'namespace',
                    'directory',
                ]
            );
        } else {
            $optionsResolver->setRequired(['mapping',]);
        }

        return $optionsResolver->resolve($options);
    }

    private function resolveSchema($schema, array $options = [])
    {
        $optionsResolver = new OptionsResolver();

        // To support old schema
        $optionsResolver->setDefined(
            [
                'openapi-file',
                'reference',
                'date-format',
                'async',
                'strict',
            ]
        );

        $optionsResolver->setRequired(['namespace', 'directory',]);

        $options = $optionsResolver->resolve($options);

        return new Schema($schema, $options['namespace'], $options['directory'], '');
    }

    private function getDirForGenerated($subPath)
    {
        return $this->directoryList
                ->getPath(DirectoryList::GENERATED_CODE) . DIRECTORY_SEPARATOR .
            self::DIR_TO_GENERATED.DIRECTORY_SEPARATOR.$subPath;
    }
}
