<?php
/**
 * plugin activation
 */

class MySuperCalendar_Activator {

	public static function activate() {
		update_option( 'event_calendar_title', 'Events Calendar' );
	}
}