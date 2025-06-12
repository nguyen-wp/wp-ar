<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

// -> START Footer
Redux::setSection( $opt_name, array(
    'title' => __( 'Dashboard', 'made-theme-options' ),
    'id'    => 'made-theme-dashboard-box',
    'icon'  => 'bi bi-grid-3x3-gap',
) );

    Redux::setSection( $opt_name, array(
        'title' => __( 'Dashboard Widgets', 'made-theme-options' ),
        'id'    => 'made-theme-dashboard-widgets',
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'made-theme-dashboard-widgets-enable',
                'type'     => 'switch',
                'title'    => __( 'Disable Dashboard Widgets', 'made-theme-options' ),
                'on'       => 'On',
                'off'      => 'Off',
                'default'  => 0,
            ),
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __( 'Dashboard Content', 'made-theme-options' ),
        'id'    => 'made-theme-dashboard-box-info',
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'made-theme-dashboard-box-info-title',
                'type'     => 'text',
                'title'    => __( 'Title', 'made-theme-options' ),
                'default'  => 'Welcome to Restore Construction',
            ),
            array(
                'id'       => 'made-theme-dashboard-box-info-content',
                'type'     => 'editor',
                'title'    => __( 'Content', 'made-theme-options' ),
                'default'  => 'We are a team of developers and designers who are passionate about creating beautiful and functional websites. We are here to help you build your website and make it look great.',
            ),
            array(
                'id'       => 'made-theme-dashboard-box-full-content',
                'type'     => 'ace_editor',
				'mode'     => 'html',
                'title'    => __( 'Full Content', 'made-theme-options' ),
				'theme'    => 'monokai',
                'required' => array( 'made-theme-dashboard-widgets-enable', '=', '1' ),
                'default'  => '<div class="row mt-5 text-center">
    <div class="col-xl-4 mt-5">
        <div class="icon-circle">
            <i class="bi bi-palette"></i>
        </div>
        <div class="content">
            <h2>Flexible</h2>
            <p>Our website are built with flexibility in mind. You can easily customize the theme to fit your needs.</p>
        </div>
    </div>
    <div class="col-xl-4 mt-5">
        <div class="icon-circle">
            <i class="bi bi-cart-check"></i>
        </div>
        <div class="content">
            <h2>Easy Ecommerce</h2>
            <p>Our website are built with WooCommerce in mind. With our website, you can easily set up an online store.</p>
        </div>
    </div>
    <div class="col-xl-4 mt-5">
        <div class="icon-circle">
            <i class="bi bi-layout-text-window-reverse"></i>
        </div>
        <div class="content">
            <h2>Multi-Addons</h2>
            <p>We design our website to be compatible with addons. Our addons make it easy for you to add new features to your website.</p>
        </div>
    </div>
    <div class="col-xl-4 mt-5">
        <div class="icon-circle">
            <i class="bi bi-puzzle"></i>
        </div>
        <div class="content">
            <h2>Google Extensions</h2>
            <p>We have created a set of Google Extensions that will help you get the most out of your business.</p>
        </div>
    </div>
    <div class="col-xl-4 mt-5">
        <div class="icon-circle">
            <i class="bi bi-phone"></i>
        </div>
        <div class="content">
            <h2>Mobile Apps</h2>
            <p>We can develop a mobile app for your business. Your customer base will increase as a result.</p>
        </div>
    </div>
    <div class="col-xl-4 mt-5">
        <div class="icon-circle">
            <i class="bi bi-boxes"></i>
        </div>
        <div class="content">
            <h2>Web Apps</h2>
            <p>Our team can create a custom web app for your business. As a result, you will be able to reach larger values.</p>
        </div>
    </div>
</div>',
				'options' => array(
					'minLines' => 40, 
					'maxLines' => 100
				)
			),
            array(
                'id'       => 'made-theme-dashboard-box-short-content',
                'type'     => 'ace_editor',
				'mode'     => 'html',
                'title'    => __( 'Content', 'made-theme-options' ),
				'theme'    => 'monokai',
                'required' => array( 'made-theme-dashboard-widgets-enable', '=', '0' ),
                'default'  => '<div class="row">
    <div class="col-xl-12 mt-3">
        <div class="content">
            <h3 class="fw-bold"><i class="bi bi-palette"></i> Flexible</h3>
            <p class="mb-0">Our website are built with flexibility in mind. You can easily customize the theme to fit your needs.</p>
        </div>
    </div>
    <div class="col-xl-12 mt-3">
        <div class="content">
            <h3 class="fw-bold"><i class="bi bi-cart-check"></i> Easy Ecommerce</h3>
            <p class="mb-0">Our website are built with WooCommerce in mind. With our website, you can easily set up an online store.</p>
        </div>
    </div>
    <div class="col-xl-12 mt-3">
        <div class="content">
            <h3 class="fw-bold"><i class="bi bi-layout-text-window-reverse"></i> Multi-Addons</h3>
            <p class="mb-0">We design our website to be compatible with addons. Our addons make it easy for you to add new features to your website.</p>
        </div>
    </div>
</div>',
				'options' => array(
					'minLines' => 40, 
					'maxLines' => 100
				)
			),
        ),
    ) );