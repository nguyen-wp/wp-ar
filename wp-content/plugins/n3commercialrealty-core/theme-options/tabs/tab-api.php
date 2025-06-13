<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

// BACKUP DB

// -> START Backup Tab
Redux::setSection( $opt_name, array(
    'title' => __( 'API Key', 'madelab' ),
    'id'    => 'made-theme-api-key',
    'icon'  => 'bi bi-key'
) );


// Google Map API
Redux::setSection( $opt_name, array(
    'title'      => __( 'Google Map API', 'madelab' ),
    'id'         => 'made-theme-api-key-google-map',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'google-map-api-key',
            'type'     => 'text',
            'title'    => __( 'Google Map API Key', 'madelab' ),
            'subtitle' => __( 'Enter your Google Map API Key', 'madelab' ),
            'placeholder' => '123',
            'desc'     => __( 'Get your Google Map API Key from <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>', 'madelab' ),
            'default'  => '',
        ),
    )
) );

// Google reCAPTCHA
Redux::setSection( $opt_name, array(
    'title'      => __( 'Google reCAPTCHA', 'madelab' ),
    'id'         => 'made-theme-api-key-google-recaptcha',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'google-recaptcha-site-key',
            'type'     => 'text',
            'title'    => __( 'Google reCAPTCHA Site Key', 'madelab' ),
            'subtitle' => __( 'Enter your Google reCAPTCHA Site Key', 'madelab' ),
            'desc'     => __( 'Get your Google reCAPTCHA Site Key from <a href="https://www.google.com/recaptcha/admin" target="_blank">here</a>', 'madelab' ),
            'default'  => '',
        ),
        array(
            'id'       => 'google-recaptcha-secret-key',
            'type'     => 'text',
            'title'    => __( 'Google reCAPTCHA Secret Key', 'madelab' ),
            'subtitle' => __( 'Enter your Google reCAPTCHA Secret Key', 'madelab' ),
            'desc'     => __( 'Get your Google reCAPTCHA Secret Key from <a href="https://www.google.com/recaptcha/admin" target="_blank">here</a>', 'madelab' ),
            'default'  => '',
        ),
    )
) );

// Sharplaunch API Key

Redux::setSection( $opt_name, array(
    'title'      => __( 'Sharplaunch API Key', 'madelab' ),
    'id'         => 'made-theme-api-key-sharplaunch',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'sharplaunch-api-key',
            'type'     => 'text',
            'title'    => __( 'Sharplaunch API Key', 'madelab' ),
            'subtitle' => __( 'Enter your Sharplaunch API Key', 'madelab' ),
            'desc'     => __( 'Get your Sharplaunch API Key from <a href="https://www.sharplaunch.com/" target="_blank">here</a>', 'madelab' ),
            'default'  => '',
        ),
    )
) );

// Mailchimp API Key

Redux::setSection( $opt_name, array(
    'title'      => __( 'Mailchimp API Key', 'madelab' ),
    'id'         => 'made-theme-api-key-mailchimp',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'mailchimp-api-key',
            'type'     => 'text',
            'title'    => __( 'Mailchimp API Key', 'madelab' ),
            'subtitle' => __( 'Enter your Mailchimp API Key', 'madelab' ),
            'desc'     => __( 'Get your Mailchimp API Key from <a href="https://mailchimp.com/" target="_blank">here</a>', 'madelab' ),
            'default'  => '',
        ),
    )
) );