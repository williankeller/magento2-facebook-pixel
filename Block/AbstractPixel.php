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
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Directory\Model\PriceCurrency;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class AbstractPixel
 * @package Magestat\FacebookPixel\Block
 */
abstract class AbstractPixel extends Template
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
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    private $jsonHelper;

    /**
     * @var \Magento\Directory\Model\PriceCurrency
     */
    private $price;

    /**
     * @var \Magestat\FacebookPixel\Model\PixelConfigurationInterface
     */
    private $pixelConfiguration;

    /**
     * AbstractPixel constructor.
     * @param Context $context
     * @param ResolverInterface $locale
     * @param Cookie $cookieHelper
     * @param Json $jsonHelper
     * @param PriceCurrency $price
     * @param PixelConfigurationInterface $pixelConfiguration
     * @param array $data
     */
    public function __construct(
        Context $context,
        ResolverInterface $locale,
        Cookie $cookieHelper,
        Json $jsonHelper,
        PriceCurrency $price,
        PixelConfigurationInterface $pixelConfiguration,
        array $data
    ) {
        parent::__construct($context, $data);
        $this->locale = $locale;
        $this->cookieHelper = $cookieHelper;
        $this->jsonHelper = $jsonHelper;
        $this->price = $price;
        $this->pixelConfiguration = $pixelConfiguration;
    }

    /**
     * @inheritdoc
     */
    public function _toHtml()
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
    public function getCurrencyCode()
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
    public function isCookieEnabled()
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

    /**
     * @param array $data
     * @return string
     */
    public function jsonEncode(array $data)
    {
        return $this->jsonHelper->serialize($data);
    }

    /**
     * @param $amount
     * @return float
     */
    public function formatPrice($amount)
    {
        return $this->price->roundPrice($amount);
    }

    /**
     * @param float $value
     * @return int
     */
    public function formatQty($value)
    {
        return (int) number_format($value, 2, '.', '');
    }
}
