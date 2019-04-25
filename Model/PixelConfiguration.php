<?php

/**
 * A Magento 2 module named Magestat/FacebookPixel
 * Copyright (C) 2019 Magestat
 *
 * This file included in Magestat/FacebookPixel is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Magestat\FacebookPixel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class PixelConfiguration
 * @package Magestat\FacebookPixel\Model
 */
class PixelConfiguration implements PixelConfigurationInterface
{
    /**
     * @var \Magento\Store\Model\ScopeInterface
     */
    private $scopeConfig;

    /**
     * Constructor
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritdoc
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @inheritdoc
     */
    public function getPixelId()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FB_PIXEL_ID, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @inheritdoc
     */
    public function getIncludeTax()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_FB_INC_TAX, ScopeInterface::SCOPE_STORE);
    }
}
