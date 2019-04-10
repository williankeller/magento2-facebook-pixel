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
use Magento\Checkout\Model\Session;
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
     * Checkout constructor.
     * @param Context $context
     * @param ResolverInterface $locale
     * @param Cookie $cookieHelper
     * @param Json $jsonHelper
     * @param PixelConfigurationInterface $pixelConfiguration
     * @param Session $checkoutSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        ResolverInterface $locale,
        Cookie $cookieHelper,
        Json $jsonHelper,
        PixelConfigurationInterface $pixelConfiguration,
        Session $checkoutSession,
        array $data
    ) {
        parent::__construct($context, $locale, $cookieHelper, $jsonHelper, $pixelConfiguration, $data);
        $this->checkoutSession = $checkoutSession;
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
        $product['item_price'] = $item->getPrice();
        $product['quantity'] = $item->getQty();

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
        return $this->getCurrentQuote()->getItemsQty();
    }

    /**
     * @return float
     */
    public function getCheckoutTotal()
    {
        return $this->getCurrentQuote()->getBaseSubtotal();
    }
}
