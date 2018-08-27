<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package pet-adoption-listings
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 */
function pet_adoption_listings_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$index_js = 'pet-adoption-listings/index.js';
	wp_register_script(
		'pet-adoption-listings-block-editor',
		plugins_url( $index_js, __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
		filemtime( "$dir/$index_js" )
	);

	$editor_css = 'pet-adoption-listings/editor.css';
	wp_register_style(
		'pet-adoption-listings-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'pet-adoption-listings/style.css';
	wp_register_style(
		'pet-adoption-listings-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'pet-adoption-listings/pet-adoption-listings', array(
		'attributes'      => array(
			'shelter_id' => array(
				'type' => 'string',
			),
		),
		'editor_script'   => 'pet-adoption-listings-block-editor', // The script name we gave in the wp_register_script() call.
		'render_callback' => array( 'JCH_PetAdoptionListingsShortcode', 'pet_adoption_listings_shortcode' ),
	) );

}
add_action( 'init', 'pet_adoption_listings_block_init' );
