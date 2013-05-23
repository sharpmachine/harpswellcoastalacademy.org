=== Donation Thermometer ===
Contributors: henryp
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8NVX34E692T34
Tags: donate, donation, thermometer, progress, meter, red, fundraising, funds, money, funds, charity, non-profit, farbtastic
Requires at least: 2.7
Tested up to: 3.5.1
Stable tag: 1.3.1
License: GPL3

Displays a custom thermometer image charting the amount of donations raised.

== Description ==

'Donation Thermometer' uses a simple shortcode to display classic-style thermometers on your WordPress site for your fund-raising activities.

The thermometer images are completely customisable with options available to change the fill and text colours. You can also choose to display the target, amount raised, percentage raised, and the currency symbol of your choice. Colour schemes and default values are controlled from the settings page. 

The output thermometers blend seamlessly with your website content on any post or page. Simply use the shortcode **[thermometer raised=?? target=??]**. Width, height, align, currency, and alt text are optional parameters.

NEW FEATURE (v1.3): The 'raised' and 'target' values are now linked to independent shortcodes (**[therm_r]** and **[therm_t]**), controlled from the plugin's settings page; useful for keeping multiple instances up-to-date around your site. Also useful if you want to keep a running total in your site footer/sidebar.


== Installation ==

1. Extract and upload the contents of the zip file to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the options from the settings page.
4. Insert the shortcode **[thermometer raised=?? target=??]** into any post or page (insert numbers for ??).

== Frequently Asked Questions ==

= I get an error message "Fatal error: Call to undefined function imagecreatefrompng..." =

It is likely the GD library (required to create images) is not installed on your server - check by creating a phpinfo file and contact your hosting support.

= The shortcodes don't work in text widgets. =

WordPress only enables shortcodes in posts and pages by default. Go to the theme editor and load the functions.php file, then add the following line to the bottom: add_filter('widget_text', 'do_shortcode');

= The [therm_r] and [therm_t] shortcodes show different values to the thermometers. =

Values for these shortcodes are set on the Thermometer settings page. If you want your thermometers to display the same values, remove the 'raised' and 'target' parameters from the **[thermometer]** shortcode, e.g. **[thermometer width=300 align=right]**. Values given in the shortcode will overrule those on the settings page.

= How do I use the alt parameter? = 

This option will change the title and alt text attributes of the thermometer image. To toggle off, type alt=off. To enter custom text, type alt='your custom text' (include apostrophes). If the option is left out the default text 'Raised xxxx towards the xxxx target.' will appear.

= Can I remove the currency symbol? =

Yes! Select the empty option on the settings page dropdown menu, or enter currency=null in the thermometer shortcode, e.g. **[thermometer currency=null]**.

= Where can I request a feature? =

Visit the [the plugin homepage](http://henrypatton.org/donation-thermometer) and leave a comment.

== Screenshots ==

1. Settings page
2. Displayed on a page

== Changelog ==

= 1.3.1 =
* New 'alt' parameter for the [thermometer] shortcode: toggle the thermometer's alt & title off, or use custom text.
* Added option for different raised/target value text colours.
* Fix for servers with allow_url_fopen directive set to off.
* Added a 'donate' link for the developer ;)

= 1.3 =
* New shortcodes for 'raised' and 'target' values ([therm_r] and [therm_t]).
* Addressed memory issues concerning the generation of images.
* A new parameter in the thermometer shortcode now allows for custom currency symbols.
* Image width now dynamically adjusts depending on the total raised.
* Target and percentage values change font size depending on string length.
* Horizontal and vertical margins added to the thermometer image.

= 1.2.2 =
* Improved the fail-safe that makes sure thermometers exist before page load.

= 1.2.1 =
* Code improvements including for align issues, the image title text and references to file paths.

= 1.2 =
* New Feature: Multiple thermometers with varying targets/amounts raised now possible. 
* Target/amount raised values now moved from the settings page to the shortcode parameters.
* Included a cache feature which clears thermometer images on the server after 1 week.

= 1.1.2 =
* Fixed a bug that may have stopped the thermometer appearing in Internet Explorer.
* Helped an image resampling issue present in some browsers.

= 1.1.1 =
* Custom colour option for raised/target text added.

= 1.1 =
* Option added to use custom colours for the thermometer and percentage text. 
* Accuracy of the thermometer-fill and gauge improved to the nearest target unit.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =