=== Pet Adoption Listings ===
Contributors: chrishardie
Tags: adoptable pets,adoption,pets,animals
Requires at least: 2.8
Tested up to: 4.2
License: GPL2
License URI: http://www.gnu.org/licenses/gpl.html

Display adoptable pets from an Adopt-a-Pet.com shelter's listings.

== Description ==
This plugin provides two easy ways to display listings of adoptable pets from a shelter's profile at Adopt-a-Pet.com via iframe.

The first way is with a shortcode `pet_adoption_listings` that can be included in any post or page content. When used it will show the shelter's available pets from their Adopt-a-Pet.com profile. The only required attribute is `shelter_id` (obtained from Adopt-a-Pet.com) but you can also specify the iframe width and height.

The second way is with a widget that can display available pets in your sidebar or wherever else widgets are in your theme. You can specify the Shelter's ID (required, obtained from Adopt-a-Pet.com), the types of pets to show (defaults to All), and the height of the listing.

All pet detail links will open in a new browser window or tab on the Adopt-a-Pet.com website.

Note that the plugin loads content from a third-party site via iframe, and so may introduce cookies, tracking codes, etc. in addition to those present on your WordPress site. This plugin and widget is in no way affiliated with or endorsed by Adopt-a-Pet.com or its partners.

Want to help make this plugin better? <a href="https://github.com/ChrisHardie/pet-adoption-listings">Pull requests are welcome</a>.

== Installation ==
1. Upload the `pet-adoption-listings` folder to the `/wp-content/plugins/` directory
2. Activate the Pet Adoption Listings plugin through the `Plugins` menu in the WordPress dashboard
3. Add the shortcode to a post, and define the `shortcode_id` attribute, and optionally `iframe_width` and `iframe_height`
4. Alternatively, add the widget to an available widget area and configure the options

== Screenshots ==
1. The shortcode definition in the post editor
2. The shortcode front-end display
3. The widget configuration options
4. The widget front-end display

== Changelog ==

= 1.0 =

* Initial release
