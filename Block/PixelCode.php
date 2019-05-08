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

use Magento\Cookie\Helper\Cookie;
use Magento\Directory\Model\PriceCurrency;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template\Context;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class PixelCode
 * @package Magestat\FacebookPixel\Block
 */
class PixelCode extends AbstractPixel
{
    /**
     * @var \Magestat\FacebookPixel\Model\PixelConfigurationInterface
     */
    private $pixelConfiguration;

    /**
     * Checkout constructor.
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
        parent::__construct($context, $locale, $cookieHelper, $jsonHelper, $price, $pixelConfiguration, $data);
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
}
