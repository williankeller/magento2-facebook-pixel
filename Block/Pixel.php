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

use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class Pixel
 * @package Peec\Facebook\Block
 */
class Pixel extends Template
{
    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    private $locale;

    /**
     * @var \Magestat\FacebookPixel\Model\PixelConfigurationInterface
     */
    private $pixelConfiguration;

    /**
     * Pixel constructor.
     * @param Context $context
     * @param array $data
     * @param ResolverInterface $locale
     * @param PixelConfigurationInterface $pixelConfiguration
     */
    public function __construct(
        Context $context,
        array $data,
        ResolverInterface $locale,
        PixelConfigurationInterface $pixelConfiguration
    ) {
        parent::__construct($context, $data);
        $this->locale = $locale;
        $this->pixelConfiguration = $pixelConfiguration;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale->getLocale();
    }

    /**
     * @return bool
     */
    public function getPixelId()
    {
        return $this->pixelConfiguration->getPixelId();
    }
}
