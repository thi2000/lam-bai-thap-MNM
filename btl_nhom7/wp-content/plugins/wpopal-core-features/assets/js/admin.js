(function ($) {


	/**************************************************************************************************
	 * Slider fields
	 *************************************************************************************************/	
	var initSlider= function  (element) {
        let $slider = $(element);
        let id = $slider.data('id');
        let unit = $slider.data('unit') ? $slider.data('unit') : '';
        $slider.slider({
            range : "min",
            min   : $slider.data('min'),
            max   : $slider.data('max'),
            step  : $slider.data('step'),
            value : $slider.data('value'),
            create: function (event, ui) {
                $slider.children('.ui-slider-handle').html(`<span>${$slider.slider('value')}${unit}</span>`);
            },
            slide : function (event, ui) {
                $slider.children('.ui-slider-handle').html(`<span>${ui.value}${unit}</span>`);
                $('#' + id).val(ui.value);
            },
            change: function (event, ui) {
                $(ui.handle).closest('.cmb2-slider-element').find('[opal-hidden="true"]').val(ui.value);
            }
        });
        $slider.next().on('click', function () {
            $slider.slider('value', $slider.data('default-value'));
        })
    }; 

	$('.otf-customize-slider .otf-slider').each((index, element) => {
         initSlider(element);
    })

	/****************************************************************************************************
	 * Custom Tabs 
	 ****************************************************************************************************/
   



    /******/

   function init() {
        $('.opal-onoffswitch-wrapper').each((index, element) => {
            let $input   = $('input.onoffswitch-input', element);
            let $switch  = $('.onoffswitch-checkbox', element);
            let selector = getSelectorString($switch);
            actionShowHide(selector, $switch.prop('checked'), 0);
            $switch.on('change', () => {
                actionShowHide(selector, $switch.prop('checked'));
                if ($switch.prop('checked')) {
                    $input.val('1');
                } else {
                    $input.val('0');
                }
            })
        })
    }

    init(); 
   function actionShowHide(selector, show, duration = 400) {
        if (show) {
            $(selector).stop().slideDown(duration);
        } else {
            $(selector).stop().slideUp(duration);
        }
    }

   function getSelectorString($switch) {
        if (typeof $switch.data('show-fields') === 'object') {
            return $switch.data('show-fields').map((field) => {
                return '.cmb2-id-' + field.replace(/_/g, '-');
            }).join(',');
        } else {
            return false;
        }
    }

    ///// / // 
    function process_format_post_select() {
        var format_select_hide_all = function (){  
            var idselected = '';
            $(".editor-post-format select option").each( function() {
                var id = $(this).attr( 'value' ); 
                $('#wpopal-post-format-'+id).hide(); 
                 
            } );
            var idselected= $(".editor-post-format select").val();
            if( idselected ){
                $('#wpopal-post-format-'+idselected).show(); 
            }
        }
        format_select_hide_all();
        $(".editor-post-format select").change( function(){ 
            format_select_hide_all();
            var id = $(this).val();    
            $('#wpopal-post-format-'+id).show(); 
        } );
    }
    
    $( document ).ready( function (){   
     

        setTimeout( function(){
            if( $(".editor-post-format").length ){   
                process_format_post_select();
            }

        }, 5000 );
    } );
  

})(jQuery);