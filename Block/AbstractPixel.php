<?php

namespace Magestat\FacebookPixel\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Cookie\Helper\Cookie;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Directory\Model\PriceCurrency;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class AbstractPixel
 * Create class abstraction for each template
 */
abstract class AbstractPixel extends Template
{
    /**
     * @var ResolverInterface
     */
    private $locale;

    /**
     * @var Cookie
     */
    private $cookieHelper;

    /**
     * @var Json
     */
    private $jsonHelper;

    /**
     * @var PriceCurrency
     */
    private $price;

    /**
     * @var PixelConfigurationInterface
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
     * @throws NoSuchEntityException
     */
    public function getCurrencyCode()
    {
        return $this->_storeManager->getStore()->getBaseCurrencyCode();
    }

    /**
     * Return current website id.
     *
     * @return int
     * @throws LocalizedException
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
     * Round price
     *
     * @deprecated 102.0.1
     * @param float $amount
     * @return float
     */
    public function formatPrice($amount)
    {
        return $this->price->round($amount);
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
