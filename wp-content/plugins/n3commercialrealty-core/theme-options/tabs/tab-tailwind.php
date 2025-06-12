<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

    // -> START Footer
    Redux::setSection( $opt_name, array(
        'title' => __( 'TailwindCSS', 'made-theme-options' ),
        'id'    => 'made-theme-tailwindcss',
        'icon'  => 'bi bi-code-slash'
    ) );

	// Enable/Disable TailwindCSS

	Redux::setSection( $opt_name, array(
		'title'      => __( 'Enable/Disable TailwindCSS', 'made-theme-options' ),
		'id'         => 'made-theme-tailwindcss-enable',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'made-theme-tailwindcss-enable',
				'type'     => 'switch',
				'title'    => __( 'Enable TailwindCSS', 'made-theme-options' ),
				'default'  => true,
			),
			array(
				'id'       => 'made-theme-tailwindcss-config',
				'type'     => 'ace_editor',
				'mode'     => 'javascript',
				'theme'    => 'monokai',
				'class' => 'made-theme-admin-cssjs2',
				'title'    => __( 'TailwindCSS Config', 'made-theme-options' ),
				'required'   => array('made-theme-tailwindcss-enable', '=', true),
				'default'  => 'tailwind.config = {
	theme: {
		extend: {
			colors: {
				n3: {
					100: "#D1E7DD",
					200: "#A3CFBB",
					300: "#75B79A",
					400: "#47A078",
					500: "#198856",
					600: "#166D47",
					700: "#0F4A30",
					800: "#0B3623",
					900: "#072218"
				}
			}
		}
	}
}',
				'options' => array(
					'minLines' => 40, 
					'maxLines' => 100
				)
			),


		),
	) );