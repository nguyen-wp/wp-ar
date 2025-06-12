<?php

if ( ! function_exists( 'n3custompost_blocks_no_items_found' ) ) :
	/*
	 * Displays message when there are no posts to display
	 */
	function n3custompost_blocks_no_items_found( $attributes, $content ) {
		?><p><?php echo esc_html__( 'Nothing found.', 'n3custompost' ); ?></p><?php
	}
endif;

add_action( 'n3custompost/blocks/post-slider/no-items', 'n3custompost_blocks_no_items_found', 10, 2 );
add_action( 'n3custompost/blocks/custom-post-type/no-items', 'n3custompost_blocks_no_items_found', 10, 2 );
add_action( 'n3custompost/blocks/post-carousel/no-items', 'n3custompost_blocks_no_items_found', 10, 2 );
add_action( 'n3custompost/blocks/recent-posts/no-items', 'n3custompost_blocks_no_items_found', 10, 2 );
