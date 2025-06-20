<?php
/**
 * Title: Header
 * Slug: restoreconstruction/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Header with site title and navigation.
 *
 * @package WordPress
 * @subpackage N3_Commercial_Realty
 * @since Restore Construction 1.0
 */

?>
	<!-- wp:pattern {"slug":"restoreconstruction/topheader"} /-->
	<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
	<div id="header" class="wp-block-group alignfull" style="padding-top:0;padding-bottom:0"><!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-5"}}},"spacing":{"padding":{"top":"0px","bottom":"0px"}}},"backgroundColor":"base","textColor":"accent-5","layout":{"type":"constrained"}} -->
		
	<div class="wp-block-group has-accent-5-color has-base-background-color has-text-color has-background has-link-color" style="padding-top:0px;padding-bottom:0px"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
		
	<!-- wp:image {"width":"230px","linkDestination":"none"} -->
	<figure class="wp-block-image is-resized"><a href="/"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.jpg' ); ?>" alt="<?php esc_attr_e( 'Restore Construction Logo', 'restoreconstruction' ); ?>" class="wp-image-7" style="width:230px"/></a></figure>
	<!-- /wp:image -->
	
	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"},"elements":{"link":{":hover":{"color":{"text":"#cb1513"}}}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
	<div class="wp-block-group">
		<!-- wp:navigation {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"fontSize":"small"} -->
			<!-- wp:navigation-submenu {"label":"<?php esc_html_e( 'Instagram', 'restoreconstruction' ); ?>","url":"#"} -->
				<!-- wp:navigation-link {"label":"<?php esc_html_e( 'ABC', 'restoreconstruction' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php esc_html_e( 'ABC', 'restoreconstruction' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php esc_html_e( 'ABC', 'restoreconstruction' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-submenu {"label":"<?php esc_html_e( 'Instagram', 'restoreconstruction' ); ?>","url":"#"} -->
					<!-- wp:navigation-link {"label":"<?php esc_html_e( 'ABC', 'restoreconstruction' ); ?>","url":"#","kind":"custom"} /-->
					<!-- wp:navigation-link {"label":"<?php esc_html_e( 'ABC', 'restoreconstruction' ); ?>","url":"#","kind":"custom"} /-->
					<!-- wp:navigation-link {"label":"<?php esc_html_e( 'ABC', 'restoreconstruction' ); ?>","url":"#","kind":"custom"} /-->
					<!-- wp:navigation-link {"label":"<?php esc_html_e( 'ABC', 'restoreconstruction' ); ?>","url":"#","kind":"custom"} /-->
				<!-- /wp:navigation-submenu -->
			<!-- /wp:navigation-submenu -->
			<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Instagram', 'restoreconstruction' ); ?>","url":"#"} /-->
			<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Facebook', 'restoreconstruction' ); ?>","url":"#"} /-->
			<!-- wp:navigation-link {"label":"<?php esc_html_e( 'TikTok', 'restoreconstruction' ); ?>","url":"#"} /-->
			<!-- wp:buttons -->
			<div class="wp-block-buttons sm:!hidden sm:hidden!">

			<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0"},"blockGap":"var:preset|spacing|20","margin":{"bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--40);padding-top:0;padding-bottom:0">

				<!-- wp:paragraph {"fontSize":"medium"} -->
				<p class="has-medium-font-size">27/7 Emergency Services</p>
				<!-- /wp:paragraph -->
				<!-- wp:button {"backgroundColor":"accent-3","textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"spacing":{"padding":{"left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"fontSize":"small"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-3-background-color has-text-color has-background has-link-color has-small-font-size has-custom-font-size wp-element-button" href="#" style="padding-right:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">(847) 455-3000</a></div>
				<!-- /wp:button --></div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->

		<!-- /wp:navigation -->
	</div>
	<!-- /wp:group -->
	
	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"},"elements":{"link":{":hover":{"color":{"text":"#cb1513"}}}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
	<div class="wp-block-group !hidden md:!flex hidden! md:flex!">
		<!-- wp:navigation {"overlayMenu":"never","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"fontSize":"small"} -->
			<!-- wp:buttons -->
			<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"accent-3","textColor":"base","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"spacing":{"padding":{"left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"fontSize":"small"} -->
			<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-accent-3-background-color has-text-color has-background has-link-color has-small-font-size has-custom-font-size wp-element-button" href="#" style="padding-right:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">(847) 455-3000</a></div>
			<!-- /wp:button --></div>
			<!-- /wp:buttons -->
		<!-- /wp:navigation -->
	</div>
	<!-- /wp:group -->
	
	</div>
	<!-- /wp:group --></div>
	<!-- /wp:group --></div>
	<!-- /wp:group -->
