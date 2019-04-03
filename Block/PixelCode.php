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

namespace Magestat\FacebookPixel\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cookie\Helper\Cookie;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class PixelCode
 * @package Magestat\FacebookPixel\Block
 */
class PixelCode extends Template
{
    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    private $locale;

    /**
     * @var \Magento\Cookie\Helper\Cookie
     */
    private $cookieHelper;

    /**
     * @var \Magestat\FacebookPixel\Model\PixelConfigurationInterface
     */
    private $pixelConfiguration;

    /**
     * PixelCode constructor.
     * @param Context $context
     * @param array $data
     * @param ResolverInterface $locale
     * @param Cookie $cookieHelper
     * @param PixelConfigurationInterface $pixelConfiguration
     */
    public function __construct(
        Context $context,
        array $data,
        ResolverInterface $locale,
        Cookie $cookieHelper,
        PixelConfigurationInterface $pixelConfiguration
    ) {
        parent::__construct($context, $data);
        $this->locale = $locale;
        $this->cookieHelper = $cookieHelper;
        $this->pixelConfiguration = $pixelConfiguration;
    }

    /**
     * @inheritdoc
     */
    protected function _toHtml()
    {
        if (!$this->pixelConfiguration->isEnabled()) {
            return '';
        }
        return parent::_toHtml();
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale->getLocale();
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreCurrencyCode()
    {
        return $this->_storeManager->getStore()->getBaseCurrencyCode();
    }

    /**
     * Return current website id.
     *
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCurrentWebsiteId()
    {
        return $this->_storeManager->getWebsite()->getId();
    }

    /**
     * Return cookie restriction mode value.
     *
     * @return bool
     */
    public function isCookieRestrictionModeEnabled()
    {
        return $this->cookieHelper->isCookieRestrictionModeEnabled();
    }

    /**
     * @return bool
     */
    public function getPixelCode()
    {
        return $this->pixelConfiguration->getPixelId();
    }
}
