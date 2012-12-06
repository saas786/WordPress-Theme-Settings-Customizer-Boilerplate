<?php
/**
 * TS Theme Settings + Customizer
 *
 * @package		TS_Theme_Settings
 * @copyright	Copyright (c) 2012, Slobodan Manic
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 * @author		Slobodan Manic
 *
 * @since		TS_Theme_Settings 1.0
 */


/**
 * Registers the settings
 */
add_action( 'admin_init', 'thsp_theme_options_init' );
function thsp_theme_options_init() {
	
	require( get_template_directory() . '/inc/theme-options/register-options.php' );
	
}


/**
 * Arrays of option fields and tabs
 */	
require( get_template_directory() . '/inc/theme-options/get-options.php' );


/**
 * Helper functions, used both in admin and frontend
 */	
require( get_template_directory() . '/inc/theme-options/helpers.php' );

if( is_admin() ) {

	/**
	 * Create theme settings page
	 */	
	require( get_template_directory() . '/inc/theme-options/settings-page.php' );

	/**
	 * Customizer options
	 */	
	require( get_template_directory() . '/inc/theme-options/customizer.php' );
	
}