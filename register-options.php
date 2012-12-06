<?php
/**
 * Registers Theme Options and callback functions
 *
 * - Register Setting
 * - Add Settings Sections
 * - Sections Callback Function
 * - Add Settings Fields
 * - Settings Fields Callback Function
 * - Settings Fields Validate Callback
 *
 * @package		TS_Theme_Settings
 * @copyright	Copyright (c) 2012, Slobodan Manic
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 * @author		Slobodan Manic
 *
 * @since		TS_Theme_Settings 1.0
 */


/**
 * Register theme settings
 * 
 * Register theme options array to hold all theme options.
 *
 * @link	register_setting()		http://codex.wordpress.org/Function_Reference/register_setting
 */
register_setting(
	'thsp_theme_options', 			// $option_group
	'thsp_theme_options',			// $option_name
	'thsp_validate_theme_options' 	// $sanitize_callback
);


/**
 * Add settings sections 
 * 
 * Loop through theme settings page tabs, uses add_settings_section()
 * to add a new section for each section specified for each tab.
 *
 * @uses	thsp_get_theme_options_tabs()	defined in /inc/theme-options/get-options.php
 */
$thsp_tabs = thsp_get_theme_options_tabs();
foreach ( $thsp_tabs as $thsp_tab ) {

	$tab_name		= $thsp_tab['name'];
	$tab_sections	= $thsp_tab['sections'];
	
	foreach ( $tab_sections as $tab_section ) {
	
		$section_name	= $tab_section['name'];
		$section_title	= $tab_section['title'];
		
		// Add settings section
		add_settings_section(
			$section_name,							// $id
			$section_title,							// $title
			'thsp_sections_callback',				// $callback
			$tab_name								// $page
		);
		
	}
	
}


/**
 * Callback for add_settings_section()
 * 
 * Outputs section text
 * 
 * @uses	thsp_get_theme_options_tabs()	defined in /inc/theme-options/register-options.php
 * @param	array	$section_passed			Array passed from add_settings_section()
 */
function thsp_sections_callback( $section_passed ) {

	$thsp_tabs = thsp_get_theme_options_tabs();
	
	foreach ( $thsp_tabs as $thsp_tab ) {
	
		$tab_sections = $thsp_tab['sections'];
		foreach ( $tab_sections as $tab_section ) {
		
			if ( $tab_section['name'] == $section_passed['id'] && isset( $tab_section['description'] ) ) {
				?>
				<p><?php echo $tab_section['description']; ?></p>
				<?php
			}
			
		}
		
	}
	
}


/**
 * Add settings fields 
 * 
 * Loops through settings fields array, uses add_settings_field()
 * to add a new field to theme options for each setting. 
 *
 * @uses	thsp_get_theme_options_fields()		defined in /inc/theme-options/get-options.php
 * @uses	add_settings_field()				http://codex.wordpress.org/Function_Reference/add_settings_field
 */
$thsp_options = thsp_get_theme_options_fields();
foreach ( $thsp_options as $option_key => $option_value ) {

	$option_name		= $option_value['title'];
	$option_tab			= $option_value['tab'];
	$option_section		= $option_value['section'];
	$option_type		= $option_value['type'];
	
	if ( 'custom' != $option_type ) {
		add_settings_field(
			$option_key,									// $settingid
			$option_name,									// $title
			'thsp_setting_callback',						// $callback
			$option_tab,									// $pageid
			$option_section,								// $sectionid
			$option_value									// $args
		);
		
	} if ( 'custom' == $option_type ) {
		add_settings_field(
			$option_name,									// $settingid
			$option_title,									// $title
			'thsp_setting_' . $option_key,					// $callback
			$option_tab,									// $pageid
			$option_section									// $sectionid
		);
	}
	
}


/**
 * Callback for add_settings_field()
 */
function thsp_setting_callback( $option ) {

	$thsp_theme_options = thsp_get_theme_options();
	
	$option_name			= $option['name'];
	$option_title			= $option['title'];
	$option_description		= $option['description'];
	$option_type			= $option['type'];
	$field_name				= 'thsp_theme_options[' . $option_name . ']';
	
	switch( $option_type ) {
	
		/*
		 * Output checkbox form field markup based on field type
		 * Possible options: checkbox, checkbox_group, radio, select, text, textarea, number
		 */
		
		// Radio
		case 'radio' :
			$given_options = $option['options'];
			foreach ( $given_options as $given_option_key => $given_option_value ) {
				?>
				<label for="<?php echo $option_name . '_' . $given_option_key; ?>">
					<input type="radio" id="<?php echo $option_name . '_' . $given_option_key; ?>" name="<?php echo $field_name; ?>" <?php checked( $given_option_key == $thsp_theme_options[$option_name] ); ?> value="<?php echo $given_option_key; ?>" />
	
					<?php echo $given_option_value['title']; ?>
					<?php if ( isset( $given_option_value['description'] ) ) { ?>
						 (<em><?php echo $given_option_value['description']; ?></em>)
					<?php } ?>
				</label>
				<br />
				<?php
			}
			break;
	
		// Checkbox
		case 'checkbox' :
			?>
			<label for="<?php echo $field_name; ?>">
				<input type="checkbox" name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" <?php checked( $thsp_theme_options[$option_name] ); ?> />
					
				<?php echo $option_title; ?>
				<?php if ( isset( $option_description ) ) { ?>
					 (<em><?php echo $option_description; ?></em>)
				<?php } ?>
			</label>
			<?php
			break;

		// Checkbox group
		case 'checkbox_group' :
			$given_options = $option['options'];
			foreach ( $given_options as $given_option_key => $given_option_value ) {
				?>
				<label for="<?php echo $option_name . '_' . $given_option_key; ?>">
					<input type="checkbox" name="<?php echo $field_name; ?>[]" id="<?php echo $option_name . '_' . $given_option_key; ?>" <?php checked( in_array( $given_option_key, $thsp_theme_options[$option_name] ) ); ?> value="<?php echo $given_option_key; ?>" />
					
					<?php echo $given_option_value['title']; ?>
					<?php if ( isset( $given_option_value['description'] ) ) { ?>
						 (<em><?php echo $given_option_value['description']; ?></em>)
					<?php } ?>
				</label>
				<br />
				<?php
			} // end foreach
			break;
	
		// Dropdown
		case 'select' :
			$given_options = $option['options'];
			?>
			<select name="<?php echo $field_name; ?>">
			<?php 
			foreach ( $given_options as $given_option_key => $given_option_value ) {
				?>
				<option <?php selected( $given_option_key == $thsp_theme_options[$option_name] ); ?> value="<?php echo $given_option_key; ?>"><?php echo $given_option_value['title']; ?></option>
				<?php
			}
			?>
			</select>
			<?php
			break;
	
		// Text input
		case 'text' :
			?>
			<label for="<?php echo $field_name; ?>">
				<input type="text" name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" value="<?php echo isset( $thsp_theme_options[$option_name] ) ? wp_filter_nohtml_kses( $thsp_theme_options[$option_name] ) : '' ?>" />
			</label>
			<?php
			break;

		// Number
		case 'number' :
			?>
			<label for="<?php echo $field_name; ?>">
				<input type="number" step="1" min="1" name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" class="small-text" value="<?php echo intval( $thsp_theme_options[$option_name] ); ?>" />
				<?php echo $option_title; ?>
			</label>
			<?php
			break;

		// Textarea
		case 'textarea' :
			?>
			<label for="<?php echo $field_name; ?>">
				<textarea name="<?php echo $field_name; ?>" rows="5" cols="30" id="<?php echo $field_name; ?>" class="large-text"><?php echo isset( $thsp_theme_options[$option_name] ) ? esc_textarea( $thsp_theme_options[$option_name] ) : '' ?></textarea>
			</label>
			<?php
			break;
			
	}
	
	// Output the setting description
	if( isset( $option_description ) ) { ?>
		<p class="description"><?php echo $option_description; ?></p>
	<?php }
}


/**
 * Callback for register_setting()
 *
 * @uses	thsp_get_theme_options()			Defined in helpers.php
 * @uses	thsp_separate_settings_by_tabs()	Defined in helpers.php
 * @uses	thsp_get_theme_options_fields()		Defined in get-options.php
 * @uses	thsp_get_theme_option_defaults()	Defined in helpers.php
 * @uses	thsp_get_theme_options_tabs()		Defined in get-options.php
 * @return	$valid_input						Array of validated options
 */
function thsp_validate_theme_options( $input ) {

	// This is the "whitelist": current settings
	$valid_input = thsp_get_theme_options();

	// Get the array of Theme settings, by Settings Page tab
	$settings_by_tab = thsp_separate_settings_by_tabs();

	// Get the array of all option fields
	$option_fields = thsp_get_theme_options_fields();
	
	// Get the array of option defaults
	$option_defaults = thsp_get_theme_option_defaults();
	
	// Get list of tabs
	$thsp_tabs = thsp_get_theme_options_tabs();
	
	// Determine what type of submit was input
	$submit_type = 'submit';	
	foreach ( $thsp_tabs as $thsp_tab ) {
	
		$reset_name = 'reset-' . $thsp_tab['name'];
		if ( !empty( $input[$reset_name] ) ) {
			$submit_type = 'reset';
		}
		
	}
	
	// Determine which tab was input
	$submit_tab = 'layout_options';	
	foreach ( $thsp_tabs as $thsp_tab ) {
	
		$submit_name	= 'submit-' . $thsp_tab['name'];
		$reset_name		= 'reset-' . $thsp_tab['name'];
		if ( !empty( $input[$submit_name] ) || !empty( $input[$reset_name] ) ) {
			$submit_tab = $thsp_tab['name'];
		}
		
	}
	
	// Get settings by tab
	global $wp_customize;
	$tab_settings = ( isset( $wp_customize ) ? $settings_by_tab['all'] : $settings_by_tab[$submit_tab] );
	
	// Loop through each tab setting
	foreach ( $tab_settings as $setting ) {
	
		// If no option is selected, set the default
		$valid_input[$setting] = ( !isset( $input[$setting] ) ? $option_defaults[$setting] : $input[$setting] );
		
		// If submit, validate/sanitize $input
		if ( 'submit' == $submit_type ) {

			// Get the setting details from the defaults array
			$option_details = $option_fields[$setting];
			
			// Get the array of valid options, if applicable
			$valid_options = ( isset( $option_details['options'] ) ? $option_details['options'] : false );
			
			switch( $option_details['type'] ) {
				
				// Validate checkbox fields
				case 'checkbox' :
					$valid_input[$setting] = ( ( isset( $input[$setting] ) && true == $input[$setting] ) ? true : false );
					break;

				// Validate checkbox group fields
				case 'checkbox_group' :
					$given_options = $option_details['options'];
					
					if( isset( $input[$setting] ) && is_array( $input[$setting] ) ) {
						foreach( $input[$setting] as $submitted_option ) {
							// Make sure this is one of given options
							if( array_key_exists( $submitted_option, $valid_options ) ) {
								$valid_input[$setting][] = $submitted_option;						
							}
						} // end foreach
					} else {
						$valid_input[$setting] = array();
					}
					break;
				
				// Validate radio button fields
				case 'radio' :
					// Only update setting if input value is in the list of valid options
					$valid_input[$setting] = ( array_key_exists( $input[$setting], $valid_options ) ? $input[$setting] : $valid_input[$setting] );
					break;
				
				// Validate select fields
				case 'select' :
					// Only update setting if input value is in the list of valid options
					$valid_input[$setting] = ( array_key_exists( $input[$setting], $valid_options ) ? $input[$setting] : $valid_input[$setting] );
					break;
				
				// Validate text input and textarea fields
				case 'text' :
				case 'textarea' :
					// Validate no-HTML content
					if ( 'nohtml' == $option_details['sanitization'] ) {
						// Pass input data through the wp_filter_nohtml_kses filter
						$valid_input[$setting] = wp_filter_nohtml_kses( $input[$setting] );
					}
					// Validate HTML content
					if ( 'html' == $option_details['sanitization'] ) {
						// Pass input data through the wp_filter_kses filter
						$valid_input[$setting] = wp_filter_kses( $input[$setting] );
					}
					break;
					
				// Validate number fields
				case 'number' :
					$valid_input[$setting] = intval( $input[$setting] );
					break;
			}
						
		// If reset, reset defaults
		} elseif ( 'reset' == $submit_type ) {
		
			// Set $setting to the default value
			if( isset( $option_defaults[$setting] ) ) {
				// If default value has been defined
				$valid_input[$setting] = $option_defaults[$setting];
			} else {
				// Otherwise, remove value
				unset( $valid_input[$setting] );
			}
		}
		
		
	}
	
	return $valid_input;
			
}