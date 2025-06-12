<?php

namespace N3Block;

/**
 * Class Post Template Part
 * @package N3Block
 */
class PostTemplatePart {

	public $postType = 'n3custompost';

	/**
	 * PostTemplatePart constructor.
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'register_post_type' ] );
	}

	public function register_post_type(){
		$labels = array(
			'name' => __( 'Post Templates', 'n3custompost' ),
			'singular_name' => __( 'Post Template', 'n3custompost' ),
			'menu_name' => __( 'N3 Template', 'n3custompost' ),
			'add_new' => __( 'New Template', 'n3custompost' ),
			'add_new_item' => __( 'Add New Template', 'n3custompost' ),
			'edit_item' => __( 'Edit Template', 'n3custompost' ),
			'new_item' => __( 'New Template', 'n3custompost' ),
			'view_item' => __( 'View Template', 'n3custompost' ),
			'search_items' => __( 'Search Templates', 'n3custompost' ),
			'not_found' =>  __( 'No templates found', 'n3custompost' ),
			'not_found_in_trash' => __( 'No templates found in Trash', 'n3custompost' ),
		);
		$args = array(
			'labels' => $labels,
			'has_archive' => true,
			'public' => true,
			'exclude_from_search' => true,
			'show_in_nav_menus' => true,
			'show_in_admin_bar' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => true,
			'menu_position' => 38,
			'menu_icon' => 'dashicons-category',
			'supports' => array(
				'title',
				'editor',
				'author',
				'revisions',
			),
			'capabilities'        => array(
				'publish_posts'       => 'administrator',
				'edit_others_posts'   => 'administrator',
				'delete_posts'        => 'administrator',
				'delete_others_posts' => 'administrator',
				'read_private_posts'  => 'administrator',
				'edit_post'           => 'administrator',
				'edit_posts' 		  => 'administrator',
				'delete_post'         => 'administrator',
				'read_post'           => 'administrator',
				'create_posts'       => 'administrator',
			),
			'rewrite' => false,
			'show_in_rest' => true,
			'template' => array(
				array (
					'n3custompost/template-post-layout-helper',
				),
			),
		);

		register_post_type( $this->postType, $args );
	}

}
