<?php
/**
 * Short codes in visual editor
 * Register short code buttons and add them to the visual mode of editor
 */

// Register Buttons
function sp_shortcodes_register_mce_button( $buttons ) {
	array_push( $buttons, 'col' );
	array_push( $buttons, 'horz_rule' );
	array_push( $buttons, 'email_encoder' );
	array_push( $buttons, 'slider' );
	array_push( $buttons, 'accordion' );
	array_push( $buttons, 'toggle' );
	array_push( $buttons, 'tab' );
	array_push( $buttons, 'gallery' );
	array_push( $buttons, 'player' );
	array_push( $buttons, 'newsletter' );

    return $buttons;
}

// Register TinyMCE Plugin
function sp_shortcodes_add_tinymce_plugin($plugin_array) {
	$plugin_array['col'] 			= ED_JS_URL . 'ed-columns.js';
	$plugin_array['horz_rule']		= ED_JS_URL . 'ed-hr.js';
	$plugin_array['email_encoder']	= ED_JS_URL . 'ed-email-encoder.js';
	$plugin_array['slider']			= ED_JS_URL . 'ed-slider.js';
	$plugin_array['accordion']		= ED_JS_URL . 'ed-accordion.js';
	$plugin_array['toggle']			= ED_JS_URL . 'ed-toggle.js';
	$plugin_array['tab']			= ED_JS_URL . 'ed-tab.js';
	$plugin_array['gallery']		= ED_JS_URL . 'ed-gallery.js';
	$plugin_array['player']			= ED_JS_URL . 'ed-player.js';
	$plugin_array['newsletter']		= ED_JS_URL . 'ed-newsletter.js';
	
    return $plugin_array;
 }

// Initialization Function
function sp_shortcodes_add_mce_button() {

    if ( current_user_can( 'edit_posts' ) &&  current_user_can( 'edit_pages' ) ) {
	  add_filter( 'mce_external_plugins', 'sp_shortcodes_add_tinymce_plugin' );
      add_filter( 'mce_buttons_3', 'sp_shortcodes_register_mce_button' );
	}
 }
add_action( 'admin_head', 'sp_shortcodes_add_mce_button' );  

load_template( SC_INC_DIR . 'popup/ajax-slider-shortcode.php' );
load_template( SC_INC_DIR . 'popup/ajax-gallery-shortcode.php' );
load_template( SC_INC_DIR . 'popup/ajax-player-shortcode.php' );

?>