<?php
/**
 * Theme Options Helper Functions
 *
 * - Required Settings Page Capability
 * - Get Theme Settings Sections
 * - Get Theme Settings Defaults
 * - Get Current Theme Settings Values
 * - Separate Settings by Tabs
 *
 * @package		TS_Theme_Settings
 * @copyright	Copyright (c) 2012, Slobodan Manic
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 * @author		Slobodan Manic
 *
 * @since		TS_Theme_Settings 1.0
 */


/**
 * Capability Required to Save Theme Options
 *
 * @return	string	The capability to actually use
 */
function thsp_settings_page_capability() {

	return 'edit_theme_options';
	
}
add_filter( 'thsp_settings_page_capability_filter', 'thsp_settings_page_capability' );


/**
 * Array of Theme Options Sections
 *
 * @uses	thsp_get_theme_options_tabs		defined in /inc/theme-options/get-options.php
 * @since	TS_Theme_Settings 1.0
 */
function thsp_get_theme_options_sections() {

	$thsp_tabs = thsp_get_theme_options_tabs();
	$thsp_sections = array();

	foreach ( $thsp_tabs as $tab ) {
	
		$tabsections = $tab['sections'];
		foreach ( $tabsections as $tabsection ) {
		
			$thsp_sections[] = $tabsection;
			
		}
		
	}
	
	return $thsp_sections;
	
}


/**
 * Get Theme Options Defaults
 * 
 * Returns an array that holds default values for all theme options.
 * 
 * @uses	thsp_get_theme_options_fields()		defined in /inc/theme-options/get-options.php
 * @return	array	$thsp_option_defaults		array of option defaults
 */
function thsp_get_theme_option_defaults() {

	// Get the array that holds all theme option fields
	$thsp_options = thsp_get_theme_options_fields();
	
	// Initialize the array to hold the default values for all theme options
	$thsp_option_defaults = array();
	
	// Loop through the option parameters array
	foreach ( $thsp_options as $option_key => $option_value ) {
	
		// Add an associative array key to the defaults array for each option in the parameters array
		if( isset( $option_value['default'] ) ) {
			$thsp_option_defaults[$option_key] = $option_value['default'];
		} else {
			$thsp_option_defaults[$option_key] = false;
		}
		
	}
	
	// Return the defaults array
	return $thsp_option_defaults;
	
}


/**
 * Get Theme Options Values
 * 
 * Array that holds all of the defined values for theme options. If the user 
 * has not specified a value for a given Theme option, then the option's 
 * default value is used instead.
 *
 * @uses	thsp_get_theme_option_defaults()	defined in /inc/theme-options/get-options.php
 * @return	array								Current values for all theme options
 */
function thsp_get_theme_options() {

	// Get the option defaults
	$option_defaults = thsp_get_theme_option_defaults();
	
	// Parse the stored options with the defaults
	$thsp_theme_options = wp_parse_args( get_option( 'thsp_theme_options', array() ), $option_defaults );
	
	// Return the parsed array
	return $thsp_theme_options;
	
}


/**
 * Separate Settings by Tabs
 * 
 * Returns array of tabs, each of which is an indexed array
 * of settings included with it.
 *
 * @uses	thsp_get_theme_options_fields()		Defined in get-options.php
 * @uses	thsp_get_theme_options_tabs()		Defined in get-options.php
 * @return	$settings_by_tab					Array of arrays of settings by tab
 */
function thsp_separate_settings_by_tabs() {

	// Get the list of settings page tabs
	$tabs = thsp_get_theme_options_tabs();
	
	// Initialize an array to hold an indexed array of tabnames
	$settings_by_tab = array();
	
	// Loop through the array of tabs
	foreach ( $tabs as $tab ) {
		$tabname = $tab['name'];
		// Add an indexed array key to the settings-by-tab array for each tab name
		$settings_by_tab[] = $tabname;
	}
	
	// Get the array of options
	$thsp_options = thsp_get_theme_options_fields();
	
	// Loop through the option parameters array
	foreach ( $thsp_options as $option_key => $option_value ) {
	
		$option_name	= $option_key;
		$option_tab		= $option_value['tab'];
		
		// Add an indexed array key to the settings-by-tab array for each setting associated with each tab
		$settings_by_tab[$option_tab][]		= $option_name;
		$settings_by_tab['all'][]			= $option_name;
		
	}
	
	// Return the settings-by-tab (array)
	return $settings_by_tab;
	
}