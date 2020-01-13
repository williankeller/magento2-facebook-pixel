<?php

namespace Magestat\FacebookPixel\Test\Unit\Block;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class ProductTest
 * Testing product
 *
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
