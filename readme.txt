=== Nice Testimonials ===
Contributors: nicethemes
Tags: testimonials, client testimonials, plugin, testimonials plugin, widget, testimonial, responsive
Requires at least: 3.6
Tested up to: 4.8
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Show quotes from your customers in a beautiful and organized way.

== Description ==

= Display your client testimonials in a clean, responsive and beautiful way. You can show your testimonials using a shortcode or template tags (PHP functions).=

This plugin is fully integrated with WordPress. It includes a huge set of hooks, so you can customize it in any way you need.

**Nice Testimonials** works right out of the box with any theme.

= Comprehensive settings page =

Define how your testimonials are displayed without having to code with our intuitive settings page. You can set the maximum number of testimonials to show, the number of columns to use, which fields to display, how items should be ordered and a lot more.

= Shortcode =

You can use the `testimonials` shortcode to show your testimonials anywhere you want from your editor.

> [testimonials]

[See the entire list of parameters](https://wordpress.org/plugins/nice-testimonials/faq/)

= PHP Function =

You can use the `nice_testimonials();` function to show your testimonials in any template.

> nice_testimonials();

[See the entire list of parameters](https://wordpress.org/plugins/nice-testimonials/faq/)

= Author information =

Full testimonial details, such as client's name, image and website.

= Widgets =

Display your testimonials using a widget instead of having them in the content area.


= Mobile friendly =

**Nice Testimonials** includes a responsive layout, and gives you the possibility to define the number of columns you want to show.

= Developer friendly =

**Nice Testimonials** is developed following the [WordPress Coding Standards](http://codex.wordpress.org/WordPress_Coding_Standards). It relies on WordPress [Post Types](http://codex.wordpress.org/Post_Types), and includes a huge set of hooks and pluggable functions and classes, so you can customize it in any way you need.

> **[Learn how to use the shortcode and the function in the FAQ section](https://wordpress.org/plugins/nice-testimonials/faq/)**

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the "Add New" link in the plugins dashboard.
2. Search for "**Nice Testimonials**".
3. Click "Install Now".
4. Activate the plugin on the Plugin dashboard.

= Uploading in WordPress Dashboard =

1. Navigate to the "Add New" in the plugins dashboard.
2. Navigate to the "Upload" area.
3. Select `nice-testimonials.zip` from your computer.
4. Click "Install Now".
5. Activate the plugin in the Plugin dashboard.

= Using FTP =

1. Download `nice-testimonials.zip`.
2. Extract the `nice-testimonials` directory to your computer.
3. Upload the `nice-testimonials` directory to the `/wp-content/plugins/` directory.
4. Activate the plugin in the Plugin dashboard.

== Frequently Asked Questions ==

= How to set up the plugin? =

Once you installed and activated the plugin, you can go to *Testimonials > Settings* and tweak the options there. Those settings will also be used as the default ones for the shortcode and template tag when you're not specifying any values for them.

= How to use the shortcode? =

The basic usage of the shortcode is just `[testimonials]`. That will display a list of your testimonials using the settings you entered in *Testimonials > Settings*.

However, you can specify values for the shortcode using the following fields:

* **`id`**: Numeric ID for a single testimonial to be displayed.
* **`columns`**: The number of columns to be displayed in a list of testimonials.
* **`limit`**: The maximum number of testimonials to be displayed in a list. A value of zero means nothing will be displayed. You can use `-1` for no limit.
* **`image_size`**: The size (in pixels) of your testimonial image.
* **`orderby`**: The ordering criteria that will be used to display your testimonials. Accepted values: `ID`, `title`, `menu_order`, `date`, `random`.
* **`order`**: The sorting criteria that will be used to display your testimonials. Accepted values: `asc` (ascendant), `desc` (descendant).
* **`category`**: Comma-separated numeric IDs of testimonial categories that you want to display. A value of zero means that all categories will be considered.
* **`exclude_category`**: Comma-separated numeric IDs of testimonial categories that you want to exclude. A value of zero means that no categories will be excluded.
* **`include_children`**: Choose if you want to display testimonials from sub-categories. Accepted values: `1` (display), `0` (not display).
* **`author`**: Choose if you want to see the name of the testimonial's author. Accepted values: `1` (display), `0` (not display).
* **`avatar`**: Choose if you want to see the image of the testimonial's author. Accepted values: `1` (display), `0` (not display).
* **`url`**: Choose if you want to display a link to the website of the testimonial's author. Accepted values: `1` (display), `0` (not display).
* **`avatar_link`**: Choose if you want the image of the testimonial's author to link to the author's website. Accepted values: `1` (display), `0` (not display).
* **`avoidcss`**: Choose if you want to remove the default styles for the current list of testimonials. Accepted values: `1` (avoid styles), `0` (not avoid styles).

If any of these values is not declared explicitly, the default value will be the one set in *Testimonials > Settings*.

A typical usage of the shortcode with these fields would be the following:

`[testimonials columns="2" limit="5" image_size="120" order="date" sort="asc"]`

= How to use the template tag (PHP function)? =

You can include testimonials in your own templates by using our `nice_testimonials()` function. This is a very basic usage example:

```
<?php
if ( function_exists( 'nice_testimonials' ) ) :
	nice_testimonials();
endif;
?>
```

As it happens with the shortcode, that code snippet will display a list of your testimonials using the settings you entered in *Testimonials > Settings*. However, you can give the function an array of options with specific values on how to show the list of testimonials:

* **`id`**: Numeric ID for a single testimonial to be displayed.
* **`columns`**: The number of columns to be displayed in a list of testimonials.
* **`limit`**: The maximum number of testimonials to be displayed in a list. A value of zero means nothing will be displayed. You can use `-1` for no limit.
* **`image_size`**: The size (in pixels) of your testimonial image.
* **`orderby`**: The ordering criteria that will be used to display your testimonials. Accepted values: `ID`, `title`, `menu_order`, `date`, `random`.
* **`order`**: The sorting criteria that will be used to display your testimonials. Accepted values: `asc` (ascendant), `desc` (descendant).
* `category`**: Comma-separated numeric IDs of testimonial categories that you want to display. A value of zero means that all categories will be considered.
* **`exclude_category`**: Comma-separated numeric IDs of testimonial categories that you want to exclude. A value of zero means that no categories will be excluded.
* **`include_children`**: Choose if you want to display testimonials from sub-categories. Accepted values: `1` (display), `0` (not display).
* **`author`**: Choose if you want to see the name of the testimonial's author. Accepted values: `1` (display), `0` (not display).
* **`avatar`**: Choose if you want to see the image of the testimonial's author. Accepted values: `1` (display), `0` (not display).
* **`url`**: Choose if you want to display a link to the website of the testimonial's author. Accepted values: `1` (display), `0` (not display).
* `avatar_link`**: Choose if you want the image of the testimonial's author to link to the author's website. Accepted values: `1` (display), `0` (not display).
* **`avoidcss`**: Choose if you want to remove the default styles for the current list of testimonials. Accepted values: `1` (avoid styles), `0` (not avoid styles).

If any of these values is not declared explicitly, the default value will be the one set in *Testimonials > Settings*.

Using these options, you can have something like this in your code:

```
<?php
if ( function_exists( 'nice_testimonials' ) ) :
	nice_testimonials( array(
		'columns'    => 2,
		'limit'      => 5,
		'image_size' => 96,
		'order'      => 'date',
		'sort'       => 'asc',
	) );
endif;
?>
```

= How can I use my own CSS? =

You can load a custom stylesheet by using [`wp_enqueue_script()`](http://codex.wordpress.org/Function_Reference/wp_enqueue_script) and adding your custom CSS to your own file. However, if you *really* want to get rid of the default CSS of **Nice Testimonials**, so you can avoid overriding our styles, you can check the "Avoid Plugin CSS" option in *Testimonials > Settings*.

== Screenshots ==

1. Nice Testimonials Settings page.
2. Testimonial details.
3. How testimonials look.

== Changelog ==

= 1.0.2 =
* Fix: Obtain admin path using `ABSPATH` constant.

= 1.0.1 =
* Specify thumbnail size when obtaining testimonial images using `nice_image()`.
* Make text domains load on `plugins_loaded`.
* Fix potential edge case concerning current select values not being correctly pre-selected inside meta boxes.

= 1.0 =
* First public release.
