# Facebook Pixel for Magento 2

This free Facebook Pixel extension allows you to track your visitors' actions by sending events to your Facebook Ads Manager and the Facebook Analytics dashboard where they can be used to analyze the effectiveness of your conversion funnel and to calculate your return on ad investment.

*This extension is also compatible with **[Magento Cookies Policy](https://docs.magento.com/m2/ce/user_guide/stores/compliance-cookie-restriction-mode.html)**.*

[![Build Status](https://travis-ci.org/williankeller/magento2-facebook-pixel.svg?branch=develop)](https://travis-ci.org/williankeller/magento2-facebook-pixel) [![Packagist](https://img.shields.io/packagist/v/magestat/module-facebook-pixel.svg)](https://packagist.org/packages/magestat/module-facebook-pixel) [![Downloads](https://img.shields.io/packagist/dt/magestat/module-facebook-pixel.svg)](https://packagist.org/packages/magestat/module-facebook-pixel)

## Compatibility
This is the tested versions:
```sh
 >= 2.3.1 EE/CE
```

## Installation

### Install via composer _(recommended)_

Run the following command in Magento 2 root folder:
```sh
composer require magestat/module-facebook-pixel
```

### Using GIT clone

Run the following command in Magento 2 root folder:
```sh
git clone git@github.com:williankeller/magento2-facebook-pixel.git app/code/Magestat/FacebookPixel
```

## Activation

Run the following command in Magento 2 root folder:
```sh
php bin/magento module:enable Magestat_FacebookPixel
```

```sh
php bin/magento setup:upgrade
```

Clear the caches:
```sh
php bin/magento cache:clean
```

## Configuration

1. **Stores** > **Configuration** > **MAGESTAT** > **Facebook Pixel**:
2. **Enable Module** tab, select **Enabled** option to enable the module (toggling per store).
3. **Settings** tab, Select option if you want to Include Product Taxes.
3. **Pixel ID** tab, Fill the Facebook Pixel Track Code ID.
4. **Track Options** tab, Select which events you want to track.

**Currently tracking:**
- Page view:
  - Content view
  - All and every page load
- Product page:
  - Content view
  - **Add to cart** event
- Checkout page:
  - Content view
  - **Initiate checkout** event
- Success page
  - Content view
  - **Purchase** event


## Missing an Event Track?

Let us know if your looking for a custom track or one of our events are not triggered properly.

## Contribution

Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).
If we like your suggestion we will add this request for free at the next releases.

## Support

If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/williankeller/magento2-facebook-pixel/issues).

© Magestat.
