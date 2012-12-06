<?php
/**
 * Theme Options Page
 *
 * - Settings Page Capability Callback
 * - Add Theme Options Page
 * - Options Page Callback Function
 *
 * @package		TS_Theme_Settings
 * @copyright	Copyright (c) 2012, Slobodan Manic
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 * @author		Slobodan Manic
 *
 * @since		TS_Theme_Settings 1.0
 */


/**
 * Add our theme options page to the admin menu
 *
 * This function is attached to the admin_menu action hook
 *
 * @uses	thsp_settings_page_capability()		Defined in helpers.php
 * @link	add_theme_page()					http://codex.wordpress.org/Function_Reference/add_theme_page
 */
function thsp_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'cazuela' ),   // Name of page
		__( 'Theme Options', 'cazuela' ),   // Label in menu
		thsp_settings_page_capability(),	// Capability required
		'thsp_theme_options',               // Menu slug, used to uniquely identify the page
		'thsp_theme_options_render_page'	// Function that renders the options page
	);
}
add_action( 'admin_menu', 'thsp_theme_options_add_page' );


/**
 * Renders the Theme Settings dashboard page
 *
 * If tab GET parameter is not set, first tab is shown by default
 *
 * @uses	thsp_get_theme_options_tabs()	Defined in get-options.php
 * @link	screen_icon()					http://codex.wordpress.org/Function_Reference/screen_icon
 * @link	settings_errors()				http://codex.wordpress.org/Function_Reference/settings_errors
 * @link	settings_fields()				http://codex.wordpress.org/Function_Reference/settings_fields
 * @link	do_settings_sections()			http://codex.wordpress.org/Function_Reference/do_settings_sections
 * @link	submit_button()					http://codex.wordpress.org/Function_Reference/submit_button
 */
function thsp_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<?php $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme(); ?>
		<h2><?php printf( __( '%s Theme Options', 'cazuela' ), $theme_name ); ?></h2>
		<?php settings_errors(); ?>

		<?php
			if( isset( $_GET[ 'tab' ] ) ) {  
				$current = $_GET[ 'tab' ];  
			} else $current = 'first_tab';
			$tabs = thsp_get_theme_options_tabs();
			$links = array();
			
			foreach( $tabs as $tab ) {
				$tabname = $tab['name'];
				$tabtitle = $tab['title'];
				if ( $tabname == $current ) {
					$links[] = '<a class="nav-tab nav-tab-active" href="?page=thsp_theme_options&tab=' . $tabname . '">' . $tabtitle . '</a>';
				} else {
					$links[] = '<a class="nav-tab" href="?page=thsp_theme_options&tab=' . $tabname . '">' . $tabtitle . '</a>';
				}
			}
		?>
		
		<h2 class="nav-tab-wrapper">
		<?php
		foreach ( $links as $link ) {
			echo $link;
		}
		?>
		</h2>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'thsp_theme_options' );
				do_settings_sections( $current );

				echo '<div>';
				submit_button(
					__( 'Save Settings', 'cazuela' ),
					'primary',
					'thsp_theme_options[submit-' . $current . ']',
					false,
					array(
						'style' => 'margin-right:1em;margin-top:2em;',
					)
				);
				submit_button(
					__( 'Reset Defaults', 'cazuela' ),
					'secondary',
					'thsp_theme_options[reset-' . $current . ']',
					false,
					array(
						'style' => 'margin-top:2em;',
					)
				);
				echo '</div>';
			?>
		</form>
	</div>
	<?php
}