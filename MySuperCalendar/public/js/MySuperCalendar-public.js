(function( $ ) {
	'use strict';

	$(function() {


		// Add modal
		var modalHtml = '<div class="dialog-events" title="Events"></div>';
		$('body').append(modalHtml);


		// Get ajax event by date
		$('body').on('click', '.eventCalendar-dayWithEvents',  function(){

			var date = $(this).attr('data-date');
			if( date ){
				var ajaxData = {
					action     : 'calendarAjax',
					date: date,
					nonce_code : calendarAjax.nonce
				};
				$.post(
					calendarAjax.url,
					ajaxData,
					function( response ) {

						var resultEventsHtml = '';
						var date = '';
						var title = '';
						var adress = '';
						var description = '';

						var obj = $.parseJSON( response );

						$.each( obj, function() {

							date = $(this)[0].date;
							title = $(this)[0].title;
							adress = $(this)[0].adress;
							description = $(this)[0].description;
							resultEventsHtml += '<div class="dialog-event-item">';

							if( title ){
								resultEventsHtml += '<div class="dialog-event-item-title">'+title+'</div>';
							}
							if( date ){
								resultEventsHtml += '<div class="dialog-event-item-date">'+date+'</div>';
							}
							if( adress ){
								resultEventsHtml += '<div class="dialog-event-item-adress">'+adress+'</div>';
							}
							if( description ){
								resultEventsHtml += '<div class="dialog-event-item-description">'+description+'</div>';
							}
							resultEventsHtml += '</div>';


						});

						$( ".dialog-events" ).dialog({
							modal: true,
							buttons: {
								Ok: function() {
									$( this ).dialog( "close" );
								}
							}
						});
						$( ".dialog-events" ).html( resultEventsHtml );






					});

			}
		})



		// Get ajax calendar events
		var ajaxData = {
			action     : 'calendarAjax',
			nonce_code : calendarAjax.nonce
		};
		$.post(
			calendarAjax.url,
			ajaxData,
		function( response ) {

			var obj = $.parseJSON( response );

			$('.MySuperCalendar-plugin-init').eventCalendar({
				jsonData:obj,
				jsonDateFormat: 'human'
			});
			$('.MySuperCalendar-plugin-loader').hide();


		});


	});


})( jQuery );
