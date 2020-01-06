<?php

namespace Magestat\FacebookPixel\Block;

use Magento\Cookie\Helper\Cookie;
use Magento\Catalog\Helper\Data;
use Magento\Checkout\Model\Session;
use Magento\Catalog\Model\Product;
use Magento\Directory\Model\PriceCurrency;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Item;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class PixelCode
 * Handle checkout data to be given to the pixel tracker.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Checkout extends AbstractPixel
{
    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var Quote|null
     */
    private $quote = null;

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
     * @param $item Item
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
     * @return Quote
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
    public function getCartContent(): string
    {
        $cart = [];
        /** @var Item $item */
        foreach ($this->getCurrentQuote()->getAllVisibleItems() as $item) {
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
     * @param Product $product
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
