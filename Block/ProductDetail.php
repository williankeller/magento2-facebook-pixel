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

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class ProductDetail
 * @package Magestat\FacebookPixel\Block
 */
class ProductDetail extends Template
{
    /**
     * @var Product
     */
    private $_product = null;

    /**
     * @var \Magento\Catalog\Helper\Data
     */
    private $catalogHelper;

    /**
     * @var \Magestat\FacebookPixel\Model\PixelConfigurationInterface
     */
    private $pixelConfiguration;

    /**
     * ProductDetail constructor.
     * @param Context $context
     * @param array $data
     * @param CatalogHelper $catalogHelper
     * @param PixelConfigurationInterface $pixelConfiguration
     */
    public function __construct(
        Context $context,
        array $data,
        CatalogHelper $catalogHelper,
        PixelConfigurationInterface $pixelConfiguration
    ) {
        parent::__construct($context, $data);
        $this->catalogHelper = $catalogHelper;
        $this->pixelConfiguration = $pixelConfiguration;
    }

    /**
     * @inheritdoc
     */
    protected function _toHtml()
    {
        if (!$this->pixelConfiguration->isEnabled()) {
            return '';
        }
        return parent::_toHtml();
    }

    /**
     * @return \Magento\Catalog\Model\Product|Product|null
     */
    public function getCurrentProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->catalogHelper->getProduct();
        }
        return $this->_product;
    }

    /**
     * @return \Magento\Catalog\Model\Category|null
     */
    public function getCurrentCategory()
    {
        return $this->catalogHelper->getCategory();
    }
}
