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

namespace Magestat\FacebookPixel\Test\Unit\Block;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class ProductTest
 * @package Magestat\FacebookPixel\Test\Unit\Block
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ProductTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magestat\FacebookPixel\Block\Product
     */
    protected $block;

    /**
     * @var ObjectManagerHelper
     */
    protected $objectManagerHelper;

    /**
     * @var \Magento\Catalog\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $catalogHelper;

    /**
     * @var \Magestat\FacebookPixel\Model\PixelConfigurationInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pixelConfiguration;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->catalogHelper = $this->createMock(CatalogHelper::class);
        $this->pixelConfiguration = $this->createMock(PixelConfigurationInterface::class);

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->block = $this->objectManagerHelper->getObject(
            \Magestat\FacebookPixel\Block\Product::class,
            [
                'data' => [],
                'catalogHelper' => $this->catalogHelper,
                'pixelConfiguration' => $this->pixelConfiguration
            ]
        );
    }

    public function testGetCurrentProduct()
    {
        $productMock = $this->createMock(\Magento\Catalog\Model\Product::class);
        $this->catalogHelper->expects($this->once())
            ->method('getProduct')
            ->willReturn($productMock);

        $this->pixelConfiguration
            ->expects($this->once())
            ->method('getIncludeTax')
            ->willReturn(true);

        $this->catalogHelper->expects($this->once())
            ->method('getTaxPrice')
            ->with($productMock, $productMock->getFinalPrice(), true)
            ->will($this->returnValue($productMock->getFinalPrice()));

        $this->block->getCurrentProduct();
    }
}
