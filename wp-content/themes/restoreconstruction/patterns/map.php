<?php
/**
 * Title: N3 - Map
 * Slug: n3-commercial-realty/map
 * Categories: about
 * Description: This pattern displays a section with a wide column and a narrow column. The wide column contains a title and a subtitle. The narrow column contains a heading and a paragraph.
 *
 * @package WordPress
 * @subpackage N3_Commercial_Realty
 * @since N3 Commercial Realty 1.0
 */

?>
<!-- wp:cover {"metadata":{"categories":["about"],"patternName":"n3-commercial-realty/map","name":"N3 - Map"},"dimRatio":0,"isDark":false,"layout":{"type":"constrained","contentSize":"1680px"}} -->
<div class="wp-block-cover is-light"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><strong>Filter by</strong></p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[n3_maps_filter]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:shortcode -->
[n3_maps]
<!-- /wp:shortcode --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:shortcode -->
[n3_maps_menu]
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->