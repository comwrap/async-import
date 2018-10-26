<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportService\Api\Data\SourceFileType;

use Magento\Framework\Api\ExtensibleDataInterface;

interface XmlInterface extends ExtensibleDataInterface
{
    /**
     * Import field separator.
     */
    const SEPARATOR = 'separator';

    /**
     * Import multiple value separator.
     */
    const MULTIPLE_VALUE_SEPARATOR = 'multiple_value_separator';

    /**
     * Allow multiple values wrapping in double quotes for additional
     * attributes.
     */
    const ENCLOSURE = 'enclosure';

    /**
     * default delimiter for several values in one cell as default for
     * FIELD_FIELD_MULTIPLE_VALUE_SEPARATOR
     */
    const DEFAULT_GLOBAL_MULTI_VALUE_SEPARATOR = ',';

    /**
     * default empty attribute value constant
     */
    const DEFAULT_EMPTY_ATTRIBUTE_VALUE_CONSTANT = '__EMPTY__VALUE__';

    /**
     * @return string|null
     */
    public function getSeparator();

    /**
     * @param $separator
     * @return string
     */
    public function setSeparator($separator);

    /**
     * @return string|null
     */
    public function getEnclosure();

    /**
     * @param $enclosure
     * @return string
     */
    public function setEnclosure($enclosure);

    /**
     * @return string|null
     */
    public function getMultipleValueSeparator();

    /**
     * @param $multipleValueSeparator
     * @return string
     */
    public function setMultipleValueSeparator($multipleValueSeparator);
}
