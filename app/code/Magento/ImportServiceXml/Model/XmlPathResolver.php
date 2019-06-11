<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\ImportServiceXml\Model;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\ImportService\Model\Source\PathResolverInterface;

class XmlPathResolver implements PathResolverInterface
{

    /**
     * @param \SimpleXMLElement $item
     * @param string $path
     * @return mixed
     */
    public function get($item, $path)
    {
        /** @var \SimpleXMLElement $result */
        $result = $item->xpath($path);
        if (empty($result)) {
            return null;
        }
        preg_match('/\[([0-9]+)\]$/', $path, $searchResult);
        if (isset($result[0]) && count($searchResult) > 1) {
            /** @var  $el */
            return (string)$result[0];
        }
        return $result;
    }

    /**
     * @param \SimpleXMLElement $item
     * @param string $path
     * @param mixed $value
     * @return mixed
     */
    public function set($item, $path, $value)
    {
        return;
        //return $this->arrayManager->set($path, $item, $value, '.');
    }
}
