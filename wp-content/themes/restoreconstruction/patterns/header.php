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
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull"><!-- wp:group {"style":{"color":{"background":"#4b1304"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-base-color has-text-color has-background has-link-color" style="background-color:#4b1304"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:site-logo {"width":90,"className":"invert contrast-200 brightness-0"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"},"elements":{"link":{":hover":{"color":{"text":"#cb1513"}}}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group">
	<!-- wp:navigation {"textColor":"white","layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"right"} -->
		<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Instagram', 'restoreconstruction' ); ?>","url":"#"} /-->
		<!-- wp:navigation-link {"label":"<?php esc_html_e( 'Facebook', 'restoreconstruction' ); ?>","url":"#"} /-->
		<!-- wp:navigation-link {"label":"<?php esc_html_e( 'TikTok', 'restoreconstruction' ); ?>","url":"#"} /-->
		<!-- wp:buttons -->
		<div class="wp-block-buttons"><!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">Login</a></div>
		<!-- /wp:button --></div>
		<!-- /wp:buttons -->
	<!-- /wp:navigation -->
</div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->