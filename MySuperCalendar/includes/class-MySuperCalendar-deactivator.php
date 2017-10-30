<?php
/**
 * plugin deactivation
 */

class MySuperCalendar_Dectivator {

	public static function deactivate() {

		// Delete options
		delete_option('event_calendar_title');

		// unregister_post_type
		$MySuperCalendar = new MySuperCalendar();
		$MySuperCalendar_admin = new MySuperCalendar_Admin( $MySuperCalendar->get_plugin_name() );
		unregister_post_type( $MySuperCalendar_admin->get_post_type() );


	}


}