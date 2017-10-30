<?php
/**
 * the core plugin class
 */

class MySuperCalendar {

	protected $loader;
	protected $plugin_name;



	public function __construct() {

		$this->plugin_name = 'MySuperCalendar';
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_public_widget();

	}



	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-MySuperCalendar-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-MySuperCalendar-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-MySuperCalendar-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-MySuperCalendar-widget.php';
		$this->loader = new MySuperCalendar_Loader();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 */
	private function define_admin_hooks() {
		$plugin_admin = new MySuperCalendar_Admin( $this->get_plugin_name() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_Calendar_post_type' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_datepicker_meta_box' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_calendar_post' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_plugin_menu_page' );


	}



	/**
	 * Register all widget
	 */
	private function define_public_widget() {

		$widget_class = new MySuperCalendar_widget( $this->get_plugin_name() );
		$this->loader->add_action( 'widgets_init', $widget_class, 'register_calendar_widget' );

	}




	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 */
	private function define_public_hooks() {
		$plugin_public = new MySuperCalendar_Public( $this->get_plugin_name() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );



		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'calendarAjax_data', 99 );

		$this->loader->add_action( 'wp_ajax_nopriv_calendarAjax', $plugin_public, 'calendarAjax' );
		$this->loader->add_action( 'wp_ajax_calendarAjax', $plugin_public, 'calendarAjax' );





	}



	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}




}