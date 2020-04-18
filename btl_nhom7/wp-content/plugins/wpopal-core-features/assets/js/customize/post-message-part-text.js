wp.customize( '@setting_font@', function( value ) {
	value.bind( function( newval ) {
		var font = ( newval );

		// console.log( font );

		if ( undefined !== font.family ) {

			var template = "@import url('//fonts.googleapis.com/css?family="+font.family+":"+font.fontWeight+"');\r\n";
			//var atImport = template.replace( '@import_family@', font.family );
			//	atImport = template.replace( '@font_fontweight@', font.fontWeight );
			$( '<style>' ).append( template ).appendTo( 'head' );
		}
 
		$('@selector@').css('font-family', font.family );
	} );
} );