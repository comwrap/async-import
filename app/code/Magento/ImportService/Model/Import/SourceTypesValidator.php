<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;

use Magento\ImportService\Api\Data\SourceInterface;
use Magento\ImportService\ImportServiceException;

/**
 * @inheritdoc
 */
class SourceTypesValidator implements SourceTypesValidatorInterface
{
    /**
     * @var array
     */
    private $allowedMimeTypes;

    /**
     * LocalPathFileProcessor constructor.
     * @param array $allowedMimeTypes
     */
    public function __construct(
        array $allowedMimeTypes
    ) {
        $this->allowedMimeTypes = $allowedMimeTypes;
    }

    /**
     * @inheritdoc
     * @throws ImportServiceException
     */
    public function execute(SourceInterface $source)
    {
        if (
            !array_key_exists($source->getSourceType(), $this->allowedMimeTypes)
        ) {
            throw new ImportServiceException(__('Source type "%1" doesn\'t allowed for the import', $source->getSourceType()));
        }
    }
}
