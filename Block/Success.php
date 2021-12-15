<?php

namespace Magestat\FacebookPixel\Block;

use Magento\Checkout\Model\Session;
use Magento\Cookie\Helper\Cookie;
use Magento\Directory\Model\PriceCurrency;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Item;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class Success
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * Handle the success-page from checkout data to be given to the pixel tracker.
 */
class Success extends AbstractPixel
{
    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var Order|null
     */
    private $quote = null;

    /**
     * @param Context $context
     * @param ResolverInterface $locale
     * @param Cookie $cookieHelper
     * @param Json $jsonHelper
     * @param PriceCurrency $price
     * @param PixelConfigurationInterface $pixelConfiguration
     * @param Session $checkoutSession
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
        array $data
    ) {
        parent::__construct($context, $locale, $cookieHelper, $jsonHelper, $price, $pixelConfiguration, $data);
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Format product item for output to json
     *
     * @param $item Item
     * @return array
     */
    private function formatProduct($item): array
    {
        $product = [];
        $product['id'] = $item->getSku();
        $product['name'] = $item->getName();
        $product['item_price'] = $this->formatPrice($item->getPrice());
        $product['quantity'] = $this->formatQty($item->getQtyOrdered());

        return $product;
    }

    public function getOrderId(): string
    {
        return $this->getCurrentQuote()->getRealOrderId();
    }

    /**
     * @return Order
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
    public function getCartContent(): string
    {
        $cart = [];
        /** @var Item $item */
        foreach ($this->getCurrentQuote()->getItems() as $item) {
            $cart[] = $this->formatProduct($item);
        }
        return $this->jsonEncode($cart);
    }

    /**
     * @return string
     */
    public function getSkuList(): string
    {
        $skuList = [];
        /** @var Item $item */
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
        return $this->formatQty(
            $this->getCurrentQuote()->getTotalItemCount()
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
}
