/* global tinymce, wpCookies, autosaveL10n, switchEditors */
// Back-compat
window.opalimporter = function() {
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
	function opalimporter() {
		var  $document = $(document);
		var  $page = $( '#page-importer' );

		/**
		 *
		 */
		function modal(){
			$(".wpopal-modal-trigger").click(function(e){  
				  e.preventDefault();
				  dataModal = $(this).attr("data-modal"); 
 
				  $("#" + dataModal).css({"display":"block"});
			});

			$(".close-wpopal-modal").click(function(){
			  //	$(".wpopal-modal").css({"display":"none"});

			});

			$('body').delegate( '.close-wpopal-modal', 'click', function () {
				$(".wpopal-modal").css({"display":"none"});
				return false;
			} );

			$('body').delegate( '.install-plugin-button', 'click', function () {
				 
				var $parent = $("#install-plugins-required"); 
				var plugins = [] ;
				if( $(".pluign-item", $parent ).length > 0 ) {
					$(".pluign-item", $parent ).each( function(){
						plugins.push(  $(this).data('plugin') );
					} );
				}

				var index = 0; 
				 
				index = ajax_install_plugins( index, plugins.length, plugins );

				return false;
			} );
		}

  		function ajax_install_plugins ( index, total , plugins ){

  			var params = 'total='+ total;
			var plugin = plugins[index]; 	

			params += '&next=install_plugins';
			params += '&do=plugins'; 
			params += '&pluign='+plugin; 


			var $item = $('.plugin-'+plugin); 

			$item.addClass("doing");
  			make_ajax_html( 'action=opal_install_bysteps', params+"&index="+index, function( output ){
  				index = index + 1; 
  				$item.removeClass("doing").addClass('done');
  				if( index >= total ){
  					$(".install-plugin-button").hide();
  					$(".opal-continue-import").removeClass("hide").show();
  					return true; 
  				}
  				ajax_install_plugins( index, total, plugins );
			} );
  		}

		function set_modal_body( content ){
			$(".wpopal-modal .inner").html( content );
		}

		function set_modal_main_action_content( content, process ){
			$(".import-main-action .inner").html( content );
			render_process_bar( process );
		}

		/*
		 * make ajax post request and response json .
		 */
		function make_ajax_html( action, data,_callback ) {
			toggle_loading_action();
			$.ajax({
			    url: ajaxurl+"?"+action,
			    data: data,
			    error: function() {
			    	$('.processbar-wrap').before( $('<p>An error has occurred</p>') );
			    },
 
			    success: function( ouput ) {  
			    	toggle_loading_action();
			    	if ( _callback ){
						_callback( ouput );
			    	}
			    },
			    type:"POST"
			});
		}
		function toggle_loading_action(){  
			$(".import-main-action").toggleClass( 'loading' );
		}

		/*
		 * make ajax post request and response json .
		 */
		function make_ajax( action, data,_callback ) {
			toggle_loading_action();
			$.ajax({
			    url: ajaxurl+"?"+action,
			    data: data,
			    error: function( data ) {
			    	console.log( data );
			      	$('.processbar-wrap').before( $('<p>An error has occurred</p>') );
			    },
			    dataType: 'json',
			    success: function( ouput ) {  
			    	toggle_loading_action();
			    	if ( _callback ){
						_callback( ouput );
			    	}
			    },
			    type:"POST"
			});
		}
		
		/**
		 * select sampel data and click to start install
		 */
		function select_sample(){

			var showModal = function (){
				$(".wpopal-modal").css({"display":"block"});
			}

			var hideModal = function () {
				$(".wpopal-modal").css({"display":"none"});
			}

			var get_sample_info = function ( url ) {

			}
			/*
			 * Select a sample and confirm to install this
			 */
			$( '.button-import', $page ) .click ( function () {

				var data = $(this).data();
				make_ajax( "action=opal_show_confirmation", data, function( ouput ){ 
				 //	console.log( ouput.data.content );
					set_modal_body( ouput.data.content );
					showModal();
				} );
				
				return false; 
			} );
		}

		/**
		 *
		 */
		function import_sample(){
			$('body').delegate( '#opal-import-content .opal-continue-import', 'click', function () {
				var data = $(this).data();
				
				console.log( data );

				process_import( data );
				return false;
			} );
		}

		/**
		 *
		 */
		function process_import(  data ){
			make_ajax( "action=opal_install_bysteps", data, function( output ){ 
 
				set_modal_main_action_content( output.data.content, output.data.process );
			 	
				if( output.data.done == 1 ){
					console.log( "ok import done");
				} else {
					if( output.data.ajax ){ 
						process_import( output.data.ajax );
					}
				}
			} );
		}

		function render_process_bar( _process ){

			
			if( $(".import-main-action").find(".processbar-wrap .process-bar").length > 0 ) {
				 
			} else {
				var html = '<div class="process-bar">';
				html += '<div class="process-inner"><div class="process-bar-processing"></div></div>';
				html +='</div>';	

				$(".processbar-wrap").html( html );

			}
			
			if( _process ) {
				var s = _process.split("|");

				var p = (s[0]*100)/(s[1]);
				$(".processbar-wrap .process-bar-processing").css( "width", p+"%" );
				console.log( p );
				if( p == 100 ){

					$(".processbar-wrap").delay(300).queue(function (next) {
					    $(this).hide();
					    next();
					});

				}
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
		$document.on( '#page-importer', function( event, editor ) {
			 	
		}).ready( function() {
			modal();		
		 	select_sample();
		 	import_sample();
		});

		return {
			 
		};
	}

	/** @namespace wp */
	window.wp = window.wp || {};
	window.wp.opalimporter = opalimporter();

}( jQuery, window ));