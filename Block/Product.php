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

use Magento\Catalog\Helper\Data;
use Magento\Cookie\Helper\Cookie;
use Magento\Catalog\Model\Product as CatalogProduct;
use Magento\Directory\Model\PriceCurrency;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template\Context;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class ProductDetail
 * Handle product detail data to be given to the pixel tracker.
 */
class Product extends AbstractPixel
{
    /**
     * @var Data
     */
    private $catalogHelper;

    /**
     * @var PixelConfigurationInterface
     */
    private $pixelConfiguration;

    /**
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
        $this->pixelConfiguration = $pixelConfiguration;
    }

    /**
     * @return string
     */
    public function getCurrentProduct(): string
    {
        /** @var CatalogProduct $product */
        $product = $this->catalogHelper->getProduct();
        $data = [
            'id' => $product->getSku(),
            'name' => $product->getName(),
            'item_price' => $this->formatPrice($this->productPrice($product)),
            'quantity' => $product->getQty() ?: 1
        ];
        return $this->jsonEncode($data);
    }

    /**
     * @param CatalogProduct $product
     * @return float
     */
    private function productPrice($product)
    {
        if ($this->pixelConfiguration->getIncludeTax()) {
            return $this->catalogHelper->getTaxPrice($product, $product->getFinalPrice(), true);
        }
        return $product->getFinalPrice();
    }
}
