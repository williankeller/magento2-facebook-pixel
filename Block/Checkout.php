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
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Directory\Model\PriceCurrency;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Helper\Data;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class PixelCode
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @package Magestat\FacebookPixel\Block
 */
class Checkout extends AbstractPixel
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Quote\Model\Quote|null
     */
    private $quote = null;

    /**
     * @var \Magento\Catalog\Helper\Data
     */
    private $catalogHelper;

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
     * @param Session $checkoutSession
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
        Session $checkoutSession,
        Data $catalogHelper,
        array $data
    ) {
        parent::__construct($context, $locale, $cookieHelper, $jsonHelper, $price, $pixelConfiguration, $data);
        $this->checkoutSession = $checkoutSession;
        $this->catalogHelper = $catalogHelper;
        $this->pixelConfiguration = $pixelConfiguration;
    }

    /**
     * Format product item for output to json
     *
     * @param $item \Magento\Quote\Model\Quote\Item
     * @return array
     */
    private function formatProduct($item)
    {
        $product = [];
        $product['id'] = $item->getSku();
        $product['name'] = $item->getName();
        $product['item_price'] = $this->formatPrice($this->productPrice($item));
        $product['quantity'] = $this->formatQty($item->getQty());

        return $product;
    }

    /**
     * @return \Magento\Quote\Model\Quote
     */
    public function getCurrentQuote()
    {
        if (!$this->quote) {
            $this->quote = $this->checkoutSession->getQuote();
        }
        return $this->quote;
    }

    /**
     * @return string
     */
    public function getCartContent()
    {
        $cart = [];
        /** @var \Magento\Quote\Model\Quote\Item $item */
        foreach ($this->getCurrentQuote()->getAllVisibleItems() as $item) {
            $cart[] = $this->formatProduct($item);
        }
        return $this->jsonEncode($cart);
    }

    /**
     * @return string
     */
    public function getSkuList()
    {
        $skuList = [];
        /** @var \Magento\Quote\Model\Quote\Item $item */
        foreach ($this->getCurrentQuote()->getAllVisibleItems() as $item) {
            $skuList[] = $item->getSku();
        }
        return $this->jsonEncode($skuList);
    }

    /**
     * @return int
     */
    public function getCheckoutQty()
    {
        return $this->formatQty(
            $this->getCurrentQuote()->getItemsQty()
        );
    }

    /**
     * @return float
     */
    public function getCheckoutTotal()
    {
        return $this->formatPrice(
            $this->getCurrentQuote()->getBaseGrandTotal()
        );
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
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
