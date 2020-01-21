/*=============================================
=            Suggestions for plugin.            =
=============================================*/

jQuery( document ).ready( function( $ ) {
	$( document ).on( 'submit', '#ced_iimp_suggestions-form', function( event ) {
		event.preventDefault();

		var title 	= $( '#ced_iimp_suggestions_title' ).val(),
		description = $( '#ced_iimp_suggestions_description' ).val();

		if ( description == null || description == '' || typeof description == 'undefined' ) {
			return false;
		}

		$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).removeClass( 'ced_iimp_hide' );
		$.ajax({
			url 	: suggestions.ajaxUrl,
			type 	: 'POST',
			data: {
				action 		: 'wpiimp_submit_suggestions',
				title 		: title,
				description : description,
				wpiim_nonce : suggestions.wpiimp_nonce
			},
		})
		.done( function( response ) {
			$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).addClass( 'ced_iimp_hide' );
			try {
				var msg = '';
				if ( response.success ) {
			  		msg += '<div class="updated notice is-dismissible">';
						msg += '<p>'+ response.data +'</p>';
						msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
					msg += '</div>';
				} else {
			  		msg += '<div class="error notice is-dismissible">';
						msg += '<p>'+ response.data +'</p>';
						msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
					msg += '</div>';
			  	}
			  	$( '.ced_iimp_messages' ).html( msg );
			} catch ( e ) {
				console.log( e );
			}
		});
	});
});

/*=====  End of Suggestions for plugin.  ======*/
