<?php

namespace N3Block;

class SettingsPage {

    public function __construct()
    {
        $this->addActions();
    }

    protected function addActions()
    {
        add_action('admin_menu', [$this, 'registerPage']);
        add_action('admin_init', [$this, 'registerSettingsGroups']);
        add_action('admin_init', [$this, 'registerFields']);
        add_action('admin_init', [$this, 'checkInstagramQueryURL']);
		add_action( 'admin_bar_menu', array( $this, 'setadminMenyBlocks' ), 100 );
	}

    public function getSettingsGroups()
	{
		return [
			'general' => __('General', 'n3custompost'),
			'appearance' => __('Appearance', 'n3custompost'),
			'blocks' => __('Blocks', 'n3custompost'),
			'post_templates' => __('Post Templates', 'n3custompost'),
		];
	}

    public function setadminMenyBlocks()
	{
		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array(
			'id'    => 'gp-blocks',
			'title' => esc_html__( 'N3 Templates', 'gp-theme' ),
			'parent' => 'made_theme_options',
			'href'  => admin_url( 'edit.php?post_type=n3custompost' ),
		));
	}

    public function registerPage()
	{
		add_options_page(
			esc_html_x('N3 Template Settings' , 'Settings page title', 'n3custompost'),
			esc_html_x('N3 Template', 'Settings page title(in menu)', 'n3custompost'),
			'manage_options',
			'n3custompost',
			[$this, 'renderPage']
		);
		

	}

	public function registerSettingsGroups()
	{
		$settings_groups = $this->getSettingsGroups();

		foreach ($settings_groups as $id => $title){
			add_settings_section(
				'n3custompost_' . $id,
				'',
				'',
				'n3custompost_' . $id
			);
		}
	}

	public function renderPage()
	{
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$active_tab_id = $this->getActiveTabID();
		$settings_groups = $this->getSettingsGroups();

		settings_errors('n3custompost_settings_errors');
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<h2 class="nav-tab-wrapper">
				<?php
				foreach ($settings_groups as $tab_id => $tab_title) :
					$active_tab_class = $tab_id == $active_tab_id ? 'nav-tab-active' : '';
				?>
					<a href="<?php echo esc_url( $this->getTabUrl($tab_id) ); ?>" class="nav-tab <?php echo esc_attr($active_tab_class); ?>">
						<?php echo esc_html($tab_title)?>
					</a>
				<?php
				endforeach;
				?>
			</h2>
			<?php
				if ( 'post_templates' == $active_tab_id ) :

				$this->renderPostTemplatesTab();

				else :
			?>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'n3custompost_' . $active_tab_id );
				do_settings_sections( 'n3custompost_' . $active_tab_id );

				submit_button( esc_html__('Save Changes', 'n3custompost') );
				?>
			</form>
			<?php
				endif;
			?>
		</div>
		<?php
	}

    public function n3custompost_instagram_notice_success() {
        ?>
        <div class="notice notice-success">
            <p><?php esc_html_e( 'Instagram: access token updated.', 'n3custompost' ); ?></p>
        </div>
        <?php
    }

    public function n3custompost_instagram_notice_error() {
        ?>
        <div class="notice notice-error">
            <p><?php esc_html_e('Instagram: access denied.', 'n3custompost'); ?></p>
        </div>
        <?php
    }

    public function checkInstagramQueryURL()
    {
        global $pagenow;

        if ( $pagenow == 'options-general.php' && isset( $_GET['instagram-token'] ) && isset( $_GET['nonce'] ) ) {

			if ( wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'n3custompost_nonce_save_instagram_token' ) && current_user_can( 'manage_options' ) ) {

				// Update token
				update_option( 'n3custompost_instagram_token', sanitize_text_field( wp_unslash( $_GET['instagram-token'] ) ) );
				// Delete cache data
				delete_transient( 'n3custompost_instagram_response_data' );
				// Schedule token refresh
				n3custompost()->instagramTokenManager()->schedule_token_refresh_event();

				$redirect_url = add_query_arg(
					[
						'n3custompost-instagram-success' => true
					],
					$this->getTabUrl('general')
				);
			} else {
				$redirect_url = add_query_arg(
					[
						'instagram-error' => true
					],
					$this->getTabUrl('general')
				);
			}

			wp_redirect( $redirect_url );
        }

        if (isset($_GET['n3custompost-instagram-success'])) {
            add_action( 'admin_notices', [$this, 'n3custompost_instagram_notice_success'] );
        }

        if (isset($_GET['instagram-error'])) {
            add_action( 'admin_notices', [$this, 'n3custompost_instagram_notice_error'] );
        }
    }

    public function registerFields() {

        /* #region Section Content Width */
        add_settings_field( 'n3custompost_section_content_width', __( 'Section Content Width', 'n3custompost' ),
            [ $this, 'renderSectionContentWidth' ], 'n3custompost_appearance', 'n3custompost_appearance' );
        register_setting( 'n3custompost_appearance', 'n3custompost_section_content_width', [ 'type' => 'number', 'default' => '' ] );
        /* #endregion */

		/* #region Animation */
		add_settings_field( 'n3custompost_animation', __( 'Animation', 'n3custompost' ),
				[ $this, 'renderAnimation' ], 'n3custompost_appearance', 'n3custompost_appearance' );
		register_setting( 'n3custompost_appearance', 'n3custompost_smooth_animation', [ 'type' => 'boolean', 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean' ] );
		/* #endregion */

		/* #region AssetsOptimization */
		add_settings_field( 'n3custompost_assets_optimization', __( 'Performance Optimization', 'n3custompost' ),
				[ $this, 'renderAssetsOptimization'], 'n3custompost_general', 'n3custompost_general' );
		register_setting( 'n3custompost_general', 'n3custompost_load_assets_on_demand', [ 'type' => 'boolean', 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean' ] );

		register_setting( 'n3custompost_general', 'n3custompost_move_css_to_head', [ 'type' => 'boolean', 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean' ] );
		/* #endregion */

        /* #region Instagram Access Token */
        add_settings_field( 'n3custompost_instagram_token', __( 'Instagram Access Token', 'n3custompost' ),
            [ $this, 'renderInstagramToken' ], 'n3custompost_general', 'n3custompost_general' );
        register_setting( 'n3custompost_general', 'n3custompost_instagram_token', [ 'type' => 'text', 'default' => '' ] );
        /* #endregion */

		/* #region Instagram Cache Timeout */
        add_settings_field( 'n3custompost_instagram_cache_timeout', __( 'Instagram Cache Timeout', 'n3custompost' ),
            [ $this, 'renderInstagramCacheTimeout' ], 'n3custompost_general', 'n3custompost_general' );
        register_setting( 'n3custompost_general', 'n3custompost_instagram_cache_timeout', [ 'type' => 'number', 'default' => 30 ] );
        /* #endregion */

        /* #region Google API Key */
        add_settings_field( 'n3custompost_google_api_key', __( 'Google Maps API Key', 'n3custompost' ),
            [ $this, 'renderGoogleApiKey' ], 'n3custompost_general', 'n3custompost_general' );
        register_setting( 'n3custompost_general', 'n3custompost_google_api_key', [ 'type' => 'text', 'default' => '' ] );
        /* #endregion */

        /* #region Recaptcha Site Key */
        add_settings_field( 'n3custompost_recaptcha_v2_site_key', __( 'Recaptcha Site Key', 'n3custompost' ),
            [ $this, 'renderRecaptchaSiteKey' ], 'n3custompost_general', 'n3custompost_general' );
        register_setting( 'n3custompost_general', 'n3custompost_recaptcha_v2_site_key', [ 'type' => 'text', 'default' => '' ] );
        /* #endregion */

        /* #region Recaptcha Secret Key */
        add_settings_field( 'n3custompost_recaptcha_v2_secret_key', __( 'Recaptcha Secret Key', 'n3custompost' ),
            [ $this, 'renderRecaptchaSecretKey' ], 'n3custompost_general', 'n3custompost_general' );
        register_setting( 'n3custompost_general', 'n3custompost_recaptcha_v2_secret_key', [ 'type' => 'text', 'default' => '' ] );
        /* #endregion */

        /* #region Mailchimp Api Key */
        add_settings_field( 'n3custompost_mailchimp_api_key', __( 'Mailchimp API Key', 'n3custompost' ),
            [ $this, 'renderMailchimpApiKey' ], 'n3custompost_general', 'n3custompost_general' );
        register_setting( 'n3custompost_general', 'n3custompost_mailchimp_api_key', [ 'type' => 'text', 'default' => '' ] );
        /* #endregion */

		/* #region Disabled Blocks */
        add_settings_field( 'n3custompost_disabled_blocks', __( 'Disable N3 Templates', 'n3custompost' ),
            [ $this, 'renderDisabledBlocks' ], 'n3custompost_blocks', 'n3custompost_blocks' );

		$blocks = n3custompost()->blocksManager()->getBlocks();

		foreach ($blocks as $name => $block) {
			$option_name = $block->getDisabledOptionKey();
			register_setting( 'n3custompost_blocks', $option_name, [ 'type' => 'boolean', 'default' => false, 'sanitize_callback' => 'rest_sanitize_boolean' ] );
		}
        /* #endregion */
    }

    public function renderSectionContentWidth() {

        $field_val = get_option( 'n3custompost_section_content_width', '' );

        ?>
		<input type="number" id="n3custompost_section_content_width" name="n3custompost_section_content_width" value="<?php echo esc_attr( $field_val ); ?>" />
        <?php echo esc_html_x( 'px', 'pixels', 'n3custompost' ); ?>
		<p class="description"><?php echo esc_html__( 'Default width of the content area in the Section block. Leave empty to use $content_width set in your theme. Set 0 to disable this option and control it via CSS.', 'n3custompost' ); ?></p>
		<?php
    }

    public function renderInstagramToken() {

        $field_val = get_option('n3custompost_instagram_token', '');

		$connectURL = add_query_arg(
			['nonce' => wp_create_nonce('n3custompost_nonce_save_instagram_token') ],
			admin_url( 'options-general.php' )
		);

		$refreshURL = add_query_arg(
			['nonce' => wp_create_nonce('n3custompost_nonce_save_instagram_token') ],
			admin_url( 'options-general.php' )
		);

		?>
		<input type="text" id="n3custompost_instagram_token" name="n3custompost_instagram_token" class="regular-text" value="<?php echo esc_attr( $field_val ); ?>" />
        <p><a href="<?php echo esc_url(
			'https://api.instagram.com/oauth/authorize?client_id=910186402812397&redirect_uri=' .
			'https://api.getmotopress.com/get_instagram_token.php&scope=user_profile,user_media&response_type=code&state=' .
			$connectURL ); ?>" class="button button-default"><?php echo esc_html__( 'Connect Instagram Account', 'n3custompost' );?></a>
		<?php
		if ( ! empty( $field_val) ) {
			?>
			<a href="<?php echo esc_url(
				'https://api.getmotopress.com/refresh_instagram_token.php?access_token=' . $field_val . '&state=' .
				$refreshURL ); ?>" class="button button-default"><?php echo esc_html__( 'Refresh Access Token', 'n3custompost' );?></a>
			<?php
		}
		?>
		</p>
		<?php
    }

	public function renderInstagramCacheTimeout() {

        $field_val = get_option('n3custompost_instagram_cache_timeout');
		?>
		<input type="number" id="n3custompost_instagram_cache_timeout" name="n3custompost_instagram_cache_timeout" value="<?php echo esc_attr( $field_val ); ?>" />
		<p class="description"><?php echo esc_html__( 'Time until expiration of media data in minutes. Setting to 0 means no expiration.', 'n3custompost' ); ?></p>
		<?php
    }

    public function renderGoogleApiKey() {

        $field_val = get_option('n3custompost_google_api_key', '');
		?>
        <input type="text" id="n3custompost_google_api_key" name="n3custompost_google_api_key" class="regular-text" value="<?php echo esc_attr( $field_val ); ?>" />
		<?php
    }

    public function renderRecaptchaSiteKey() {

        $field_val = get_option( 'n3custompost_recaptcha_v2_site_key', '' );
		?>
        <input type="text" id="n3custompost_recaptcha_v2_site_key" name="n3custompost_recaptcha_v2_site_key" class="regular-text" value="<?php echo esc_attr( $field_val ); ?>" />
		<?php
    }

    public function renderRecaptchaSecretKey() {

        $field_val = get_option( 'n3custompost_recaptcha_v2_secret_key', '' );
		?>
        <input type="text" id="n3custompost_recaptcha_v2_secret_key" name="n3custompost_recaptcha_v2_secret_key" class="regular-text" value="<?php echo esc_attr( $field_val ); ?>" />
		<?php
    }

    public function renderMailchimpApiKey() {

        $field_val = get_option( 'n3custompost_mailchimp_api_key', '' );
		?>
        <input type="text" id="n3custompost_mailchimp_api_key" name="n3custompost_mailchimp_api_key" class="regular-text" value="<?php echo esc_attr( $field_val ); ?>" />
		<?php
    }

	public function renderDisabledBlocks() {

		$blocks = n3custompost()->blocksManager()->getBlocks();
		$disabledBlocks = n3custompost()->blocksManager()->getDisabledBlocks();
		ksort( $blocks );
		?>
		<p class="description">
			<?php
				printf(
					//translators: %1$s, %2$s is a number of total and disabled blocks
					esc_html__('Total: %1$s, Disabled: %2$s', 'n3custompost'),
					esc_html( sizeof($blocks) ),
					esc_html( sizeof($disabledBlocks) )
				);
			?><br/>
			<input type="button" id="n3custompost-disabled-blocks-select-all" class="button button-link" value="<?php esc_html_e('Select All', 'n3custompost'); ?>" />
			&nbsp;/&nbsp;
			<input type="button" id="n3custompost-disabled-blocks-deselect-all" class="button button-link" value="<?php esc_html_e('Deselect All', 'n3custompost'); ?>" />
		</p>
		<fieldset id="n3custompost-disabled-blocks">
		<?php
		foreach ($blocks as $name => $block) {
			$option_name = $block->getDisabledOptionKey();
			?>
			<label for="<?php echo esc_attr( $option_name ); ?>">
				<input type="checkbox" id="<?php echo esc_attr( $option_name ); ?>" name="<?php echo esc_attr( $option_name ); ?>" value="1" <?php
					checked( '1', $block->isDisabled() ); ?> />
				<?php echo esc_html( $block->getLabel() ); ?>
			</label><br/>
			<?php
		}
		?>
		</fieldset>
		<script>
			jQuery(document).ready(function(){
				jQuery('#n3custompost-disabled-blocks-select-all').click(function(){
					jQuery('#n3custompost-disabled-blocks input:checkbox').attr('checked','checked');
				});
				jQuery('#n3custompost-disabled-blocks-deselect-all').click(function(){
					jQuery('#n3custompost-disabled-blocks input:checkbox').removeAttr('checked');
				});
			})
		</script>
		<?php
    }

	public function renderPostTemplatesTab() {
		?>
		<p><?php esc_html_e( 'Post Templates are used for presenting posts in a certain format and style. You can change how a post looks by choosing a post template in the Custom Post Type and related blocks.', 'n3custompost' ); ?></p>
		<a class="button button-primary" href="<?php echo esc_url( admin_url('edit.php?post_type=n3custompost') ); ?>"><?php esc_html_e( 'Manage Post Templates', 'n3custompost' ); ?></a>
		<?php
	}

	public function renderAnimation() {

		$field_val = get_option( 'n3custompost_smooth_animation', false );
		?>
		<label for="n3custompost_smooth_animation">
			<input type="checkbox" id="n3custompost_smooth_animation" name="n3custompost_smooth_animation" value="1" <?php
				checked( '1', $field_val ); ?> />
			<?php echo esc_html__('Enable smooth animation of blocks', 'n3custompost'); ?>
		</label>
		<p class="description"><?php
			echo esc_html__('Hides block until the entrance animation starts. Prevents possible occurrence of horizontal scroll during the animation.', 'n3custompost');
			?></p>
		<?php
	}

	public function renderAssetsOptimization() {

		$n3custompost_load_assets_on_demand = get_option( 'n3custompost_load_assets_on_demand', false );
		$n3custompost_move_css_to_head = get_option( 'n3custompost_move_css_to_head', false );
		?>
		<fieldset>
			<label for="n3custompost_load_assets_on_demand">
				<input type="checkbox" id="n3custompost_load_assets_on_demand" name="n3custompost_load_assets_on_demand" value="1" <?php
					checked( '1', $n3custompost_load_assets_on_demand ); ?> />
				<?php echo esc_html__('Load CSS and JS of blocks on demand', 'n3custompost') . ' (Recomended)'; ?>
			</label>
			<p class="description"><?php
				echo esc_html__('If this option is on, all CSS and JS files of blocks will be loaded on demand in footer. This will reduce the amount of heavy assets on the page.', 'n3custompost');
				?></p>
			<br/>
			<label for="n3custompost_move_css_to_head">
				<input type="checkbox" id="n3custompost_move_css_to_head" name="n3custompost_move_css_to_head" value="1" <?php
					checked( '1', $n3custompost_move_css_to_head ); ?> />
				<?php echo esc_html__('Aggregate all CSS files of blocks in header', 'n3custompost') . ' (Recomended)'; ?>
			</label>
			<p class="description"><?php
				echo esc_html__('If this option is on, all CSS files of blocks will be moved to header for better theme compatibility. If your theme has custom styling for N3Block blocks, its styles will be applied first.', 'n3custompost');
				?></p>
			<br/>
			<p class="description"><?php
				echo esc_html__('These settings may break some blocks in posts loaded via Ajax. These settings may not work together with optimization plugins.', 'n3custompost');
				?></p>
		</fieldset>
		<script>
			jQuery(document).ready(function(){
				// set initial state
				jQuery('#n3custompost_move_css_to_head').toggleClass("disabled", ! jQuery('#n3custompost_load_assets_on_demand').prop("checked") );
				// bind state change
				jQuery('#n3custompost_load_assets_on_demand').change(function(e) {
					jQuery('#n3custompost_move_css_to_head').toggleClass("disabled", ! jQuery(this).prop("checked") );
				});
			})
		</script>
		<?php
	}

	public function getTabUrl( $tab = 'general' )
	{
    	return add_query_arg( [ 'page' => 'n3custompost', 'active_tab' => $tab ], admin_url( 'options-general.php' ) );
	}

	private function getActiveTabID()
	{
		$tab_param_isset = isset( $_GET['active_tab'] ) && array_key_exists( $_GET['active_tab'], $this->getSettingsGroups() );
		return  $tab_param_isset ? sanitize_text_field( wp_unslash( $_GET['active_tab'] ) ) : 'general';
	}
}
