jQuery( document ).ready( function( $ ) {
	var ajaxUrl 	= globals.ajaxUrl,
	cachedAlbum 	= {},
	cachedPhotoSets = {};
	
	/**
	 * Remove notice if clicked on dismiss button.
	 */
	$( document ).on( 'click', '.notice-dismiss', function() {
		$( this ).parents( '.is-dismissible' ).remove();
	})

	$( '#ced_iimp_save_pixabay' ).on( 'click', function() {
		var app_id 	= $( '#ced_iimp_pixabay_appid' ).val(),
		image_type 	= $( '#ced_iimp_pixabay_image_type option:selected' ).val(),
		language 	= $( '#ced_iimp_pixabay_language option:selected' ).val(),
		per_page 	= $( '#ced_iimp_pixabay_per_page' ).val(),
		orientation = $( '#ced_iimp_pixabay_orientation' ).val(),
		attriution 	= $( '#pixabay_attribution_s' ).is( ':checked' ) ? '1' : '0';

		if ( $.trim( app_id ) === '' ) {
			alert( 'You need to enter your Flickr App ID' );
			return;
		}
		$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).removeClass( 'ced_iimp_hide' );

		$.ajax({
			url 	: ajaxUrl,
			data 	: {
				action 		: 'save_pixabay_settings',
				app_id 		: app_id,
				image_type 	: image_type,
				language 	: language,
				per_page 	: per_page,
				orientation : orientation,
				attriution 	: attriution,
				wpiim_nonce : globals.wpiimp_nonce
			},
			type 	: 'post',
			success	: function( response ) {
				$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).addClass( 'ced_iimp_hide' );
			  	try {
					response = jQuery.parseJSON( response );
					var msg = '';
				  	if( response.status == 'ok' ) {
				  		msg += '<div class="updated notice is-dismissible">';
							msg += '<p>'+ response.message +'</p>';
							msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
						msg += '</div>';

				  	} else {
				  		msg += '<div class="error notice is-dismissible">';
							msg += '<p>'+ response.message +'</p>';
							msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
						msg += '</div>';
				  	}
				  	$( '.ced_iimp_messages' ).html( msg );
				  	window.scrollTo( 0, 0 );
				} catch( e ) {
					console.log( response );
				}
			}
		});
	});

	$( '#ced_iimp_save_flickr' ).on( 'click', function() {
		var app_id 	= $( '#ced_iimp_flickr_appid' ).val(),
		userid 		= $( '#ced_iimp_flickr_userid' ).val(),
		license 	= $( '#ced_iimp_flickr_license option:selected' ).val(),
		order_by 	= $( '#ced_iimp_flickr_sort option:selected' ).val(),
		per_page 	= $( '#ced_iimp_flickr_per_page' ).val(),
		attriution 	= $( '#ced_iimp_flickr_attribution_s' ).is( ':checked' ) ? '1' : '0';

		if ( $.trim( app_id ) === '' ) {
			alert( 'You need to enter your Flickr App ID' );
			return;
		}
		$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).removeClass( 'ced_iimp_hide' );
		$.ajax({
			url 	: ajaxUrl,
			data 	: {
				action 		: 'save_flickr_settings',
				app_id 		: app_id,
				userid 		: userid,
				license 	: license,
				order_by 	: order_by,
				per_page 	: per_page,
				attriution 	: attriution,
				wpiim_nonce : globals.wpiimp_nonce
			},
			type 	: 'post',
			success	: function( response ) {
				$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).addClass( 'ced_iimp_hide' );
				try {
					response = jQuery.parseJSON( response );
					var msg = '';
				  	if( response.status == 'ok' ) {
				  		msg += '<div class="updated notice is-dismissible">';
							msg += '<p>'+ response.message +'</p>';
							msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
						msg += '</div>';

				  	} else {
				  		msg += '<div class="error notice is-dismissible">';
							msg += '<p>'+ response.message +'</p>';
							msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
						msg += '</div>';
				  	}
				  	$( '.ced_iimp_messages' ).html( msg );
				  	window.scrollTo( 0, 0 );
				} catch( e ) {
					console.log( response );
				}
			}
		});
	});

	/**********************************************
	 * Facebook album section starts here.
	 ***********************************************/
	$( '#ced_iimp_fb_credential_saving' ).on( 'click', function() {
		var appId = $( '#ced_iimp_fb_app_id' ).val(),
		secretKey = $( '#ced_iimp_fb_secret_key' ).val();

		if ( appId == '' || appId === '' || appId == null || appId === null ) {
			alert( 'You need to enter your Facebook App ID!!' );
			return false;
		}
		
		if ( $.trim( appId ) === '' ) {
			alert( 'You need to enter your Flickr App ID!!' );
			return false;
		}

		if ( secretKey == '' || secretKey === '' || secretKey == null || secretKey === null ) {
			alert( 'You need to enter your Facebook secret key!!' );
			return false;
		}

		if ( $.trim( secretKey ) === '' ) {
			alert( 'You need to enter your Facebook secret key!!' );
			return false;
		}
		$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).removeClass( 'ced_iimp_hide' );
		$.ajax({
			url 	: ajaxUrl,
			data 	: {
				action 		: 'save_fb_settings',
				appId 		: appId,
				secretKey 	: secretKey,
				wpiim_nonce : globals.wpiimp_nonce
			},
			type 	: 'post',
			success	: function( response ) {
				$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).addClass( 'ced_iimp_hide' );
				try {
					var msg = '';
				  	if( response.success ) {
				  		window.open( response.data.loginUrl, '_blank' );
				  	} else {
				  		msg += '<div class="error notice is-dismissible">';
							msg += '<p>'+ response.data.message +'</p>';
							msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
						msg += '</div>';
				  	}
				  	$( '.ced_iimp_messages' ).html( msg );
				  	window.scrollTo( 0, 0 );
				} catch( e ) {
					console.log( response );
				}
			}
		});
	});

	$( '.ced_iimp_fb-album-node' ).on( 'click', function() {
		var $this 	= $( this ),
		albumId 	= $this.data( 'id' ),
		albumName 	= $this.data( 'name' );

		$( '.ced_iimp_fb-albums-list-wrap' ).addClass( 'ced_iimp_hide' );

		/**
		 * If same page is being clicked, then cached page will be rendered.
		 */
		if ( cachedAlbum.hasOwnProperty( albumId ) ) {
			renderFbAlbumImgs( cachedAlbum[ albumId ] );
			return;
		}
		$( ".ced_iimp_loader_wrap, .ced_iimp_bar_cloning_loader_wrapper" ).removeClass( 'ced_iimp_hide' );
		$.ajax({
			url 	: ajaxUrl,
			data 	: {
				action 		: 'wpiimp_get_fb_album_pics',
				albumId 	: albumId,
				wpiim_nonce : globals.wpiimp_nonce
			},
			type 	: 'post',
			success	: function( response ) {
				$( ".ced_iimp_loader_wrap, .ced_iimp_bar_cloning_loader_wrapper" ).addClass( 'ced_iimp_hide' );
				try {
					if ( response.success ) {
						var albumPics = response.data;
						cachedAlbum[ albumId ] = albumPics; 
						renderFbAlbumImgs( albumPics, albumName );
					} else {
						var msg = '';
				  		msg += '<div class="error notice is-dismissible">';
							msg += '<p>'+ response.data +'</p>';
							msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
						msg += '</div>';
				  		$( '.ced_iimp_messages' ).html( msg );
				  		$( '.ced_iimp_fb-albums-list-wrap' ).removeClass( 'ced_iimp_hide' );
				  	}
					console.log( response );
				} catch( e ) {
					console.log( response );
				}
			}
		});
	});

	function renderFbAlbumImgs( albumPics, albumName ) {
		if ( albumPics.length > 0 ) {
			var picHtml = '<div class="ced_iimp_back_btn_wrap"><a id="ced_iimp_back_to_albums">Back</a></div>';
			picHtml += '<ul id="ced_iimp_fb-album-pics" class="ced_iimp_fb-album-pics ced_iimp_fb-album-edges ced_iimp_album-pics">';
				for( var i in albumPics ) {
					if ( albumPics[i].images.length <= 0 ) {
						continue;
					}

					picHtml += '<li class="ced_iimp_fb-album-edge ced_iimp_fb-album-pic" data-id="'+ albumPics[i].id +'">';
						picHtml += '<a class="ced_iimp_album_img_anchor" data-album_name="'+ albumName +'" data-src="'+ albumPics[i].images[0].source +'" data-width="'+ albumPics[i].images[0].width + '" data-height="' + albumPics[i].images[0].height +'">';
							picHtml += '<img src="'+ albumPics[i].images[0].source +'">';
						picHtml += '</a>';
					picHtml += '</li>';
				}
			picHtml += '</ul>';
			$( '.ced_iimp_fb-albums-content-wrap' ).html( picHtml ).removeClass( 'ced_iimp_hide' );
			var albumImgWrapper = $( document ).find( '.ced_iimp_fb-album-pics.ced_iimp_fb-album-edges' );
			if ( albumImgWrapper.height()  > 400 ) {
			    albumImgWrapper.addClass( 'ced_iimp_scrollable' );
			}
		}
	}

	$( document ).on( 'click', '#ced_iimp_back_to_albums', function() {
		$( '.ced_iimp_albums-content-wrap' ).addClass( 'ced_iimp_hide' );
		$( '.ced_iimp_albums-list-wrap' ).removeClass( 'ced_iimp_hide' );
	});

	$( document ).on( 'keyup', '#ced_iimp_album-search-input', function() {
		var $this 	= $( this ),
		queryStr 	= $this.val().toLowerCase();

		if ( queryStr == '' || queryStr == null ) {
			$( document ).find( 'li.ced_iimp_album-node' ).show( 'slow' );	
			return;
		}
		
		$( 'li.ced_iimp_album-node' ).not( '[data-name*="'+ queryStr +'"]' ).hide( 'slow' );
		$( document ).find( 'li.ced_iimp_album-node[data-name*="'+ queryStr +'"]' ).show( 'slow' );
	});

	/**********************************************
	 * Flickr album section starts here.
	 ***********************************************/
	$( '.ced_iimp_flickr-album-node' ).on( 'click', function() {
		var $this 	= $( this ),
		albumId 	= $this.data( 'id' ),
		albumName 	= $this.data( 'name' );

		$( '.ced_iimp_flickr-albums-list-wrap' ).addClass( 'ced_iimp_hide' );

		/**
		 * If same page is being clicked, then cached page will be rendered.
		 */
		if ( cachedPhotoSets.hasOwnProperty( albumId ) ) {
			renderFlickrAlbumImgs( cachedPhotoSets[ albumId ] );
			return;
		}
		$( ".ced_iimp_loader_wrap, .ced_iimp_bar_cloning_loader_wrapper" ).removeClass( 'ced_iimp_hide' );

		$.ajax({
			url 	: ajaxUrl,
			data 	: {
				action 		: 'wpiimp_get_flickr_album_pics',
				albumId 	: albumId,
				wpiim_nonce : globals.wpiimp_nonce
			},
			type 	: 'post',
			success	: function( response ) {
				$( ".ced_iimp_loader_wrap, .ced_iimp_bar_cloning_loader_wrapper" ).addClass( 'ced_iimp_hide' );
				if ( response.success ) {
					var albumPics = response.data.photoset.photo;
					cachedPhotoSets[ albumId ] = albumPics; 
					renderFlickrAlbumImgs( albumPics, albumName );
				} else {
					var msg = '';
			  		msg += '<div class="error notice is-dismissible">';
						msg += '<p>'+ response.data +'</p>';
						msg += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
					msg += '</div>';
			  		$( '.ced_iimp_messages' ).html( msg );
			  		$( '.ced_iimp_fb-albums-list-wrap' ).removeClass( 'ced_iimp_hide' );
			  	}
			}
		});
	});

	function renderFlickrAlbumImgs( albumPics, albumName ) {
		if ( albumPics.length > 0 ) {
			var picHtml = '<div class="ced_iimp_back_btn_wrap"><a id="ced_iimp_back_to_albums">Back</a></div>';
			picHtml += '<ul id="ced_iimp_flickr-album-pics" class="ced_iimp_flickr-album-pics ced_iimp_flickr-album-edges ced_iimp_album-pics">';
				for( var i in albumPics ) {
					if ( albumPics[i] <= 0 ) {
						continue;
					}

					picHtml += '<li class="ced_iimp_fb-album-edge ced_iimp_fb-album-pic" data-id="'+ albumPics[i].id +'">';
						picHtml += '<a class="ced_iimp_album_img_anchor" data-album_name="'+ albumName +'" data-src="'+ albumPics[i].url_o +'" data-width="'+ albumPics[i].width_o + '" data-height="' + albumPics[i].height_o +'">';
							picHtml += '<img src="'+ albumPics[i].url_o +'">';
						picHtml += '</a>';
					picHtml += '</li>';
				}
			picHtml += '</ul>';
			$( '.ced_iimp_flickr-albums-content-wrap' ).html( picHtml ).removeClass( 'ced_iimp_hide' );
			var albumImgWrapper = $( document ).find( '.ced_iimp_flickr-album-pics.ced_iimp_flickr-album-edges' );
			if ( albumImgWrapper.height()  > 400 ) {
			    albumImgWrapper.addClass( 'ced_iimp_scrollable' );
			}
		}
	}

	/**************************************************************
	 * Common Working Process for facebook and flickr.
	 ***************************************************************/
	$( document ).on( 'click', '.ced_iimp_album_img_anchor', function() {
		var $this 		= $( this ), 
		src 			= $this.attr( 'data-src' ),
		album_name 		= $this.attr( 'data-album_name' ),
		picWidth 		= parseInt( $this.attr( 'data-width' ) ) + 30,
		picHeight 		= parseInt( $this.attr( 'data-height' ) ) + 77,
		fb_thckbox_args = globals.fb_thckbox_arg;

		/**
		 * Management of thickbox dimensions accroding to images.
		 */
		if ( picWidth >= 700 ) {
			picWidth = 700;
			$( document ).find( '.ced_iimp_thickbox-img' ).addClass( 'ced_iimp_full-width-img' );
		} else {
			if ( $( document ).find( '.ced_iimp_thickbox-img' ).hasClass( 'ced_iimp_full-width-img' ) ) {
				$( document ).find( '.ced_iimp_thickbox-img' ).removeClass( 'ced_iimp_full-width-img' );
			}
		}

		if ( picHeight >= 450 ) {
			picHeight = 450;
		}

		$( document ).find( '#ced_iimp_thickbox-content img.ced_iimp_thickbox-img' ).attr( 'src', src );
		$( document ).find( '#ced_iimp_thickbox-content .ced_iimp_insert_into_media' ).attr( 'data-src', src );

		/**
		 * Open thickbox to show the imported media images.
		 */
		tb_show( 'Images shown from '+ album_name +' album.', fb_thckbox_args );

		/**
		 * Setting positions, width and height for the thickbox popup.
		 */
		$( document ).find( '#ced_iimp_thickbox-content' ).parents( '#TB_window' ).css({
			width 		: picWidth + 'px',
			height 		: picHeight + 'px',
			left 		: "0",
			margin 		: "0 auto",
			position 	: "absolute",
			right 		: "0",
			top 		: "50%",
			transform 	: "translateY(-50%)"
		});
		$( document ).find( '#ced_iimp_thickbox-content' ).parent( '#TB_ajaxContent' ).css({
			width: picWidth + 'px',
			height: picHeight + 'px'
		});
		return false;
	});

	/**
	 * Inserts album images to media library.
	 */
	$( document ).on( 'click', '.ced_iimp_insert_into_media', function() {
		/**
		 * Fetch image src from button data-src sttribute.
		 */
		var src = $( this ).attr( 'data-src' );

		/**
		 * If src is undefined or empty then return back from here.
		 */
		if ( src == '' || typeof src == 'undefined'  ) {
			return false;
		}

		/**
		 * Remove thickbox if any is shown.
		 */
		tb_remove();

		/**
		 * Show loader before ajax request.
		 */
		$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).removeClass( 'ced_iimp_hide' );

		/**
		 * Ajax request for saving album images to wordpress media library.
		 */
		$.ajax({
			url 	: ajaxUrl,
			data 	: {
				action 		: 'wpiimp_save_img_to_media_library',
				src 		: src,
				wpiim_nonce : globals.wpiimp_nonce
			},
			type 	: 'post',
			success	: function( response ) {
				/**
				 * Hide loader after response.
				 */
				$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).addClass( 'ced_iimp_hide' );
				try {
					if ( response.success ) {
						var msg = '';
				  		msg += '<div class="updated notice is-dismissible">';
							msg += '<p>'+ response.data.message +'</p>';
							msg += '<button type="button" class="notice-dismiss">';
								msg += '<span class="screen-reader-text">Dismiss this notice.</span>';
							msg += '</button>';
						msg += '</div>';
				  		$( '.ced_iimp_messages' ).html( msg );
					} else {
						var msg = '';
				  		msg += '<div class="error notice is-dismissible">';
							msg += '<p>'+ response.data +'</p>';
							msg += '<button type="button" class="notice-dismiss">';
								msg += '<span class="screen-reader-text">Dismiss this notice.</span>';
							msg += '</button>';
						msg += '</div>';
				  		$( '.ced_iimp_messages' ).html( msg );
				  	}
				} catch( e ) {
					console.log( response );
				}
			}
		});
	});

	/**
	 * Show progress bar.
	 */
	var progressBar = function() {
		var xhr = new window.XMLHttpRequest();
		//Upload progress
		xhr.upload.addEventListener( "progress", function( evt ) {
			if ( evt.lengthComputable ) {
				var percentComplete = ( evt.loaded / evt.total ) * 100;
			}
		}, false );

		//Download progress
		xhr.addEventListener( "progress", function( evt ) {
			if ( evt.lengthComputable ) {
				var percentComplete = ( evt.loaded / evt.total ) * 50;
			}
		}, false );
		return xhr;
	}
});