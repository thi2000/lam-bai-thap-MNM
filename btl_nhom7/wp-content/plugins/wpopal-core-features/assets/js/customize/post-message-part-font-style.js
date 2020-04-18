wp.customize( '@setting@', function( value ) {
	value.bind( function( newval ) {
		// console.log( newval );
		if ( false == newval ) { newval = ''; }
		// $('@selector@').css( '@setting_property@' , newval+'@setting_unit@' );
		$('@selector@').each( function ( index, element ){
			if (newval.italic) {
	            element.style.fontStyle = 'italic';
	        } else {
	            element.style.fontStyle = 'normal';
	        }

	        if (newval.underline) {
	            element.style.textDecoration = 'underline'
	        } else {
	            element.style.textDecoration = 'none'
	        }

	        if (newval.fontWeight) {
	            element.style.fontWeight = 'bold';
	        } else {
	            element.style.fontWeight = 'normal';
	        }

	        if (newval.uppercase) {
	            element.style.textTransform = 'uppercase';
	        } else {
	            element.style.textTransform = 'none';
	        }
		} );
		

	} );
} );