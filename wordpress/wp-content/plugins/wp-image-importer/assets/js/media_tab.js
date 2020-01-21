jQuery( document ).ready( function( $ ) {
	/**************************************************************
	 * Add Media Tab search, pagination, popup and size choosing.
	 **************************************************************/
	var postid 	= setting_obj.postid,
	lang 		= setting_obj.lang,
	page_size 	= setting_obj.page_size,
	page_size_f = setting_obj.page_size_f,
	sort 		= setting_obj.sort,
	prevQuery 	= [],
	hits, 
	query, 
	img_type, 
	orientation;
	license 	= setting_obj.license;
	var cache, 
	cache_x 	= [], data, data_x,
	foundImages = {}, current_page = 0;

	/**
	 * Settings tabs management.
	 */
	$( '.ced_iimp_tab' ).on( 'click', function() {
		var $this = $( this ),
		tabe_name = $this.data( 'name' );
		$( document ).find( '.ced_iimp_tab-content' ).addClass( 'ced_iimp_hide' );
		$( document ).find( '.ced_iimp_tab-content-' + tabe_name ).removeClass( 'ced_iimp_hide' );
		$( document ).find( '.ced_iimp_tab_active.ced_iimp_tab' ).removeClass( 'ced_iimp_tab_active' );
		$( document ).find( '.ced_iimp_tab-' + tabe_name ).addClass( 'ced_iimp_tab_active' );
	});

	$( '#ced_iimp_img_search_form' ).submit( function( e ) {
		e.preventDefault();
		query = $( '#ced_iimp_query' ).val();
		if( $( '#ced_iimp_fetch_photo' ).is( ':checked' ) && ! $( '#fetch_cliparts' ).is( ':checked' ) ) { 
			img_type = 'image';
		} else if( !$('#ced_iimp_fetch_photo').is(':checked') && $('#fetch_cliparts').is(':checked')) { 
			img_type = 'clipart';
		} else {
			img_type = 'all';
		}

		if( $( '#ced_iimp_fetch_horizental' ).is( ':checked' ) && ! $( '#fetch_vertical' ).is( ':checked' ) ) { 
			orientation = 'horizontal';
		} else if( !$( '#ced_iimp_fetch_horizental' ).is( ':checked' ) && $( '#fetch_vertical' ).is( ':checked' ) ) { 
			orientation = 'vertical';
		}
		
		cache = {};
		cache_x = {};
		current_page = 0;
		get_imgS( query, 1 );
		get_imgF( query, 1 );
	});

	function get_imgF( query, page_no ) {
		if ( current_page == page_no ) {
			renderFlickrImages( foundImages, query );
		} else {
			$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).removeClass( 'ced_iimp_hide' );
			var url = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=" + setting_obj.fappid + "&tags=" + query + "&per_page=" + page_size_f +"&format=json&page="+ page_no +"&license="+ license + "&sort=" + sort + "&extras=license,owner_name,url_sq%2C+url_t%2C+url_s%2C+url_m%2C+url_l%2C+url_o%2C+url_q";
			var xhr = new XMLHttpRequest();
			xhr.open( "GET", url );
			xhr.onreadystatechange = function() {
				$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).addClass( 'ced_iimp_hide' );
				if( xhr.readyState == 4 && xhr.status == 200 ) {
					response = xhr.responseText;
					var n 	= response.lastIndexOf( ")" );
					
					response = response.slice( 14, n );
					response = JSON.parse( response );
					if( response.photos.total > 0 ) {
						foundImages = {
							flickr : {
								total 		: response.photos.total,
								page 		: response.photos.page,
								totalPages 	: response.photos.pages,
								perPage 	: response.photos.perpage,
								images 		: response.photos.photo
							}	
						}
						current_page = page_no;
						prevQuery.push( query );
						renderFlickrImages( foundImages, query );
					} else {
						$('#ced_iimp_wpiimp_resultF').html( setting_obj.no_hit );
						return false;
					}
				}
			};
			xhr.send();
	    }
	    return false;
	}
	
	var renderFlickrImages = function( foundImages, query ) {
		var imgHtml = '',
		pageNum = parseInt( foundImages.flickr.page );
		imgHtml += '<div class="ced_iimp_image-list-wrapper">';
			imgHtml += '<div class="ced_iimp_image-list-header">';
				if ( query != '' && typeof query != 'undefined' ) {
					imgHtml += '<h4>'+ setting_obj.flickr_search + query +'.</h4>';
				} else {
					imgHtml += '<h4>'+ setting_obj.flickr_default +'</h4>';
				}
				imgHtml += '<span>'+ setting_obj.total_record + foundImages.flickr.total +'.</span>';
			imgHtml += '</div>';
			for( var key in foundImages.flickr.images ) {
				imgHtml += '<div class="ced_iimp_image-list-content-wrap">';
					imgHtml += '<div class="thumb ced_iimp_image-list-content">';
						imgHtml += '<a class="ced_iimp_image_anchor" rel="gallery-plants" data-idx="'+ key +'" data-src="'+ foundImages.flickr.images[ key ].url_m +'">';
							imgHtml += '<img class="attachment ced_iimp_image" src="'+ foundImages.flickr.images[ key ].url_s +'">';
						imgHtml += '</a>';
						if ( typeof foundImages.flickr.images[ key ].width_s != 'undefined' ) {
							imgHtml += '<input type="hidden" class="ced_iimp_small_img" data-dims="'+ foundImages.flickr.images[ key ].width_s +'x'+ foundImages.flickr.images[ key ].height_s +'" data-src="'+ foundImages.flickr.images[ key ].url_s +'" data-user="'+ foundImages.flickr.images[ key ].ownername +'">';
						}

						if ( typeof foundImages.flickr.images[ key ].width_m != 'undefined' ) {
							imgHtml += '<input type="hidden" class="ced_iimp_medium_img" data-dims="'+ foundImages.flickr.images[ key ].width_m +'x'+ foundImages.flickr.images[ key ].height_m +'" data-src="'+ foundImages.flickr.images[ key ].url_m +'" data-user="'+ foundImages.flickr.images[ key ].ownername +'">';
						}

						if ( typeof foundImages.flickr.images[ key ].width_l == 'undefined' ) {
							imgHtml += '<input type="hidden" class="ced_iimp_large_img" data-dims="'+ foundImages.flickr.images[ key ].width_l +'x'+ foundImages.flickr.images[ key ].height_l +'" data-src="'+ foundImages.flickr.images[ key ].url_l +'" data-user="'+ foundImages.flickr.images[ key ].ownername +'">';
						}
						imgHtml += '<input type="hidden" class="ced_iimp_img_from" data-value="flickr">';
					imgHtml += '</div>';
				imgHtml += '</div>';
			}
		imgHtml += '</div>';
		imgHtml += '<div style="clear: both;"></div>';
		imgHtml += '<div id="ced_iimp_paginator">';
			if( pageNum == 1 )  {
				imgHtml += '<span class="button disabled">'+ setting_obj.prev +'</span>';
			} else {
				imgHtml += '<a data-pag_num="'+ ( pageNum - 1 ) +'" data-query="'+ query +'" class="button ced_iimp_paginator_link">'+ setting_obj.prev +'</a>'; 
			}
			
			//@todo check total no of pages
			if( pageNum == foundImages.flickr.images ) {
				imgHtml += '<span class="button disabled">'+ setting_obj.next +'</span>';
			} else {
				imgHtml += '<a data-page_num="'+ ( pageNum + 1 ) +'" data-query="'+ query +'" class="button ced_iimp_paginator_link">'+ setting_obj.next +'</a>';
			}
		imgHtml += '</div>';
		imgHtml += '<div style="clear: both;"></div>';
		$( '#ced_iimp_wpiimp_resultF' ).html( imgHtml );
		$( 'html,body' ).animate({ 
			scrollTop: $( '.ced_iimp_img_search_wrapper' ).offset().top + $( '.ced_iimp_img_search_wrapper' ).height() + 50 
		}, 'slow');
	};

	function get_imgS( query, page_no ) {
		if ( page_no in cache )
			renderPixabayImages( foundImages, query );
	    else {
			var xhttp,
			url = "https://pixabay.com/api/?key="+ setting_obj.pappid +"&response_group=high_resolution&image_type="+ img_type +"&orientation="+ orientation +"&q="+ query +"&lang="+ lang +"&per_page="+ page_size +"&page="+ page_no;
			xhttp = new XMLHttpRequest();
			xhttp.open( "GET", url );
			
			xhttp.onreadystatechange = function() {
				if( xhttp.readyState == 4 && xhttp.status == 200 ) {
					response = JSON.parse(xhttp.responseText);
					if( response.totalHits > 0 ) {
						cache[page_no] = response;
						foundImages = {
							pixabay : {
								total 		: response.total,
								page 		: page_no,
								totalHits 	: response.totalHits,
								totalPages 	: Math.ceil( response.totalHits / page_size ),
								perPage 	: response.page_size,
								images 		: response.hits
							}	
						}
						renderPixabayImages( foundImages, query );
					} else {
						$( '#ced_iimp_wpiimp_result' ).html( 'No hit found' );
						return false;
					}
				}
			};
			xhttp.send();
	    }
		return false;
	}
	var renderPixabayImages = function( foundImages, query ) {
		var imgHtml = '',
		pageNum = parseInt( foundImages.pixabay.page );
		imgHtml += '<div class="ced_iimp_image-list-wrapper">';
			imgHtml += '<div class="ced_iimp_image-list-header">';
				if ( query != '' && typeof query != 'undefined' ) {
					imgHtml += '<h4>'+ setting_obj.pixabay_search + query +'.</h4>';
				} else {
					imgHtml += '<h4>'+ setting_obj.pixabay_default +'</h4>';
				}
				imgHtml += '<span>'+ setting_obj.total_record + foundImages.pixabay.total +'.</span>';
			imgHtml += '</div>';
			for( var key in foundImages.pixabay.images ) {
				imgHtml += '<div class="ced_iimp_image-list-content-wrap">';
					imgHtml += '<div class="thumb ced_iimp_image-list-content">';
						imgHtml += '<a class="ced_iimp_image_anchor" rel="gallery-plants" data-idx="'+ key +'" data-src="'+ foundImages.pixabay.images[ key ].webformatURL +'">';
							imgHtml += '<img src="'+ foundImages.pixabay.images[ key ].previewURL +'">';
						imgHtml += '</a>';
						if ( typeof foundImages.pixabay.images[ key ].previewWidth != 'undefined' ) {
							imgHtml += '<input type="hidden" class="ced_iimp_small_img" data-dims="'+ foundImages.pixabay.images[ key ].previewWidth +'x'+ foundImages.pixabay.images[ key ].previewHeight +'" data-src="'+ foundImages.pixabay.images[ key ].previewURL +'" data-user="'+ foundImages.pixabay.images[ key ].user +'">';
						}

						if ( typeof foundImages.pixabay.images[ key ].webformatWidth != 'undefined' ) {
							imgHtml += '<input type="hidden" class="ced_iimp_medium_img" data-dims="'+ foundImages.pixabay.images[ key ].webformatWidth +'x'+ foundImages.pixabay.images[ key ].webformatHeight +'" data-src="'+ foundImages.pixabay.images[ key ].webformatURL +'" data-user="'+ foundImages.pixabay.images[ key ].user +'">';
						}

						if ( typeof foundImages.pixabay.images[ key ].imageWidth != 'undefined' ) {
							imgHtml += '<input type="hidden" class="ced_iimp_large_img" data-dims="'+ foundImages.pixabay.images[ key ].imageWidth +'x'+ foundImages.pixabay.images[ key ].imageHeight +'" data-src="'+ foundImages.pixabay.images[ key ].imageURL +'" data-user="'+ foundImages.pixabay.images[ key ].user +'">';
						}
						imgHtml += '<input type="hidden" class="ced_iimp_img_from" data-value="pixabay">';
					imgHtml += '</div>';
				imgHtml += '</div>';
			}
		imgHtml += '</div>';
		imgHtml += '<div style="clear: both;"></div>';
		imgHtml += '<div id="ced_iimp_paginator_pixa">';
			if( pageNum == 1 )  {
				imgHtml += '<span class="button disabled">'+ setting_obj.prev +'</span>';
			} else {
				imgHtml += '<a data-pag_num="'+ ( pageNum - 1 ) +'" data-query="'+ query +'" class="button ced_iimp_paginator_pixa_link">'+ setting_obj.prev +'</a>'; 
			}
			
			//@todo check total no of pages
			if( pageNum == foundImages.pixabay.images ) {
				imgHtml += '<span class="button disabled">'+ setting_obj.next +'</span>';
			} else {
				imgHtml += '<a data-page_num="'+ ( pageNum + 1 ) +'" data-query="'+ query +'" class="button ced_iimp_paginator_pixa_link">'+ setting_obj.next +'</a>';
			}
		imgHtml += '</div>';
		imgHtml += '<div style="clear: both;"></div>';
		$( '#ced_iimp_wpiimp_result' ).html( imgHtml );
		$( 'html,body' ).animate({ 
			scrollTop: $( '.ced_iimp_img_search_wrapper' ).offset().top + $( '.ced_iimp_img_search_wrapper' ).height() + 50 
		}, 'slow');
	};

	$( document ).on( 'click', '.ced_iimp_paginator_link', function() {
		var query = $( this ).attr( 'data-query' ),
		pageNum = parseInt( $( this ).attr( 'data-page_num' ) );
		get_imgF( query, pageNum );
	});

	$( document ).on( 'click', '.ced_iimp_paginator_pixa_link', function() {
		var query = $( this ).attr( 'data-query' ),
		pageNum = parseInt( $( this ).attr( 'data-page_num' ) );
		get_imgS( query, pageNum );
	});

	$( document ).on( 'click', '.ced_iimp_image_anchor', function() {
		// If the old thickbox remove function exists, call it
   		if ( window.tb_remove ) {
   			try { 
   				window.tb_remove(); 
   			} catch( e ) {}
   		}

		var $this 		= $( this ),
		/**
		 * Fetching dimensions
		 */
		small_img_dims 	= $this.parent().find( '.ced_iimp_small_img' ).data( 'dims' ),
		medium_img_dims = $this.parent().find( '.ced_iimp_medium_img' ).data( 'dims' ),
		large_img_dims 	= $this.parent().find( '.ced_iimp_large_img' ).data( 'dims' ),

		/**
		 * Fetching url of images
		 */
		small_img_url 	= $this.parent().find( '.ced_iimp_small_img' ).data( 'src' ),
		medium_img_url 	= $this.parent().find( '.ced_iimp_medium_img' ).data( 'src' ),
		large_img_url 	= $this.parent().find( '.ced_iimp_large_img' ).data( 'src' ),

		/**
		 * Fetching owner of images.
		 */
		small_img_user 	= $this.parent().find( '.ced_iimp_small_img' ).data( 'user' ),
		medium_img_user = $this.parent().find( '.ced_iimp_medium_img' ).data( 'user' ),
		large_img_user 	= $this.parent().find( '.ced_iimp_large_img' ).data( 'user' ),

		img_from 		= $this.parent().find( '.ced_iimp_img_from' ).data( 'value' ),
		caption 		= '',
		
		src 			= $( this ).attr( 'data-src' );
		$( document ).find( '.ced_iimp_image-tag' ).attr( 'src', src );
		$( document ).find( '.ced_iimp_image-tag' ).load();
		if ( small_img_dims && small_img_url ) {
			$( document ).find( '.ced_iimp_insert_s .ced_iimp_dims' ).html( small_img_dims );
			$( document ).find( '.ced_iimp_insert_s' ).attr( 'data-user', small_img_user );
			$( document ).find( '.ced_iimp_insert_s' ).attr( 'data-src', small_img_url ).removeClass( 'ced_iimp_hide' );
			$( document ).find( '.ced_iimp_insert_s' ).attr( 'data-img_from', img_from );
		}

		if ( medium_img_dims && medium_img_url ) {
			$( document ).find( '.ced_iimp_insert_m .ced_iimp_dims' ).html( medium_img_dims );
			$( document ).find( '.ced_iimp_insert_m' ).attr( 'data-user', medium_img_user );
			$( document ).find( '.ced_iimp_insert_m' ).attr( 'data-src', medium_img_url ).removeClass( 'ced_iimp_hide' );
			$( document ).find( '.ced_iimp_insert_m' ).attr( 'data-img_from', img_from );
			caption = 'Currently showing '+ medium_img_dims;
		}

		if ( large_img_dims && large_img_url ) {
			$( document ).find( '.ced_iimp_insert_l .ced_iimp_dims' ).html( large_img_dims );
			$( document ).find( '.ced_iimp_insert_l' ).attr( 'data-user', large_img_user );
			$( document ).find( '.ced_iimp_insert_l' ).attr( 'data-src', large_img_url ).removeClass( 'ced_iimp_hide' );
			$( document ).find( '.ced_iimp_insert_l' ).attr( 'data-img_from', img_from );
		}

		tb_show( caption, setting_obj.thckbox_query_arg );
		$( document ).find( '#TB_window' ).css( "margin-top", '-240px' );
		$( document ).find( '.ced_iimp_image-content-inner' ).parent( '#TB_ajaxContent' ).css({
			height: 'auto'
		});
		return false;
	});

	$( document ).on( 'click', ( '.ced_iimp_insert_s, .ced_iimp_insert_m, .ced_iimp_insert_l' ), function( e ) {
		e.preventDefault();
		var $this 	= $( this );
		user 		= $this.attr( 'data-user' ),
		img_url 	= $this.attr( "data-src" ),
		img_from 	= $this.attr( "data-img_from" );
		if ( img_url == '' || typeof img_url == 'undefined' ) {
			alert( setting_obj.img_unknown_error );
			return false;
		}

		if ( postid == '' || typeof postid == 'undefined' ) {
			postid = $( document ).find( '#post_ID' ).val();
		}

		$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).removeClass( 'ced_iimp_hide' );
		$.ajax({
			url 	: setting_obj.ajax_url, 
			data 	: { 
				action 		: 'ced_iimp_save_image_to_post',
				insert_img 	: true, 
				img_url 	: img_url, 
				img_user 	: user, 
				query 		: query, 
				img_from 	: img_from, 
				wpnonce 	: setting_obj.wpiim_img_nonce 
			},
			type 	: 'post',
			success: function( data ) {
				$( ".ced_iimp_loader_wrap,.ced_iimp_spinner" ).addClass( 'ced_iimp_hide' );
				if( parseInt( data ) == data ) {
					window.location = 'media-upload.php?type=image&tab=library&post_id='+ postid +'&attachment_id='+ data;
				} else {
					console.log( data );
				}
			}
		});
	});
	/**************************************************************
	 * Add Media Tab search, pagination, popup and size choosing.
	 **************************************************************/
});
