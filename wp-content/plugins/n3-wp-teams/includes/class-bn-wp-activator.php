<?php

/**
 * Fired during plugin activation
 *
 * @link       nguyenpham.pro
 * @since      1.0.0
 *
 * @package    MADE_WP_TEAMS
 * @subpackage MADE_WP_TEAMS/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    MADE_WP_TEAMS
 * @subpackage MADE_WP_TEAMS/includes
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class MADE_WP_TEAMS_Activator {

	public function __construct() {

		// $this->madelab_add_my_assets_page();

	}

	public static function activate() {
		// self::madelab_add_my_assets_page();
	}

	public function madelab_add_my_assets_page() {
		// Create post object
		$my_post = array(
			'post_title'    => 'ASSETS',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_name'      => 'assets',
			'comment_status' => 'closed',
            'ping_status'    => 'closed',
			'post_type'     => 'page',
			'post_content'  => '[n3_teams]',
			// 'page_template'  => 'template-assets.php'
		);
	
		// Insert the post into the database
		wp_insert_post( $my_post );
		update_option( 'mytheme_installed', true );
	}

}
