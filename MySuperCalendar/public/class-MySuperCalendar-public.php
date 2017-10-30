<?php

/**
 * The public-facing functionality of the plugin.
 *
 */


class MySuperCalendar_Public {


	private $plugin_name;
	protected 	$plugin_post_type;



	public function __construct( $plugin_name) {

		$this->plugin_name = $plugin_name;
		$this->plugin_post_type = 'calendar';
		add_shortcode('MySuperCalendar', array('MySuperCalendar_Public','MySuperCalendar_shortcode'  )) ;

	}


	public function enqueue_styles() {


		wp_enqueue_style( $this->plugin_name . '-style-jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(),'', 'all' );
		wp_enqueue_style( $this->plugin_name . '-style-eventCalendar', plugin_dir_url( __FILE__ ) . 'css/eventCalendar.css', array(),'', 'all' );
		wp_enqueue_style( $this->plugin_name . '-style-eventCalendar_theme_responsive', plugin_dir_url( __FILE__ ) . 'css/eventCalendar_theme_responsive.css', array(),'', 'all' );
		wp_enqueue_style( $this->plugin_name . '-style-public', plugin_dir_url( __FILE__ ) . 'css/MySuperCalendar-public.css', array(),'', 'all' );


	}



	public function enqueue_scripts() {

		wp_enqueue_script($this->plugin_name . '-jquery-ui-js', plugin_dir_url(__FILE__) . 'js/jquery-ui.js', array('jquery'), '', false);
		wp_enqueue_script($this->plugin_name . '-moment-js', plugin_dir_url(__FILE__) . 'js/moment.js', array('jquery'), '', false);
		wp_enqueue_script($this->plugin_name . '-eventCalendar-js', plugin_dir_url(__FILE__) . 'js/jquery.eventCalendar.js', array('jquery'), '', false);
		wp_enqueue_script($this->plugin_name . '-scripts-public', plugin_dir_url(__FILE__) . 'js/MySuperCalendar-public.js', array('jquery'), '', false);





	}


	public function calendarAjax_data(){

		wp_localize_script( $this->plugin_name . '-scripts-public', 'calendarAjax',
			array(
				'url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('calendarAjax-nonce')
			)
		);
	}



	public function calendarAjax() {

		check_ajax_referer('calendarAjax-nonce', 'nonce_code');


		if ( $_POST['date']) {

			$args = array(
				'posts_per_page' => -1,
				'post_type' => $this->plugin_post_type,
				'post_status' => 'publish',
				'meta_key' => 'event_date_field',
				'meta_value' => $_POST['date'],

			);

		} else {
			$args = array(
				'posts_per_page' => -1,
				'post_type' => $this->plugin_post_type,
				'post_status' => 'publish',
			);
		}

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			$return = array();
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_id = get_the_ID();


				if( $_POST['date'] ) {
					$event_date_field = get_post_meta( $post_id, 'event_date_field', '' );
					$event_time_field = get_post_meta( $post_id, 'event_time_field', '' );
					$event_adress_field = get_post_meta( $post_id, 'event_adress_field', '' );

					if( $event_time_field[0] ){
						$event_item['date'] = $event_date_field[0] . ' ' . $event_time_field[0];
					}else{
						$event_item['date'] = $event_date_field[0] . ' 00:00';
					}

					$event_item['title'] = get_the_title();
					$event_item['description'] = get_the_excerpt();
					$event_item['adress'] = $event_adress_field[0];
					$event_item['url'] = get_the_permalink();
					$return[] = $event_item;


				}else{
					$event_date_field = get_post_meta( $post_id, 'event_date_field', '' );
					$event_time_field = get_post_meta( $post_id, 'event_time_field', '' );

					if( $event_time_field[0] ){
						$event_item['date'] = $event_date_field[0] . ' ' . $event_time_field[0];
					}else{
						$event_item['date'] = $event_date_field[0] . ' 00:00';
					}

					$event_item['title'] = get_the_title();
					$event_item['description'] = get_the_excerpt();
					$event_item['url'] = get_the_permalink();
					$return[] = $event_item;


				}

			}
		}
		wp_reset_postdata();

		if( $return ){
			$return_json = json_encode( $return );
			echo $return_json;
		}

		wp_die();

	}



	public function MySuperCalendar_shortcode() {

		$MySuperCalendar = new MySuperCalendar();
		$plugin_url = plugins_url( $MySuperCalendar->get_plugin_name() );

		ob_start();
		require_once(  'templates/shortcode.php');
		return ob_get_clean();

	}



}
