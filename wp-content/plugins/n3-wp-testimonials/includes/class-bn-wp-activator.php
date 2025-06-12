<?php

/**
 * Fired during plugin activation
 *
 * @link       nguyenpham.pro
 * @since      1.0.0
 *
 * @package    MADE_WP_TESTIMONIAL
 * @subpackage MADE_WP_TESTIMONIAL/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    MADE_WP_TESTIMONIAL
 * @subpackage MADE_WP_TESTIMONIAL/includes
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class MADE_WP_TESTIMONIAL_Activator {


	public static function activate() {
		// self::madelab_add_my_fqas_page();
	}

	public function madelab_add_my_fqas_page() {
		// Create post object
		$my_post = array(
			'post_title'    => 'TESTIMONIAL',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_name'      => 'testimonials',
			'comment_status' => 'closed',
            'ping_status'    => 'closed',
			'post_type'     => 'page',
			'post_content'  => '[n3_testimonials]',
			// 'page_template'  => 'template-testimonials.php'
		);
	
		// Insert the post into the database
		wp_insert_post( $my_post );
		update_option( 'mytheme_installed', true );
	}

}
