<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Webapi\Controller\Rest\Matcher;

/**
 *  Request matcher interface
 */
interface RequestMatcherInterface
{
    /**
     * Method should return true for all the request current processor can process.
     *
     * Invoked in the loop for all registered request processors. The first one wins.
     *
     * @param \Magento\Framework\Webapi\Rest\Request $request
     * @return bool
     */
    public function isMatched(\Magento\Framework\Webapi\Rest\Request $request);
}
