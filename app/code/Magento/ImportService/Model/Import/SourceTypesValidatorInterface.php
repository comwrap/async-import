<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Model\Import;

use Magento\ImportService\Api\Data\SourceInterface;

/**
 * Interface SourceTypesValidatorInterface checks is source type allowed in the system
 */
interface SourceTypesValidatorInterface
{
    /**
     * @param SourceInterface $source
     * @return void
     */
    public function execute(SourceInterface $source);
}
