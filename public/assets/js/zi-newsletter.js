$(document).ready( function() {
	// ajax call for newsletter function
	$newsletter = $('.newsletter-form');

	$newsletter.on( 'submit', function(e) {
		subscribe($newsletter);
		return false;
	});

	$newsletter.find('.btn').click( function() {
		subscribe($newsletter);
	});

	function subscribe(newsletter) {
		$btn = newsletter.find('.btn');

		$.ajax({

			url: '/payment',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {
				phone: newsletter.find('input[name="phone"]').val().replace(/\D+/g,""),
				sum: newsletter.find('input[name="sum"]').val(),
			},
			beforeSend: function(){
				$btn.addClass('loading');
				$btn.attr('disabled', 'disabled');
			},
			success: function( data ){
			    window.location.href = data.redirect;
			},
			error: function( data ){
			    var error = new Array();
			    $.each(data.responseJSON, function(idx, messages) {
				$.each(messages, function(idx, err) {
				    error.push(err);
				});
			    });

				newsletter.find('.alert').html( error.join("<br/>") )
				.removeClass( 'alert-danger alert-success' )
				.addClass( 'alert active alert-danger' )
				.slideDown(300);

				$btn.removeClass('loading');
				$btn.removeAttr('disabled');

			//	console.log("AJAX ERROR: \n" + XMLHttpRequest.responseText + "\n" + textStatus);
			}
			
		});
	}

});