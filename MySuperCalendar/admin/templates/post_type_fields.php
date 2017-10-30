<div>
	<h4>Date:</h4>
	<input type="text" class="event-calendar-datepicker" id="event_date_field" name="event_date_field" value="<?php echo ($event_date_field) ? $event_date_field['0'] : '';?>" readonly>

	<h4>Time:</h4>
	<input type="text" class="event-calendar-timepicker" id="event_time_field" name="event_time_field" value="<?php echo ($event_time_field) ? $event_time_field['0'] : '';?>" readonly>

	<h4>Adress</h4>
	<textarea id="event_adress_field" class="calendar-textarea" name="event_adress_field"  ><?php echo ($event_adress_field) ? $event_adress_field['0'] : '';?></textarea>
</div>
