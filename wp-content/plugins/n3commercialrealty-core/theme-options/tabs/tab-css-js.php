<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

    // -> START Footer
    Redux::setSection( $opt_name, array(
        'title' => __( 'Custom code', 'made-theme-options' ),
        'id'    => 'made-theme-cssjs',
        'icon'  => 'bi bi-braces'
    ) );

	Redux::setSection( $opt_name, array(
		'title'      => __( 'SCSS/SASS', 'made-theme-options' ),
		'id'         => 'made-theme-cssjs-scss',
        'subsection' => true,
		'desc' => __('Sass is a stylesheet language that’s compiled to CSS. It allows you to use variables, nested rules, mixins, functions, and more, all with a fully CSS-compatible syntax. Sass helps keep large stylesheets well-organized and makes it easy to share design within and across projects.', 'made-theme-options'),
		'fields'     => array(
			array(
				'id'       => 'madinfo_sass_warning',
				'type' => 'info',
				'style' => 'critical',
				'class' => 'text-danger',
				'title'    => __( 'IMPORTANT NOTE', 'made-theme-options' ),
				'icon' => 'bi bi-info',
				'desc'     => __( 'Don\'t edit this code if you don\'t know what you are doing. This code will be overwritten when you update the theme. If you want to add custom CSS, please use the Custom CSS field below. If you have a problem on this field, please reset this section to default.', 'made-theme-options' )
			),
			array(
				'id'       => 'made-theme-cssjs-scss-code',
                'type'     => 'ace_editor',
				'mode'     => 'scss',
				'class' => 'made-theme-admin-cssjs',
				'theme'    => 'monokai',
				'default'  => "\$mycolordefault: #3366ff;
				
.mycustomelement {
	border-color: \$mycolordefault;
}",
				'options' => array(
					'minLines' => 40, 
					'maxLines' => 100
				)
			),
			array(
				'id'    => 'info_sass',
				'type'  => 'info',
				'title' => __('Sass Basics', 'made-theme-options'),
				'style' => 'success',
				'icon' => 'bi bi-info',
				'desc'       => __( 'If you want to learn how to get everything setup, go here: ', 'made-theme-options' ) . '<a href="//sass-lang.com/guide" target="_blank">sass-lang.com/guide</a>',
			),
		),
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'CSS', 'made-theme-options' ),
        'id'         => 'made-theme-cssjs-css',
        'subsection' => true,
		'desc'		=> __( 'If you have any custom CSS you would like added to the site, please enter it here.', 'made-theme-options' ),
		'fields'     => array(
			array(
				'id'       => 'made-theme-cssjs-css-code',
                'type'     => 'ace_editor',
				'mode'     => 'css',
				'class' => 'made-theme-admin-cssjs',
				'theme'    => 'monokai',
				'default'  => ":root {
	--mycolor-default: #3366ff;
}

.myelement {
	border-color: var(--mycolor-default);
}",
				'options' => array(
					'minLines' => 40, 
					'maxLines' => 100
					)
				),
			),
			) );
	
	Redux::setSection( $opt_name, array(
        'title'      => __( 'JavaScript/Babel', 'made-theme-options' ),
        'id'         => 'made-theme-cssjs-js',
        'subsection' => true,
		'desc'		=> __( 'Please enter in any custom javascript you wish to add to the head of your pages. Requires opening and closing script tags.', 'made-theme-options' ),
		'fields'     => array(
			array(
				'id'       => 'made-theme-cssjs-js-code',
                'type'     => 'ace_editor',
				'mode'     => 'javascript',
				'class' => 'made-theme-admin-cssjs',
				'theme'    => 'monokai',
				'default'  => 'jQuery(document).ready(function($){
// Your code here
});
Fancybox.bind("[data-fancybox]", {
	// Custom options for all galleries
});
Fancybox.bind("[data-fancybox=\'gallery\']", {
	// Custom options for all galleries
});',
				'options' => array(
					'minLines' => 40, 
					'maxLines' => 100
				)
			),
		),
    ) );
