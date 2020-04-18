wp.customize( '@setting@', function( value ) {
	value.bind( function( newval ) {
		if ( false == newval ) { newval = ''; }  
		if( newval == '') {
			$('@selector@').css( '@setting_property@', '');
		} else  {
			$('@selector@').css( '@setting_property@' , newval+'@setting_unit@' );
		}
		
	} );
} );