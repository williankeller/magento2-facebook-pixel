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
 * Class Success
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @package Magestat\FacebookPixel\Block
 */
class Success extends AbstractPixel
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Sales\Model\Order|null
     */
    private $quote = null;

    /**
     * Success constructor.
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
     * @param $item \Magento\Sales\Model\Order\Item
     * @return array
     */
    private function formatProduct($item)
    {
        $product = [];
        $product['id'] = $item->getSku();
        $product['name'] = $item->getName();
        $product['item_price'] = $item->getPrice();
        $product['quantity'] = $item->getQtyOrdered();

        return $product;
    }

    /**
     * @return \Magento\Sales\Model\Order
     */
    public function getCurrentQuote()
    {
        if (!$this->quote) {
            $this->quote = $this->checkoutSession->getLastRealOrder();
        }
        return $this->quote;
    }

    /**
     * @return string
     */
    public function getCartContent()
    {
        $cart = [];
        /** @var \Magento\Sales\Model\Order\Item $item */
        foreach ($this->getCurrentQuote()->getItems() as $item) {
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
        /** @var \Magento\Sales\Model\Order\Item $item */
        foreach ($this->getCurrentQuote()->getItems() as $item) {
            $skuList[] = $item->getSku();
        }
        return $this->jsonEncode($skuList);
    }

    /**
     * @return int
     */
    public function getCheckoutQty()
    {
        return $this->getCurrentQuote()->getTotalItemCount();
    }
}
