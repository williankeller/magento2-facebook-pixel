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

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Cookie\Helper\Cookie;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Directory\Model\PriceCurrency;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;
use Magento\Catalog\Helper\Data;

/**
 * Class ProductDetail
 * @package Magestat\FacebookPixel\Block
 */
class Product extends AbstractPixel
{
    /**
     * @var \Magento\Catalog\Helper\Data
     */
    private $catalogHelper;

    /**
     * Product constructor.
     * @param Context $context
     * @param ResolverInterface $locale
     * @param Cookie $cookieHelper
     * @param Json $jsonHelper
     * @param PriceCurrency $price
     * @param PixelConfigurationInterface $pixelConfiguration
     * @param Data $catalogHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ResolverInterface $locale,
        Cookie $cookieHelper,
        Json $jsonHelper,
        PriceCurrency $price,
        PixelConfigurationInterface $pixelConfiguration,
        Data $catalogHelper,
        array $data
    ) {
        parent::__construct($context, $locale, $cookieHelper, $jsonHelper, $price, $pixelConfiguration, $data);
        $this->catalogHelper = $catalogHelper;
    }

    /**
     * @return string
     */
    public function getCurrentProduct()
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->catalogHelper->getProduct();
        $data = [
            'id' => $product->getSku(),
            'name' => $product->getName(),
            'item_price' => $this->formatPrice($product->getPrice()),
            'quantity' => $product->getQty() ?: 1
        ];
        return $this->jsonEncode($data);
    }
}
