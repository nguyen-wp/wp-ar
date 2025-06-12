<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/info.html' ) ) {
	$madeHTML = '';
	Redux_Functions::init_wp_filesystem();
	global $wp_filesystem;
	
	$madeHTML = $wp_filesystem->get_contents( N3COMMERCIALREALTY_CORE_PATH . 'docs/info.html' );

	$section = array(
		'title'      => __( 'Addons', 'made-theme-options' ),
        'id'         => 'made-theme-info',
		'class'      => 'made-theme-addons',
		'icon'   => 'bi bi-box-seam',
		'fields'     => array(
            array(
                'id'       => 'made-theme-info-details',
				'full_width' => true,
				'type'     => 'raw',
                'content'  => $madeHTML,
            )
        )
	);
	Redux::setSection( $opt_name, $section );

}

if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/README.md' ) ) {
	$section = array(
		'icon'   => 'bi bi-book',
		'title'  => __( 'Documentation', 'made-theme-options' ),
		'class'      => 'made-theme-addons',
		'fields' => array(
			array(
				'id'       => '17',
				'type'     => 'raw',
				'markdown' => true,
				'content_path' => N3COMMERCIALREALTY_CORE_PATH . 'docs/README.md', // FULL PATH, not relative please
				//'content' => 'Raw content here',
			),
		),
	);
	Redux::setSection( $opt_name, $section );
}


if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/CLASS.md' ) ) {
	$section = array(
		'title'  => __( 'Class name', 'made-theme-options' ),
		'class'      => 'made-theme-addons',
		'subsection' => true,
		'fields' => array(
			array(
				'id'       => '18',
				'type'     => 'raw',
				'markdown' => true,
				'content_path' => N3COMMERCIALREALTY_CORE_PATH . 'docs/CLASS.md', // FULL PATH, not relative please
				//'content' => 'Raw content here',
			),
		),
	);
	Redux::setSection( $opt_name, $section );
}

if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/DEVELOPER.md' ) ) {
	$section = array(
		'title'  => __( 'For developers', 'made-theme-options' ),
		'class'      => 'made-theme-addons',
		'subsection' => true,
		'fields' => array(
			array(
				'id'    => 'info_dev',
				'type'  => 'info',
				'title' => __('Sass Basics', 'made-theme-options'),
				'style' => 'success',
				'icon' => 'bi bi-info',
				'desc'       => __( 'Did you know that MADE sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <b>$made_theme</b>', 'made-theme-options' ),
			),
			array(
				'id'       => '19',
				'type'     => 'raw',
				'markdown' => true,
				'content_path' => N3COMMERCIALREALTY_CORE_PATH . 'docs/DEVELOPER.md', // FULL PATH, not relative please
				//'content' => 'Raw content here',
			),
		),
	);
	Redux::setSection( $opt_name, $section );
}
