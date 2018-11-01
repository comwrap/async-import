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
     * @var array
     */
    private $schemaToGenerate;

    /**
     * CodeGenerator constructor.
     *
     * @param \Magento\Framework\Filesystem\Driver\File $filesystemDriver
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     * @param \Magento\ImportService\Model\UnreachableFunctions $unreachableFunctions
     * @param \Magento\ImportService\Model\ApiClient\SchemaInfo\SchemaInfoInterface[] $schemaToGenerate
     */
    public function __construct(
        File $filesystemDriver,
        DirectoryList $directoryList,
        UnreachableFunctions $unreachableFunctions,
        $schemaToGenerate = []
    ) {
        $this->filesystemDriver = $filesystemDriver;
        $this->unreachableFunctions = $unreachableFunctions;
        $this->directoryList = $directoryList;
        $this->schemaToGenerate = $schemaToGenerate;
    }

    /**
     * Generate a Magento PHP Client API (PSR7 compatible)
     * given a OpenAPI (Swagger) specification
     *
     * @param string $schemaName
     */
    public function generate($schemaName = null)
    {
        /** @var \Magento\ImportService\Model\ApiClient\SchemaInfo\SchemaInfoInterface $schemaInfo */
        foreach ($this->schemaToGenerate as $schemaInfo) {
            if (isset($schemaName) && $schemaInfo->getSchemaName() != $schemaName) {
                continue;
            }
            $options = $this->resolveConfiguration($this->getOptions($schemaInfo));
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

    /**
     * @param \Magento\ImportService\Model\ApiClient\SchemaInfo\SchemaInfoInterface $schemaInfo
     * @return array
     * @throws \Exception
     */
    private function getOptions($schemaInfo)
    {
        $pathToApiClient = $schemaInfo->getPathToApiClient();
        $swaggerUrl = $this->unreachableFunctions->getBaseUrl() . $schemaInfo->getSwaggerUri();
        if (!$this->filesystemDriver->isExists($pathToApiClient)) {
            $this->filesystemDriver->createDirectory($pathToApiClient);
        }
        $schemaContent = file_get_contents($swaggerUrl);
        if (!$schemaContent) {
            throw new \Exception('Swager schema not available');
        }
        $swaggerFile = $schemaInfo->getPathToSwaggerSchemaFile();
        file_put_contents($swaggerFile, $schemaContent);
        return [
            'openapi-file' => $swaggerFile,
            'namespace' => $schemaInfo->getNamespace(),
            'directory' => $pathToApiClient,
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
}
