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
use Magestat\FacebookPixel\Model\PixelConfigurationInterface;

/**
 * Class PixelCodeTest
 * @package Magestat\FacebookPixel\Test\Unit\Block
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
