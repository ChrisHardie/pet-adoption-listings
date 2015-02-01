<?php

/*
Plugin Name: Pet Adoption Listings
Plugin URI: https://wordpress.org/plugins/pet-adoption-listings/
Description: Display adoptable pets from an Adopt-a-Pet.com shelter's listings
Version: 1.0
Author: Chris Hardie
Author URI: http://www.chrishardie.com/
License: GPL2
*/

/*

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

defined('ABSPATH') or die("Please don't try to run this file directly.");

class Pet_Adoption_Listings_Widget extends WP_Widget {
	/**
	 * Register the widget with WordPress
	 */
	function __construct() {
		parent::__construct(
			'pet_adoption_listings_widget', // base id
			__( 'Pet Adoption Listings Widget', 'pet_adoption_listings_widget_domain' ), // name
			array( 'description' => __( 'A widget to display adoptable pets from an Adopt-a-Pet.com shelter.', 'pet_adoption_listings_widget_domain' ) )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$shelter_id = apply_filters( 'widget_shelter_id', $instance['shelter_id'] );
		$iframe_height = apply_filters( 'widget_iframe_height', $instance['iframe_height'] );
		$clan_name = apply_filters( 'widget_clan_name', $instance['clan_name'] );

		// If the shelter_id isn't a valid number, we shouldn't even bother
		if ( ! $shelter_id || ! is_numeric( $shelter_id ) ) {
			echo '';
			return;
		}

		// If the iframe height isn't a valid number, set a default.
		if ( ! is_numeric( $iframe_height ) ) {
			$iframe_height = '450';
		}

		// Output the widget content
		echo $before_widget;

		// Title
		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		// Adapted from http://shelterblog.adoptapet.com/2014/01/add-your-pet-list-in-wordpress/
		// In future versions we could allow some customization to match the theme.
		echo '<div class="pet_adoption_listings_widget_main" style="text-align: center;">
			<iframe height="' . $iframe_height . '" frameborder="0" marginwidth="0" marginheight="0" scrolling="1"
			        src="https://searchtools.adoptapet.com/cgi-bin/searchtools.cgi/portable_pet_list?'
			 . 'shelter_id='
		     . $shelter_id
			 . '&clan_name='
		     . $clan_name
		     . '&title=&color=green&size=450x320_list&sort_by=pet_name&hide_clan_filter_p="></iframe>';

		// Show credit link
		if ( $instance['show_credit_p'] ) {

			echo '<div class="pet_adoption_listings_widget_credit" style="font-size: x-small;">Pet adoption and rescue <br/>powered by
				<a href="http://www.adoptapet.com/" title="Pet adoption and rescue powered by Adopt-a-Pet.com">Adopt-a-Pet.com</a>
			</div>';

		}

		echo '</div>';

		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['shelter_id'] = ( ! empty( $new_instance['shelter_id'] ) ) ? strip_tags( $new_instance['shelter_id'] ) : '';
		$instance['iframe_height'] = ( ! empty( $new_instance['iframe_height'] ) ) ? strip_tags( $new_instance['iframe_height'] ) : '';
		$instance['clan_name'] = ( ! empty( $new_instance['clan_name'] ) ) ? strip_tags( $new_instance['clan_name'] ) : '';
		$instance['show_credit_p'] = !empty($new_instance['show_credit_p']) ? 1 : 0;

		return $instance;

	}

	/**
	 * Back-end form to manage a widget's options in wp-admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Adoptable pets at our shelter:', 'pet_adoption_listings_widget_domain' );
		}
		if ( isset( $instance['clan_name'] ) ) {
			$current_clan_name = $instance['clan_name'];
		} else {
			$current_clan_name = 'all';
		}
		if ( isset( $instance['shelter_id'] ) ) {
			$shelter_id = $instance['shelter_id'];
		} else {
			$shelter_id = '';
		}
		if ( isset( $instance['iframe_height'] ) ) {
			$iframe_height = $instance['iframe_height'];
		} else {
			$iframe_height = 450;
		}

		// Should we show the credit link to Adopt-a-Pet.com? (Must be opt-in per WordPress.org guidelines.)
		$show_credit_p = isset( $instance['show_credit_p'] ) ? (bool) $instance['show_credit_p'] : false;

		// Define available pet types
		$clan_options = array(
			'all' => 'Show All Types of Pets',
			'dog' => 'Show Only Dogs',
			'cat' => 'Show Only Cats',
			'rabbit' => 'Show Only Rabbits',
			'bird' => 'Show Only Birds',
			'horse' => 'Show Only Horses',
			'small_animal' => 'Show Only Small Animals',
			'reptile' => 'Show Only Reptiles, Amphibians, and/or Fish',
			'farm_animal' => 'Show Only Farm-Type Animals',
		);

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'shelter_id' ); ?>"><?php _e( 'Shelter ID:' ); ?> (required, found at Adopt-a-Pet.com)</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'shelter_id' ); ?>"
			       name="<?php echo $this->get_field_name( 'shelter_id' ); ?>" type="text"
			       value="<?php echo esc_attr( $shelter_id ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'clan_name' ); ?>"><?php _e( 'Types of Pets to Show:' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'clan_name' ); ?>" id="<?php echo $this->get_field_id( 'clan_name' ); ?>">
				<?php foreach( array_keys( $clan_options ) as $clan_name ) : ?>
					<option value="<?php echo esc_attr($clan_name) ?>" <?php selected($clan_name, $current_clan_name); ?>><?php echo $clan_options[$clan_name]; ?></option>
				<?php endforeach; ?>
			</select>

		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'iframe_height' ); ?>"><?php _e( 'List Height (px):' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'iframe_height' ); ?>"
			       name="<?php echo $this->get_field_name( 'iframe_height' ); ?>" type="text"
			       value="<?php echo esc_attr( $iframe_height ); ?>">
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_credit_p ); ?> id="<?php echo $this->get_field_id( 'show_credit_p' ); ?>" name="<?php echo $this->get_field_name( 'show_credit_p' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_credit_p' ); ?>"><?php _e( 'Include credit link to Adopt-a-Pet.com?' ); ?></label>
		</p>
	<?php

	}

}

class JCH_PetAdoptionListingsShortcode {

	public function pet_adoption_listings_shortcode( $atts, $content=null ) {
		$atts = shortcode_atts( array(
			'shelter_id' => '',
			'clan_name' => 'all',
			'iframe_height' => '450',
			'iframe_width' => '500',
		), $atts, 'pet_adoption_listings' );

		// If the shelter_id isn't a valid number, we shouldn't even bother
		if ( ! $atts['shelter_id'] || ! is_numeric( $atts['shelter_id'] ) ) {
			return;
		}

		// If the iframe height isn't a valid number, set a default.
		if ( ! is_numeric( $atts['iframe_height'] ) ) {
			$atts['iframe_height'] = '450';
		}
		// If the iframe width isn't a valid number, set a default.
		if ( ! is_numeric( $atts['iframe_width'] ) ) {
			$atts['iframe_width'] = '500';
		}

		// Adapted from http://shelterblog.adoptapet.com/2014/01/add-your-pet-list-in-wordpress/
		$petlist = '<div class="pet_adoption_listings_shortcode_main" style="text-align: center;">
			<iframe width="' . $atts['iframe_width'] . '" height="' . $atts['iframe_height'] . '" frameborder="0" marginwidth="0" marginheight="0" scrolling="1"
			        src="https://searchtools.adoptapet.com/cgi-bin/searchtools.cgi/portable_pet_list?'
		     . 'shelter_id='
		     . $atts['shelter_id']
		     . '&clan_name='
		     . $atts['clan_name']
		     . '&title=&color=green&size=450x320_list&sort_by=pet_name&hide_clan_filter_p="></iframe></div>';

		return $petlist;

	}
}


class JCH_PetAdoptionListings {
	function __construct() {
		add_action( 'init', array( $this, 'init' ), 1 );
	}

	public function init() {
		register_widget( 'Pet_Adoption_Listings_Widget' );
		add_shortcode( 'pet_adoption_listings', array( 'JCH_PetAdoptionListingsShortcode', 'pet_adoption_listings_shortcode' ) );
	}


}

$jch_pet_adoption_listings = new JCH_PetAdoptionListings();

?>
