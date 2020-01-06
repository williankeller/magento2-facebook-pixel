<?php

namespace Magestat\FacebookPixel\Model;

/**
 * Interface PixelConfigurationInterface
 * @api
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
     * Should include tax configuration
     */
    const XML_PATH_FB_INC_TAX = 'magestat_facebook_pixel/settings/inc_tax';

    /**
     * @return bool
     */
    public function isEnabled();

    /**
     * @return bool
     */
    public function getPixelId();

    /**
     * @return bool
     */
    public function getIncludeTax();
}
