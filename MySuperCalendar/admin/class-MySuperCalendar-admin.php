<?php

/**
 * The admin-specific functionality of the plugin.
 */


class MySuperCalendar_Admin {


	private 	$plugin_name;
	protected 	$plugin_post_type;
	protected 	$plugin_post_type_label;



	public function __construct( $plugin_name ) {
		$this->plugin_name = $plugin_name;
		$this->plugin_post_type = 'calendar';
		$this->plugin_post_type_label = 'Events calendar';
	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name . '-jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(),'', 'all' );
		wp_enqueue_style( $this->plugin_name . '-timepicker-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui-timepicker-addon.css', array(),'', 'all' );
		wp_enqueue_style( $this->plugin_name . '-admin-style', plugin_dir_url( __FILE__ ) . 'css/MySuperCalendar-admin.css', array(),'', 'all' );


	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . '-jquery-ui-js', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.js', array( 'jquery' ), '', true );
		wp_enqueue_script( $this->plugin_name . '-admin-timepicker-scripts', plugin_dir_url( __FILE__ ) . 'js/jquery-ui-timepicker-addon.js', array( 'jquery' ), '', true );
		wp_enqueue_script( $this->plugin_name . '-admin-scripts', plugin_dir_url( __FILE__ ) . 'js/MySuperCalendar-admin.js', array( 'jquery' ), '', false );


	}



	public function register_Calendar_post_type() {


		register_post_type($this->plugin_post_type, array(
			'label'               => $this->plugin_post_type_label,
			'labels'              => array(
				'name'          => $this->plugin_post_type_label,
				'singular_name' => 'Event calendar',
				'menu_name'     => 'My Super Calendar',
				'all_items'     => 'All events',
				'add_new'       => 'Add event',
				'add_new_item'  => 'Add new event',
				'edit'          => 'Edit',
				'edit_item'     => 'Edit',
				'new_item'      => 'New event',
			),
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'rest_base'           => '',
			'show_in_menu'        => true,
			'exclude_from_search' => false,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			'has_archive'         => 'farm',
			'query_var'           => true,
			'supports'            => array( 'title', 'editor'),

		) );
	}



	/*  add datepicker */

	public function add_datepicker_meta_box() {
		add_meta_box( 'event_datepicker', 'Event', array('MySuperCalendar_Admin','event_datepicker'), $this->plugin_post_type );
	}

	public function event_datepicker(){

		$post_id = get_the_ID();
		wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );
		$event_date_field = get_post_meta( $post_id, 'event_date_field', '' );
		$event_time_field = get_post_meta( $post_id, 'event_time_field', '' );
		$event_adress_field = get_post_meta( $post_id, 'event_adress_field', '' );

		ob_start();
		require_once(  'templates/post_type_fields.php');
		echo ob_get_clean();


	}




	public function save_calendar_post( $post_id ){

		// проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
		if ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) ) )
			return $post_id;

		// проверяем, если это автосохранение ничего не делаем с данными нашей формы.
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return $post_id;

		// проверяем разрешено ли пользователю указывать эти данные
		if ( 'page' == $_POST['post_type'] && ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		} elseif( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Убедимся что поле установлено.
		if ( ! isset( $_POST['event_date_field'] ) )
			return;

		// Все ОК. Теперь, нужно найти и сохранить данные
		// Очищаем значение поля input.
		$event_date_field = sanitize_text_field( $_POST['event_date_field'] );
		$event_time_field = sanitize_text_field( $_POST['event_time_field'] );
		$event_adress_field = sanitize_text_field( $_POST['event_adress_field'] );



		// Обновляем данные в базе данных.
		update_post_meta( $post_id, 'event_date_field', $event_date_field );
		update_post_meta( $post_id, 'event_time_field', $event_time_field );
		update_post_meta( $post_id, 'event_adress_field', $event_adress_field );

	}


	public function register_plugin_menu_page(){
		add_submenu_page( 'edit.php?post_type=calendar', 'Options', 'Options', 'manage_options',   'option' , array( $this, 'plugin_option_page' ) );
	}

	public function plugin_option_page() {

		$post_id = get_the_ID();
		wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );
		$event_calendar_title = get_post_meta( $post_id, 'event_calendar_title', '' );

		ob_start();
		require_once(  'templates/option_page.php');
		echo ob_get_clean();


	}

	public function get_post_type(){
		return $this->plugin_post_type;
	}



}
