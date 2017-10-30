<?php

/**
 *  MySuperCalendar_Widget.
 */
class MySuperCalendarEvent_Widget extends WP_Widget {


	public function __construct() {

		parent::__construct(
			'MySuperCalendar_widget',
			'MySuperCalendar Widget',
			array( 'description' => 'Events calendar' )
		);
	}

	/**
	 * Front widget part
	 */
	public function widget( $args, $instance ) {


		$MySuperCalendar = new MySuperCalendar();
		$plugin_url = plugins_url( $MySuperCalendar->get_plugin_name() );
		$instance['title'];
		ob_start();
		require_once(  'templates/events_widget.php');
		echo  ob_get_clean();
	}

	/**
	 * Admin panel widget part
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Events';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

	<?php
	}

	/*
	 * Save widget form
	 */
	function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;

	}


}
