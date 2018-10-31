<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportService\Console\Command;

use Magento\Framework\App\State;
use Magento\ImportService\Model\ApiClient\CodeGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateInternalApiClient
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class GenerateInternalApiClient extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Magento\Framework\App\State
     */
    private $appState;
    /**
     * @var \Magento\ImportService\Model\ApiClient\CodeGenerator
     */
    private $codeGenerator;

    /**
     * GenerateInternalApiClient constructor.
     *
     * @param \Magento\Framework\App\State $appState
     * @param \Magento\ImportService\Model\ApiClient\CodeGenerator $codeGenerator
     */
    public function __construct(
        State $appState,
        CodeGenerator $codeGenerator
    ) {
        $this->appState = $appState;
        $this->codeGenerator = $codeGenerator;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('import:generate:apiclient');
        $this->setDescription('Generate a Magento PHP Client API.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->setDecorated(true);
        $this->appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        try {
            $output->writeln("");
            $output->writeln("<info>Start generate api client based in swagger specification...</info>");
            $this->codeGenerator->generate();
            $output->writeln("");
            $output->writeln("<info>Api client generated.</info>");
            return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
        } catch (\Exception $exception) {
            $output->writeln("");
            $output->writeln("<error>{$exception->getMessage()}</error>");
            // we must have an exit code higher than zero to indicate something was wrong
            return \Magento\Framework\Console\Cli::RETURN_FAILURE;
        }
    }
}
