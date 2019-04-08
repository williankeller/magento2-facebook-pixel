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

namespace Magestat\FacebookPixel\Model;

/**
 * Interface PixelConfigurationInterface
 * @api
 * @package Magestat\FacebookPixel\Model
 */
interface PixelConfigurationInterface
{
    /**
     * Is enabled configuration
     */
    const XML_PATH_ENABLE = 'magestat_facebook_pixel/module/enabled';

    /**
     * Facebook Pixel ID track code
     */
    const XML_PATH_FB_PIXEL_ID = 'magestat_facebook_pixel/options/pixel_id';

    /**
     * @return bool
     */
    public function isEnabled();

    /**
     * @return bool
     */
    public function getPixelId();
}
