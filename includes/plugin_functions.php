<?php
if ( !defined('ABSPATH') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

add_action('admin_init', 'boilerplate_admin_init');
function boilerplate_admin_init(){
	add_filter(	'plugin_row_meta',	'boilerplate_init_row_meta',10,2);
	add_filter(	'plugin_action_links_' . plugin_basename( BOILERPLATE_ROOT_FILE ), 'boilerplate_init_action_links');
}

function boilerplate_tab($tabs) {
	$tabs['boilerplate'] = __( 'Boilerplate', WPeMatico::TEXTDOMAIN );
	return $tabs;
}
add_filter( 'wpematico_settings_tabs',  'boilerplate_tab');

/*function boilerplate_license_menu() {
	add_submenu_page(
				'edit.php?post_type=wpematico',
				'SMTP Settings',
				'SMTP <span class="dashicons-before dashicons-admin-plugins"></span>',
				'manage_options',
				'boilerplate_license',
				'boilerplate_license_page'
			);
	//add_plugins_page( 'Plugin License', 'Plugin License', 'manage_options', 'boilerplate_license', 'boilerplate_license_page' );
}
add_action('admin_menu', 'boilerplate_license_menu');
*/


/** * Activate Boilerplate on Activate Plugin */
register_activation_hook( plugin_basename( BOILERPLATE_ROOT_FILE ), 'boilerplate_activate' );
function boilerplate_activate() {
	if(class_exists('WPeMatico')) {
		$cfg = get_option(WPeMatico :: OPTION_KEY);
		if( update_option( WPeMatico::OPTION_KEY, $cfg ) ) {
			$link= '<a href="' . admin_url("edit.php?post_type=wpematico&page=wpematico_settings&tab=boilerplate") . '">'.__('Boilerplate Plugin Settings.',  'boilerplate')."</a>";
			$notice= __('Boilerplate Activated.  Please check the fields on', 'boilerplate').' '. $link;
			WPeMatico::add_wp_notice( array('text' => $notice , 'below-h2'=>false ) );
		}
	}
}

/** * Deactivate Boilerplate on Deactivate Plugin  */
register_deactivation_hook( plugin_basename( BOILERPLATE_ROOT_FILE ), 'boilerplate_deactivate' );
function boilerplate_deactivate() {
	if(class_exists('WPeMatico')) {
		if( update_option( WPeMatico::OPTION_KEY, $cfg ) ) {
			$notice= __('Boilerplate DEACTIVATED.',  'boilerplate');
			WPeMatico::add_wp_notice( array('text' => $notice , 'below-h2'=>false ) );
		}
	}
}

/*
register_uninstall_hook( plugin_basename( __FILE__ ), 'boilerplate_uninstall' );
function boilerplate_uninstall() {
	
}
*/



/**
* Actions-Links del Plugin
*
* @param   array   $data  Original Links
* @return  array   $data  modified Links
*/
function boilerplate_init_action_links($data)	{
	if ( !current_user_can('manage_options') ) {
		return $data;
	}
	return array_merge(
		$data,
		array(
			'<a href="'.  admin_url('edit.php?post_type=wpematico&page=wpematico_settings&tab=boilerplate').'" title="' . __('Go to Boilerplate Settings Page') . '">' . __('Settings') . '</a>',
		)
	);
}

/**
* Meta-Links del Plugin
*
* @param   array   $data  Original Links
* @param   string  $page  plugin actual
* @return  array   $data  modified Links
*/

function boilerplate_init_row_meta($data, $page)	{
	if ( basename($page) != 'boilerplate.php' ) {
		return $data;
	}
	return array_merge(
		$data,
		array(
		'<a href="https://etruel.com/" target="_blank">' . __('etruel Store') . '</a>',
		'<a href="https://etruel.com/my-account/support/" target="_blank">' . __('Support') . '</a>',
		'<a href="https://wordpress.org/support/view/plugin-reviews/wpematico?filter=5&rate=5#postform" target="_Blank" title="Rate 5 stars on Wordpress.org">' . __('Rate Plugin' ) . '</a>'
		)
	);
}	

