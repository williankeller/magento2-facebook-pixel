<?php

namespace Magestat\FacebookPixel\Test\Unit\Block;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class PixelCodeTest
 * Testing Pixel code
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PixelCodeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magestat\FacebookPixel\Block\PixelCode
     */
    protected $block;

    /**
     * @var ObjectManagerHelper
     */
    protected $objectManagerHelper;

    /**
     * @var \Magestat\FacebookPixel\Model\PixelConfigurationInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pixelConfiguration;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->pixelConfiguration = $this->createMock(PixelConfigurationInterface::class);

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->block = $this->objectManagerHelper->getObject(
            \Magestat\FacebookPixel\Block\PixelCode::class,
            [
                'data' => [],
                'pixelConfiguration' => $this->pixelConfiguration
            ]
        );
    }

    public function testToHtml()
    {
        $this->pixelConfiguration
            ->expects($this->atLeastOnce())
            ->method('isEnabled')
            ->willReturn(true);

        $this->block->toHtml();
    }
}
