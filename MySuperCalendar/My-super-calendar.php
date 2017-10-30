<?php

/*
Plugin Name: My Super Calendar
Description: My Super Calendar Widget
Version: 1.0
Author: Shinkarenko Sergey
*/




if ( ! defined( 'WPINC' ) ) {
	die;
}

function activate_MySuperCalendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-MySuperCalendar-activator.php';
	MySuperCalendar_Activator::activate();
}


function deactivate_MySuperCalendar() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-MySuperCalendar-deactivator.php';
	MySuperCalendar_Dectivator::deactivate();

}
register_activation_hook( __FILE__, 'activate_MySuperCalendar' );
register_deactivation_hook( __FILE__, 'deactivate_MySuperCalendar' );


/**
 * The core plugin class
 */


require plugin_dir_path( __FILE__ ) . 'includes/class-MySuperCalendar.php';


function run_MySuperCalendar() {
	$plugin = new MySuperCalendar();
	$plugin->run();

}
run_MySuperCalendar();







