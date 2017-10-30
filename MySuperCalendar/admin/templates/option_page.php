<div class="MySuperCalendar-option">
	<h1>Option page</h1>
	<hr>
	<h4>Calendar title:</h4>
	<form method="post" action="options.php">

		<?php wp_nonce_field('update-options'); ?>

		<input type="text"  id="event_calendar_title" name="event_calendar_title" value="<?php echo get_option('event_calendar_title'); ?>" >
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="event_calendar_title" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>

	</form>
	<hr>
	<div class="MySuperCalendar-option-info">
		<h4>Plugin shortcode:</h4>
		<p><code>[MySuperCalendar]</code></p>
		<p>or paste code in PHP template file</p>
		<p><code>echo do_shortcode('[MySuperCalendar]');</code></p>

	</div>
</div>





