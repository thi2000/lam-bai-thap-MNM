/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
( function() {
	"use strict";
	var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    isOpera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    isIe     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( isWebkit || isOpera || isIe ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();

(function () {
    "use strict";
    jQuery(document).ready(function ($) {
        /// page preloader //////////////////////////////

      
       //  var scroll = new SmoothScroll('#back-to-top');


        $( window ).on( 'load', function() {
            setTimeout( function() {
                $('body').addClass( 'loaded' );
            }, 200 );

            var $loader = $( '#page-preloader' );

            setTimeout( function() {
                $loader.addClass("page-animate-close").remove(); 
                $('body').removeClass( 'loaded' );
            }, 2000 ); 
        } );
        
        /// back to top /////////////////////////////////
        if ($('#back-to-top').length) {
            var scrollTrigger = 200, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
            backToTop();
            $(window).on('scroll', function () {
                backToTop();
            });
            
            $('#back-to-top').on('click', function (e) {
                e.preventDefault();
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            }); 
        }

      /// update menu 
      if( $("#offcanvas-sidebar").length ) {   
          var $button = $("#navbar-toggler-mobile");
          $( '#offcanvas-sidebar' ).offcanvas( {
              modifiers: $button.data('appear'),
              triggerButton: "#navbar-toggler-mobile"
          } );  
           var $parent = $( "#offcanvas-sidebar" );
      }
    	/// auto play swiper slider /////////////////////////////
    	if( $('.wpopal-swiper-play').length > 0 ){
   			 
          var play_swiper_sliders = function () {
                if( $('.wpopal-swiper-play').length > 0 ){
                    $('.wpopal-swiper-play').each( function(){
                      var option = $(this).data( 'swiper' );
                              if( !$(this).find('.swiper-pagination').length ){ 
                                  $(this).append( $('<div class="swiper-pagination"></div>') );
                              }
                              if( !$(this).find('.swiper-button-next').length ){
                                  $(this).append( $('<div class="swiper-button-next"></div>') );
                                  $(this).append( $('<div class="swiper-button-prev"></div>') );
                              }
                               
                              if( option ){
                                  option = $.extend( {
                                      navigation: {
                                          nextEl: '.swiper-button-next',
                                          prevEl: '.swiper-button-prev'
                                      },
                                      slidesPerView: 3,
                                      spaceBetween: 30,
                                      loop: true,
                                      pagination: {
                                          el: '.swiper-pagination',
                                          clickable: true,
                                      },
                                      breakpoints: {
                                            1024: {
                                             slidesPerView: 1,
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

                                  if( option.thumbnails_nav ) {
                                      var ioption = $(  option.thumbnails_nav ).data( 'swiper' );

                                      var iswiper = new Swiper( option.thumbnails_nav , ioption );
                                      option.thumbs = {
                                        swiper: iswiper
                                      }

                                  }
                                
                                  var swiper = new Swiper( this , option );
                              } 
                    } );
                  } 
          }
          play_swiper_sliders(); 
          $( document ).ajaxComplete(function() {
              play_swiper_sliders(); 
          });
    	} 
        /// //// 
        var $container = $( '.wpopal-blog-masonry-style' );  
        if(  $container.length ) {
            $container.imagesLoaded(function() {  
                $container.isotope({
                    isOriginLeft: ! $('body').hasClass('rtl'),
                    itemSelector: '.column-item'
                });
            });
        }
        /// 
        $( '.isotope-grid-play' ).each( function () {
            
            var $container = $(this); 

            $container.imagesLoaded(function() {  

                  var $_options = {
                      isOriginLeft: ! $('body').hasClass('rtl'),
                      itemSelector: '.column-item',
                      percentPosition: true
                  }; 

                  $container.isotope( $_options );
              });
        } );
        ///// 
        $('.magnific-popup-iframe').magnificPopup({
              disableOn: 700,
              type: 'iframe',
              mainClass: 'mfp-fade',
              removalDelay: 160,
              preloader: false,
              fixedContentPos: false
        });

      
      $('.open-popup-link').magnificPopup({
          type:'inline',
          mainClass: 'mfp-with-fade',
          closeBtnInside: true,
          removalDelay: 1000, //delay removal by X to allow out-animation
          callbacks: {
            beforeOpen: function() {
                this.st.mainClass =  'popup-animation-show';
            }
          },
          midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
      });
 

    });

})(jQuery);
