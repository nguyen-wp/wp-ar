<?php
/**
 * Uninstall all N3Block data.
 *
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

$options = array(
	'n3custompost_db_version',
	'n3custompost_db_version_history',

	'n3custompost_instagram_token',
	'n3custompost_instagram_cache_timeout',
	'n3custompost_instagram_token_cron_error_message',

	'n3custompost_google_api_key',

	'n3custompost_mailchimp_api_key',

	'n3custompost_recaptcha_v2_site_key',
	'n3custompost_recaptcha_v2_secret_key',

	'n3custompost_section_content_width',
	'n3custompost_smooth_animation',

	'n3custompost_autoptimize',
	'n3custompost_aggregate_css',

	'n3custompost_load_assets_on_demand',
	'n3custompost_move_css_to_head',

	/*
	 * SELECT `option_name` FROM `wp_options` WHERE `option_name` LIKE '%n3custompost/%' LIMIT 100
	 */
	'n3custompost/accordion::disabled',
	'n3custompost/advanced-heading::disabled',
	'n3custompost/advanced-spacer::disabled',
	'n3custompost/anchor::disabled',
	'n3custompost/banner::disabled',
	'n3custompost/button-group::disabled',
	'n3custompost/circle-progress-bar::disabled',
	'n3custompost/contact-form::disabled',
	'n3custompost/content-timeline::disabled',
	'n3custompost/countdown::disabled',
	'n3custompost/counter::disabled',
	'n3custompost/custom-post-type::disabled',
	'n3custompost/icon-box::disabled',
	'n3custompost/icon::disabled',
	'n3custompost/image-box::disabled',
	'n3custompost/image-hotspot::disabled',
	'n3custompost/images-slider::disabled',
	'n3custompost/images-stack::disabled',
	'n3custompost/instagram::disabled',
	'n3custompost/mailchimp::disabled',
	'n3custompost/map::disabled',
	'n3custompost/media-text-slider::disabled',
	'n3custompost/person::disabled',
	'n3custompost/post-carousel::disabled',
	'n3custompost/post-slider::disabled',
	'n3custompost/price-box::disabled',
	'n3custompost/price-list::disabled',
	'n3custompost/progress-bar::disabled',
	'n3custompost/recent-posts::disabled',
	'n3custompost/section::disabled',
	'n3custompost/social-links::disabled',
	'n3custompost/table-of-contents::disabled',
	'n3custompost/table::disabled',
	'n3custompost/tabs::disabled',
	'n3custompost/template-library::disabled',
	'n3custompost/template-post-author::disabled',
	'n3custompost/template-post-button::disabled',
	'n3custompost/template-post-categories::disabled',
	'n3custompost/template-post-comments::disabled',
	'n3custompost/template-post-content::disabled',
	'n3custompost/template-post-custom-field::disabled',
	'n3custompost/template-post-date::disabled',
	'n3custompost/template-post-featured-background-image::disabled',
	'n3custompost/template-post-featured-image::disabled',
	'n3custompost/template-post-link::disabled',
	'n3custompost/template-post-meta::disabled',
	'n3custompost/template-post-tags::disabled',
	'n3custompost/template-post-title::disabled',
	'n3custompost/testimonial::disabled',
	'n3custompost/toggle::disabled',
	'n3custompost/video-popup::disabled',

	'n3custompost/template-acf-background-image::disabled',
	'n3custompost/template-acf-image::disabled',
	'n3custompost/template-acf-select::disabled',
	'n3custompost/template-acf-wysiwyg::disabled',
);

if ( ! is_multisite() ) {

	foreach ( $options as $option ) {
		delete_option( $option );
	}

	// Remove scheduled events.
	foreach ( array( 'n3custompost_refresh_instagram_token' ) as $event ) {
		if ( wp_get_schedule( $event ) ) {
			wp_clear_scheduled_hook( $event );
		}
	}

} else {

	global $wpdb;

	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

	foreach ( $blog_ids as $blog_id ) {

		switch_to_blog( $blog_id );

		foreach ( $options as $option ) {
			delete_option( $option );
		}

		// Remove scheduled events.
		foreach ( array( 'n3custompost_refresh_instagram_token' ) as $event ) {
			if ( wp_get_schedule( $event ) ) {
				wp_clear_scheduled_hook( $event );
			}
		}

		restore_current_blog();
	}

}

// All done.
