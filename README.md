# Facebook Pixel for Magento 2

This extension allow you integrate the Facebook pixel to track your website visitors' actions. Tracked conversions appear in the Facebook Ads Manager and the Facebook Analytics dashboard, where they can be used to analyze the effectiveness of your conversion funnel and to calculate your return on ad investment. Our extension is also compatible with Magento cookies permissions. 

[![Build Status](https://travis-ci.org/magestat/magento2-facebook-pixel.svg?branch=develop)](https://travis-ci.org/magestat/magento2-facebook-pixel) [![Packagist](https://img.shields.io/packagist/v/magestat/module-facebook-pixel.svg)](https://packagist.org/packages/magestat/module-facebook-pixel) [![Downloads](https://img.shields.io/packagist/dt/magestat/module-facebook-pixel.svg)](https://packagist.org/packages/magestat/module-facebook-pixel)

## 1. Installation

### Install via composer (recommend)

Run the following command in Magento 2 root folder:
```sh
composer require magestat/module-facebook-pixel
```

### Using GIT clone

Run the following command in Magento 2 root folder:
```sh
git clone git@github.com:magestat/magento2-facebook-pixel.git app/code/Magestat/FacebookPixel
```

## 2. Activation

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

## 3. Configuration

1. Go to **Stores** > **Configuration** > **Magestat** > **Facebook Pixel**:
2. Under **Enable Module** tab, select **Enabled** option to enable the module (possible per store).
3. Under **Pixel ID** tab, Fill the Facebook Pixel Track Code ID.
4. Under **Track Options** tab, Select which events you want to track.

**Currently tracking:**
- Page view:
  - All page load
- Product page:
  - Content view
  - Add to cart
- Cart page:
  - Content view
- Checkout page:
  - Initiate checkout
- Success page
  - Purchase event


## Missing an Event Track?
Let us know if your looking for a custom track or one of our events are not triggered properly.
We

## Contribution

Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).
If we like your suggestion we will add this request for free at the next releases.

## Support

If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/magestat/magento2-facebook-pixel/issues).

Need help setting up or want to customize this extension to meet your business needs? Please open an issue and if we like your idea we will add this feature for free or at a discounted rate.

© Magestat.
