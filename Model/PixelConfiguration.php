<?php

namespace Magestat\FacebookPixel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class PixelConfiguration
 * Responsible to handle all the module configurations from the admin.
 */
class PixelConfiguration implements PixelConfigurationInterface
{
    /**
     * @var ScopeInterface
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
