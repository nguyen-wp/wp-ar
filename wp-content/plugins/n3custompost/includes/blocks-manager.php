<?php

namespace N3Block;

/**
 * Class BlocksManager
 * @package N3Block
 */
class BlocksManager {

	private $blocks = array();
	private $enabledBlocks = array();
	private $disabledBlocks = array();

	/**
	 * BlockManager constructor.
	 */
	public function __construct() {

		if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
			add_filter( 'block_categories_all', array( $this, 'block_categories_all' ), 10, 2 );
		} else {
			add_filter( 'block_categories', array( $this, 'block_categories' ), 10, 2 );
		}

		add_action( 'init', [$this, 'includeBlocks'] );
	}

	public function block_categories_all( $block_categories, $editor_context ) {

		//Add N3Block blocks category
		$block_categories = array_merge(
			$block_categories,
			array(
				array(
					'slug' => 'n3custompost-blocks',
					'title' => __( 'RC Templates', 'n3custompost' ),
				),
			)
		);

		//Add N3Block post-block category (Only on Templates page)
		if ( ! empty( $editor_context->post ) && ( $editor_context->post->post_type == n3custompost()->postTemplatePart()->postType ) ) {
			$block_categories = array_merge(
				$block_categories,
				array(
					array(
						'slug' => 'n3custompost-post-blocks',
						'title' => __( 'N3Block Post Blocks', 'n3custompost' ),
					),
				)
			);
		}

		if ( n3custompost_acf_is_active() ) {
			if ( ! empty( $editor_context->post ) && ( $editor_context->post->post_type == n3custompost()->postTemplatePart()->postType ) ) {
				$block_categories = array_merge(
					$block_categories,
					array(
						array(
							'slug' => 'n3custompost-acf-blocks',
							'title' => __( 'N3Block ACF Blocks', 'n3custompost' ),
						),
					)
				);
			}
		}

		return $block_categories;
	}

	public function block_categories( $categories, $post ) {

		//Add N3Block blocks category
		$categories = array_merge(
			$categories,
			array(
				array(
					'slug' => 'n3custompost-blocks',
					'title' => __( 'RC Templates', 'n3custompost' ),
				),
			)
		);

		//Add N3Block post-block category (Only on Templates page)
		if ( $post && ( $post->post_type == n3custompost()->postTemplatePart()->postType ) ) {
			$categories = array_merge(
				$categories,
				array(
					array(
						'slug' => 'n3custompost-post-blocks',
						'title' => __( 'N3Block Post Blocks', 'n3custompost' ),
					),
				)
			);
		}

		if ( n3custompost_acf_is_active() ) {
			if ( $post && ( $post->post_type == n3custompost()->postTemplatePart()->postType ) ) {
				$categories = array_merge(
					$categories,
					array(
						array(
							'slug' => 'n3custompost-acf-blocks',
							'title' => __( 'N3Block ACF Blocks', 'n3custompost' ),
						),
					)
				);
			}
		}

		return $categories;
	}

	public function includeBlocks() {

		$block_files = array(
			'abstract-block',

			'anchor',
			'accordion',
			'advanced-heading',
			'advanced-spacer',
			'banner',
			'button-group',
			'circle-progress-bar',
			'counter',
			'custom-post-type',
			'icon-box',
			'icon',
			'image-box',
			'images-slider',
			'images-stack',
			'instagram',
			'google-map',
			'media-text-slider',
			'person',
			'post-carousel',
			'post-slider',
			'price-box',
			'price-list',
			'progress-bar',
			'recent-posts',
			'section',
			'social-links',
			'tabs',
			'testimonial',
			'toggle',
			'table-of-contents',
			'video-popup',
			'image-hotspot',
			'countdown',
			'template-library',
			'contact-form',
			'mailchimp',
			'content-timeline',
			'table',
			'content-slider'
		);

		// load and register main blocks
		foreach ( $block_files as $block_file_name ) {
			$this->require_block($block_file_name);
		}

		// fill array of active blocks
		foreach ( $this->blocks as $block ) {

			if ( $block->isEnabled() ) {
				$this->enabledBlocks[] = $block;
			} else {
				$this->disabledBlocks[] = $block;
			}
		}

		$template_parts = array(
			'template-parts/post-title',
			'template-parts/post-featured-image',
			'template-parts/post-content',
			'template-parts/post-link',
			'template-parts/post-button',
			'template-parts/post-author',
			'template-parts/post-categories',
			'template-parts/post-comments',
			'template-parts/post-tags',
			'template-parts/post-date',
			'template-parts/post-featured-background-image',
			'template-parts/post-meta',
			'template-parts/post-custom-field',
			'template-parts/post-layout-helper',
		);

		// load template-parts blocks
		foreach ( $template_parts as $block_file_name ) {
			$this->require_block($block_file_name);
		}

		$template_parts_acf = array(
			'template-parts/acf/background-image',
			'template-parts/acf/image',
			'template-parts/acf/select',
			'template-parts/acf/wysiwyg',
		);

		// load template-acf blocks
		foreach ( $template_parts_acf as $block_file_name ) {
			$this->require_block($block_file_name);
		}

	}

	private function require_block( $block_file_name ) {

		$path = n3custompost_get_plugin_path( '/includes/blocks/' . $block_file_name . '.php' );

		if ( file_exists( $path ) ) {
			require_once( $path );
		}
	}

	public function addBlock( $block ) {

		if ( $block instanceof \N3Block\Blocks\AbstractBlock ) {
			$this->blocks[ $block::getBlockName() ] = $block;
		}
	}

	public function getBlocks() {
		return $this->blocks;
	}

	public function getEnabledBlocks() {
		return $this->enabledBlocks;
	}

	public function getDisabledBlocks() {
		return $this->disabledBlocks;
	}

	public function hasEnabledBlocks() {
		return ( sizeof ($this->enabledBlocks ) > 0 );
	}

	public function hasDisabledBlocks() {
		return ( sizeof ($this->disabledBlocks ) > 0 );
	}

	/**
	 * Determine whether a post or content string has N3Block blocks.
	 */
	public function hasN3BlockBlocks() {

		$has_n3custompost_blocks = false;

		if ( has_blocks() ) {

			$blocks = $this->getBlocks();
			foreach ( $blocks as $block ) {

				if ( has_block( $block->getBlockName() ) ) {
					$has_n3custompost_blocks = true;
					break;
				}
			}
		}

		return apply_filters( 'n3custompost/blocks/has_n3custompost_blocks', $has_n3custompost_blocks);
	}

	public function hasN3BlockNestedBlocks() {

		$has_n3custompost_nested_blocks = false;

		$nestedBlocks = [
			\N3Block\Blocks\PostCarousel::getBlockName(),
			\N3Block\Blocks\PostSlider::getBlockName(),
			\N3Block\Blocks\CustomPostType::getBlockName(),
		];

		foreach( $nestedBlocks as $block ) {
			if ( has_block($block) ) {
				$has_n3custompost_nested_blocks = true;
				break;
			}
		}

		return apply_filters( 'n3custompost/blocks/has_n3custompost_nested_blocks', $has_n3custompost_nested_blocks);
	}

}
