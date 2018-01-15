<?php
add_action( 'admin_init', 'my_tinymce_button' );
function my_tinymce_button() {
 
          add_filter( 'mce_buttons', 'my_register_tinymce_button' );
          add_filter( 'mce_external_plugins', 'my_add_tinymce_button' );
     
}

function my_register_tinymce_button( $buttons ) {
     array_push( $buttons, "button_eek", "button_green" );
     return $buttons;
}

function my_add_tinymce_button( $plugins ) {
	$plugins['insertSC'] = plugins_url( '/res/x-tab.js', __FILE__);
	return $plugins;
}

// function tl_save_error() {
//     update_option( 'plugin_error',  ob_get_contents() );
// }
// add_action( 'activated_plugin', 'tl_save_error' );
// echo get_option( 'plugin_error' );