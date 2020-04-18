( function( $ ) {
	$( document ).ready( function (){ 
		////// ///////

		////// accordion
		if( $( ".wpopal-accordion" ).length > 0 ){
			var icons = {
		      header: "ui-icon-circle-arrow-e",
		      activeHeader: "ui-icon-circle-arrow-s"
		    };
		 	$( ".wpopal-accordion" ).accordion( {
		 		icons: icons,
		 		collapsible:true,
		 		 heightStyle: "content"
		 	} );
		}

		////// product count
 		$( '.quantity-box :button').click( function(){

 			var val = $('.quantity input', $(this).parent() ).val();
 			val = parseInt( val ); 
 			val = isNaN( val )  ? 0 : val; 

 			if( $(this).hasClass('minus') ){
 				val = val <= 0  ? 0 : val - 1; 
 			} 
 			if( $(this).hasClass('plus') ){
 				val = val + 1; 
 			}
 			$('.quantity input', $(this).parent() ).val( val );
 		} );

 		////// add slider for related product
 		if( $( '.related .products' ).length )  { 
 		 
 			var container = $( '.related .products' ); 
 			var col = parseInt( container.attr('class').replace("products","").replace("columns-","").replace(/\s+/,"") );
 			var limited = $( '.related .products .product' ).length;
 			if( limited > col ){
 				container.removeClass( 'columns-'+col );
 				var wrp = $('<div class="swiper-container"><div class="swiper-wrapper"></div></div>');
 				container.wrapInner( wrp );
 				var _swiper =  $('.swiper-container', container ); 
				$(_swiper).append( $('<div class="swiper-pagination"></div>') );
				$(_swiper).append( $('<div class="swiper-button-next"></div>') );
				$(_swiper).append( $('<div class="swiper-button-prev"></div>') );
 			 	
 			 	$( '.product', _swiper).addClass( 'swiper-slide' );

 				var option = {
 					navigation: {
				    	nextEl: '.swiper-button-next',
				        prevEl: '.swiper-button-prev'
				    }
 				};	

 				if( option ){
 					option = $.extend( {
 						slidesPerView: col,
    					spaceBetween: 30,
    					 slidesPerGroup: col,
    					slideClass:'swiper-slide',
 						pagination: {
					        el: '.swiper-pagination',
					        clickable: true,
					    },
					    breakpoints: {
                              1024: {
                               slidesPerView: 2,
                               spaceBetween: 30
                              },
                              768: {
                               slidesPerView: 1,
                               spaceBetween: 10
                              },
                              640: {
                               slidesPerView: 1,
                               spaceBetween: 10
                             },
                             320: {
                              slidesPerView: 1,
                              spaceBetween: 10
                             }
                        }
 					}, option );
 
 					var swiper = new Swiper( _swiper , option );
 				}  
 			}  
 		}


 		//// Product Add To Cart //// 
 		var cartstyle = '';
 		var $product;
        $('body').on('adding_to_cart', function (event, button) {
            $product = button.closest('.product');
        }).on('added_to_cart', function () {
            var src = $product.find('img').first().attr('src');
            var name = $product.find('.woocommerce-loop-product__title').text();
            var template =  '<div class="add-to-cart-minibox active">';
            template += '<div class="minibox-content row"><div class="wp-col-4"><img src="'+src+'"></div><div class="wp-col-8"><h4>'+name+'</h4></div></div>';
            template += '</div>';

            $( "body" ).append( template );
            setTimeout(function () {
                $('.add-to-cart-minibox').addClass('hide') ;
            }, 3000);
        });

        /// account form
        if( $("#customer_login").length > 0 ) {
			$("#customer_login > div.u-column2, #customer_login h2" ).hide();
			$("#customer_login > div" ).removeClass( 'col-1').removeClass('col-2');
	        $(".woocommerce-account-form .account-heading-tab a").click( function(){ 
	    		$("#customer_login > div" ).hide();
	    		$(".woocommerce-account-form .account-heading-tab a").removeClass('active');
	        	$("#customer_login" ).find( $(this).data('target') ).show();
	        	$(this).addClass('active');
	        	return false;
	        } );
	        $(".woocommerce-account-form .account-heading-tab a").first().click();
        }

        /// sticky in /// 
       

       	if( $('body').hasClass('single-product-sticky') ){
       		var summarys = $('.single-product .entry-summary');
	        summarys.each(function() {

	            var $column  = $(this);
	            var offsetTop   = 40;
	            $inner = $column.find('.summary-inner');

	            var $images = $column.parent().find('.woocommerce-product-gallery').wrapInner( "<div class=\"gallery-container\"></div>" );

	            $images.imagesLoaded(function() {
	                var diff = $inner.outerHeight() - $images.outerHeight();

	                if( diff < -200 ) { 
	                    $inner.stick_in_parent({
	                        offset_top: offsetTop
	                    });
	                } else if( diff > 200 ) {                
	                    $images.stick_in_parent({
	                        offset_top: offsetTop
	                    });
	                }
	                $( window ).resize(function() {
	                    if ( $( window ).width() <= 1024 ) {
	                        $inner.trigger('sticky_kit:detach');
	                        $images.trigger('sticky_kit:detach');
	                    }else if( $inner.outerHeight() < $images.outerHeight() ) {
	                        $inner.stick_in_parent({
	                            offset_top: offsetTop
	                        });
	                    }else{
	                        $images.stick_in_parent({
	                            offset_top: offsetTop
	                        });
	                    }
	                }); 
	            });

	        });
	    }////
	} );

} )( jQuery );


/* global tinymce, wpCookies, autosaveL10n, switchEditors */
// Back-compat
window.opalwoofilter = function() {
	return true;
};

/**
 * @summary Adds autosave to the window object on dom ready.
 *
 * @since 3.9.0
 *
 * @param {jQuery} $ jQuery object.
 * @param {window} The window object.
 *
 */
 
( function( $, window ) {
	/**
	 * @summary Auto saves the post.
	 *
	 * @since 3.9.0
	 *
	 * @returns {Object}
	 * 	{{
	 * 		getPostData: getPostData,
	 * 		getCompareString: getCompareString,
	 * 		disableButtons: disableButtons,
	 * 		enableButtons: enableButtons,
	 * 		local: ({hasStorage, getSavedPostData, save, suspend, resume}|*),
	 * 		server: ({tempBlockSave, triggerSave, postChanged, suspend, resume}|*)}
	 * 	}
	 * 	The object with all functions for autosave.
	 */
	function opalwoofilter() {
		var  $document = $('html');
		var  $page = $( '#page-importer' );
		var ajaxSelectors  = '.widget_product_categories a, .widget_layered_nav_filters a, .woocommerce-widget-layered-nav a , .widget_rating_filter a, .page-numbers a, .woo-display-mode a, .woo-show-perpage a, .filter-product-brands a';
		
		var loading = 0; 

		/**
		 * @summary Sets the autosave time out.
		 *
		 * Wait for TinyMCE to initialize plus 1 second. for any external css to finish loading,
		 * then save to the textarea before setting initialCompareString.
		 * This avoids any insignificant differences between the initial textarea content and the content
		 * extracted from the editor.
		 *
		 * @since 3.9.0
		 *
		 * @returns {void}
		 */
		
		function hanlde_ajax_sortable(){


			$('body').on('change', "form.woocommerce-ordering select", function(){
				$("form.woocommerce-ordering").submit();
			} ); 
		 
			$('body').on('submit', "form.woocommerce-ordering", function () {
				var url = window.location.href;
				url = remove_url_params( 'orderby', url );
 				url = url.indexOf("?") == -1 ? url+"?"+$(this).serialize():url+"&"+$(this).serialize();
 				make_ajax_filter( url );
            	return false ;
            });

            /// show top filter
            $('body').on( 'click', ".wpopal-filter-top-button", function(){
            	$(".sidebar-filter-content").toggleClass( 'active' );
            	return false;
            } );
		} 


		/**
		 *
		 */
		function hanlder_ajax_loading( $toggle ) {

			loading = $toggle; 

			if( $toggle == 1 ){
				$('body').addClass('opal-filter-loading').append('<div id="opal-woocommerce-loading"></div>');
			} else {
				$('body').removeClass('opal-filter-loading');
        		$('#opal-woocommerce-loading').remove();
			}

		}

		function hanlde_load_more(){
			$( 'body').on( 'click', ".load-more-wrap a" , function(){
				
				var $columns = $("#primary .products").attr( 'class' ).replace(/\s*products\s*/,'').replace( /\s*columns-\s*/,'' );
			// 	alert( _class );
				hanlder_ajax_loading( 1 );
				$.post( $(this).attr('href') , function( data ) {
					if (data) {
						var $html = $( data ); 
					 	
					 	var products = $html.find("#primary").find(".products");
 						var url = $html.find(".load-more-wrap a").attr( 'href' );

 						//console.log( url );
 						if( $html.find(".load-more-wrap").hasClass('load-done') ) {
 							$('body').find(".load-more-wrap a").attr( 'href' , url ).hide();
 							$('body').find(".load-more-wrap").addClass( 'load-done' );
 						} else {
 							$('body').find(".load-more-wrap a").attr( 'href' , url ).show();
 						}
 						
 		 				$(products).find(".product-category").remove();
					 	$("#primary .products").append( $(products).html() );

					 	// update first and last class to fix broken layout.
					 	$("#primary .products > li").removeClass( 'first').removeClass('last');
					 	// 
					 	$("#primary .products > li").each( function(i){
					 		var $loop_index = i+1; 
					 		if ( 0 === ( $loop_index - 1 ) % $columns || 1 === $columns ) {
								$(this).addClass( 'first' );
							}

							if ( 0 === $loop_index % $columns ) {
								$(this).addClass( 'last' );
							}
					 	} );

						hanlder_ajax_loading( 0 );
		            }
				} );


				return false;
			} );
		}

		function hanlde_infinite_ajax(){
			if( $('body').find(".load-more-wrap.has-infinite").length ){

		        $( window ).on( 'scroll touchstart', function (){   
		            $(this).trigger('wpopal_product_infinite_ajax');
		        });
		        
		        $( window ).on( 'wpopal_product_infinite_ajax', function(){ 
		            var t       = $(this),
		            elem  = $( "#primary .products .product" ).last();

		           
		            if( typeof elem == 'undefined' ) {
		                return;
		            }

		            if ( ! loading  && ( t.scrollTop() + t.height() ) >= ( elem.offset().top + elem.height() ) ) {
		            	if( !$('body').find(".load-more-wrap").hasClass('load-done') ) {
		            		$(".load-more-wrap a").trigger( 'click' );
		            	}
		            }
		        })
		    }    
		}
		/**
		 * @summary Sets the autosave time out.
		 *
		 * Wait for TinyMCE to initialize plus 1 second. for any external css to finish loading,
		 * then save to the textarea before setting initialCompareString.
		 * This avoids any insignificant differences between the initial textarea content and the content
		 * extracted from the editor.
		 *
		 * @since 3.9.0
		 *
		 * @returns {void}
		 */
		
		function hanlde_ajax_filters(){
			$('body').on('click', ajaxSelectors, function () {

				var url = $(this).attr('href');
				$( this ).toggleClass( 'active' );
				make_ajax_filter( url );
				
            	return false ;
            });


            // ajax for price filter /// 
            
            $(document.body).bind('price_slider_change', function( event, min, max ){
            	var url = window.location.href;
				url = remove_url_params( 'min_price', url );
				url = remove_url_params( 'max_price', url );

				var sub = "min_price="+min+"&max_price="+max; 

 				url = url.indexOf("?") == -1 ? url + "?"  + sub : url + "&" + sub;
 				make_ajax_filter( url );
            } );

		} 

		function remove_url_params( key, sourceURL ) {
            var rtn = sourceURL.split("?")[0],
		        param,
		        params_arr = [],
		        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
		    if (queryString !== "") {
		        params_arr = queryString.split("&");
		        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
		            param = params_arr[i].split("=")[0];
		            if (param === key) {
		                params_arr.splice(i, 1);
		            }
		        }
		        var _param = params_arr.join("&"); 

		        if( _param ){
		        	rtn = rtn + "?" + _param;
		        }
		    }
		    return rtn;
		}

		function make_ajax_filter( url ){
			hanlder_ajax_loading( 1 );
			$.post(url, function( data ) {
				if (data) {
					var $html = $( data ); 
					render_ajax_content( $html, url );
					hanlder_ajax_loading( 0 );
	            }
			} );
		}

		function render_ajax_content( $html, url ){

			var state = {
                woofilter: true,
                title    : $html.filter( 'title' ).text(),
                sidebar  : $html.find( '#sidebar-left-shop' ).html(),
                content  : $html.find( '#primary' ).html(),
                filter   : $html.find('.opal-canvas-filter-wrap' ).html(),
            };

            $("html title").html( state.title );
			$("#sidebar-left-shop").html( state.sidebar );
			$("#primary").html( state.content );


			init_price_filter();
            window.history.pushState( {url:url}, state.title, url );
		}
 	
	 	function init_price_filter() {

	 		if( $( 'input#min_price, input#max_price' ).length ) {
				$( 'input#min_price, input#max_price' ).hide();
				$( '.price_slider, .price_label' ).show();

				var min_price = $( '.price_slider_amount #min_price' ).data( 'min' ),
					max_price = $( '.price_slider_amount #max_price' ).data( 'max' ),
					current_min_price = $( '.price_slider_amount #min_price' ).val(),
					current_max_price = $( '.price_slider_amount #max_price' ).val();

				$( '.price_slider:not(.ui-slider)' ).slider({
					range: true,
					animate: true,
					min: min_price,
					max: max_price,
					values: [ current_min_price, current_max_price ],
					create: function() {

						$( '.price_slider_amount #min_price' ).val( current_min_price );
						$( '.price_slider_amount #max_price' ).val( current_max_price );

						$( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
					},
					slide: function( event, ui ) {

						$( 'input#min_price' ).val( ui.values[0] );
						$( 'input#max_price' ).val( ui.values[1] );

						$( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
					},
					change: function( event, ui ) {

						$( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
					}
				});
			}	
		}

		/// call to action now
		$( "body" ).ready( function(){
			// processing ajax filter
			hanlde_ajax_filters(); 	

			hanlde_ajax_sortable();


			hanlde_load_more();

			hanlde_infinite_ajax();
		} );

		return {
			 
		};
	}

	/** @namespace wp */
	window.wpopal = window.wpopal || {};
	window.wpopal.opalwoofilter = opalwoofilter();

}( jQuery, window ));