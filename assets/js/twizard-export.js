( function( $, TwizardDataExport ) {
	"use strict";
	TwizardDataExport = {
		globalProgress: null,
		init: function(){
			$( '#twizard-export' ).on( 'click', function( event ) {
				var $this   = $( this ),
					href    = $this.attr( 'href' );
				event.preventDefault();
				window.location = href + '&nonce=' + window.TwizardDataExportVars.nonce;
			});
		},
	}
	TwizardDataExport.init();

}( jQuery, window.TwizardDataExport ) );