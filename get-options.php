<?php
/**
 * Get Theme Options
 *
 * - Theme Options Fields
 * - Theme Settings Page Tabs
 *
 * @package		TS_Theme_Settings
 * @copyright	Copyright (c) 2012, Slobodan Manic
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 * @author		Slobodan Manic
 *
 * @since		TS_Theme_Settings 1.0
 */


/**
 * Helper function that holds array of theme options fields.
 *
 * @return	array	$options	Array of setting fields
 */
function thsp_get_theme_options_fields() {

	$options = array(

		'sample_option' => array(
		
			// Field ID
			'name'					=> 'sample_option',
			
			// Field display name
			'title'					=> __( 'Display name for sample option', 'ts_theme_settings' ),
			
			// Field type (radio, checkbox, checkbox_group, select, text, number, textarea, custom)
			'type'					=> 'radio',

			// Field callback function, for custom field type
			'callback'				=> 'custom_field_cb',
						
			// Field description, optional
			'description'			=> 'Field description',
			
			// Section this field belongs to
			'section'				=> 'sample_section',
			
			// Tab this field belongs to
			'tab'					=> 'sample_tab',
			
			// Theme version in which field was introduced
			'since'					=> '1.0',
			
			// Field default value
			'default'				=> 'Default value',
			
			// Valid options, used for radio, checkbox_group and select fields
			'options'				=> array(
				'valid_option_1'	=> array(
					'name'			=> 'valid_option_1',
					'title'			=> 'Valid option 1',
					'description'	=> 'Valid option 1 description'
				),
				'valid_option_2'	=> array(
					'name'			=> 'valid_option_2',
					'title'			=> 'Valid option 2',
					'description'	=> 'Valid option 2 description'
				)
			),
			
			// Sanitization, used in text and textarea fields
			'sanitization'			=> 'nohtml',
			
			// Add this to hide option from Customizer
			'customizer_hide'		=> true
			
		),

		// Checkbox
		'sample_checkbox_option' => array(
			'name'					=> 'sample_checkbox_option',
			'title'					=> __( 'Display name for sample checkbox option', 'ts_theme_settings' ),
			'type'					=> 'checkbox',
			'description'			=> __( 'Field description for sample checkbox option', 'ts_theme_settings' ),
			'section'				=> 'first_tab_first',
			'tab'					=> 'first_tab',
			'since'					=> '1.0'
		),

		// Checkbox group
		'sample_checkbox_group_option' => array(
			'name'					=> 'sample_checkbox_group_option',
			'title'					=> __( 'Display name for sample checkbox group option', 'ts_theme_settings' ),
			'type'					=> 'checkbox_group',
			'description'			=> __( 'Field description for sample checkbox group option', 'ts_theme_settings' ),
			'section'				=> 'first_tab_first',
			'tab'					=> 'first_tab',
			'since'						=> '1.0',
			'default'				=> array(
				'valid_option_1',
				'valid_option_4'
			),
			'options'				=> array(
				'valid_option_1'	=> array(
					'name'			=> 'valid_option_1',
					'title'			=> 'Valid option 1',
					'description'	=> 'Valid option 1 description'
				),
				'valid_option_2'	=> array(
					'name'			=> 'valid_option_2',
					'title'			=> 'Valid option 2'
				),
				'valid_option_3'	=> array(
					'name'			=> 'valid_option_3',
					'title'			=> 'Valid option 3'
				),
				'valid_option_4'	=> array(
					'name'			=> 'valid_option_4',
					'title'			=> 'Valid option 4',
					'description'	=> 'Valid option 4 description'
				)
			)
		),

		// Radio
		'sample_radio_option' => array(
			'name'					=> 'sample_radio_option',
			'title'					=> __( 'Display name for sample radio option', 'ts_theme_settings' ),
			'type'					=> 'radio',
			'description'			=> __( 'Field description for sample radio option', 'ts_theme_settings' ),
			'section'				=> 'first_tab_second',
			'tab'					=> 'first_tab',
			'since'					=> '1.0',
			'default'				=> 'valid_option_2',
			'options'				=> array(
				'valid_option_1'	=> array(
					'name'			=> 'valid_option_1',
					'title'			=> 'Valid option 1',
					'description'	=> 'Valid option 1 description'
				),
				'valid_option_2'	=> array(
					'name'			=> 'valid_option_2',
					'title'			=> 'Valid option 2'
				),
				'valid_option_3'	=> array(
					'name'			=> 'valid_option_3',
					'title'			=> 'Valid option 3'
				),
				'valid_option_4'	=> array(
					'name'			=> 'valid_option_4',
					'title'			=> 'Valid option 4',
					'description'	=> 'Valid option 4 description'
				)
			)
		),

		// Select
		'sample_select_option' => array(
			'name'					=> 'sample_select_option',
			'title'					=> __( 'Display name for sample select option', 'ts_theme_settings' ),
			'type'					=> 'select',
			'description'			=> __( 'Field description for sample select option', 'ts_theme_settings' ),
			'section'				=> 'first_tab_second',
			'tab'					=> 'first_tab_second',
			'since'					=> '1.0',
			'default'				=> 'valid_option_2',
			'options'				=> array(
				'valid_option_1'	=> array(
					'name'			=> 'valid_option_1',
					'title'			=> 'Valid option 1',
					'description'	=> 'Valid option 1 description'
				),
				'valid_option_2'	=> array(
					'name'			=> 'valid_option_2',
					'title'			=> 'Valid option 2',
					'description'	=> 'Valid option 2 description'
				)
			)
		),

		// Text field
		'sample_text_field_option' => array(
			'name'					=> 'sample_text_field_option',
			'title'					=> __( 'Display name for sample text field option', 'ts_theme_settings' ),
			'type'					=> 'text',
			'description'			=> __( 'Field description for sample text field option', 'ts_theme_settings' ),
			'section'				=> 'second_tab_first',
			'tab'					=> 'second_tab',
			'since'					=> '1.0',
			'sanitization'			=> 'nohtml'
		),

		// Textarea
		'sample_textarea_option' => array(
			'name'					=> 'sample_textarea_option',
			'title'					=> __( 'Display name for sample textarea option', 'ts_theme_settings' ),
			'type'					=> 'textarea',
			'description'			=> __( 'Field description for sample textarea option', 'ts_theme_settings' ),
			'section'				=> 'second_tab_first',
			'tab'					=> 'second_tab',
			'since'					=> '1.0',
			'sanitization'			=> 'nohtml'
		),

		// Number
		'sample_number_option' => array(
			'name'					=> 'sample_number_option',
			'title'					=> __( 'Display name for sample number option', 'ts_theme_settings' ),
			'type'					=> 'number',
			'description'			=> __( 'Field description for sample number option', 'ts_theme_settings' ),
			'section'				=> 'second_tab_second',
			'tab'					=> 'second_tab',
			'since'					=> '1.0',
			'default'				=> 10
		)
	);
	
	return $options;
	
}


/**
 * Helper function that holds array of theme options tabs and their sections
 *
 * @return	array	$tabs	Array of setting page tabs
 */
function thsp_get_theme_options_tabs() {

	$tabs = array(
		'first_tab' => array(
			// Tab ID
			'name' => 'first_tab',
			// Tab display Title
			'title' => __( 'First Tab Options', 'ts_theme_settings' ),
			// Tab sections array
			'sections' => array(
				'first_tab_first' => array(
					// Section ID
					'name' => 'first_tab_first',
					// Section display title
					'title' => __( 'First Tab First', 'ts_theme_settings' ),
					// Section description, optional
					'description' => __( 'This is the first section in the first tab', 'ts_theme_settings' )
				),
				'first_tab_second' => array(
					'name' => 'first_tab_second',
					'title' => __( 'First Tab Second', 'ts_theme_settings' ),
					'description' => __( 'This is the second section in the first tab', 'ts_theme_settings' )
				)
			)
		),
		'second_tab' => array(
			'name' => 'second_tab',
			'title' => __( 'Second Tab Options', 'ts_theme_settings' ),
			'sections' => array(
				'second_tab_first' => array(
					'name' => 'second_tab_first',
					'title' => __( 'Second Tab First', 'ts_theme_settings' ),
					'description' => __( 'This is the first section in the second tab', 'ts_theme_settings' )
				),
				'second_tab_second' => array(
					'name' => 'second_tab_second',
					'title' => __( 'Second Tab Second', 'ts_theme_settings' ),
					'description' => __( 'This is the second section in the second tab', 'ts_theme_settings' )
				)
			)
		)
	);

	return $tabs;
	
}