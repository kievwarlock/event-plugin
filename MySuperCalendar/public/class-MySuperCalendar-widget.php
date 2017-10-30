<?php

/**
 *  Init Widgets.
 */


class MySuperCalendar_Widget {


	private $plugin_name;


	public function __construct( $plugin_name) {

		$this->plugin_name = $plugin_name;

	}

	public function enqueue_styles() {


		wp_enqueue_style( $this->plugin_name . '-style-jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(),'', 'all' );
		wp_enqueue_style( $this->plugin_name . '-style-eventCalendar', plugin_dir_url( __FILE__ ) . 'css/eventCalendar.css', array(),'', 'all' );
		wp_enqueue_style( $this->plugin_name . '-style-eventCalendar_theme_responsive', plugin_dir_url( __FILE__ ) . 'css/eventCalendar_theme_responsive.css', array(),'', 'all' );
		wp_enqueue_style( $this->plugin_name . '-style-public', plugin_dir_url( __FILE__ ) . 'css/MySuperCalendar-public.css', array(),'', 'all' );


	}

	//  register MySuperCalendar_widget
	public function register_calendar_widget() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/widget/MySuperCalendar-widget.php';
		register_widget( 'MySuperCalendarEvent_Widget' );
	}






}
