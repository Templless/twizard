( function( $, TwizardDataImport ) {

	"use strict";

	TwizardDataImport = {

		selectors: {
			trigger: '#twizard-import-start',
			advancedTrigger: 'button[data-action="start-install"]',
			popupTrigger: 'button[data-action="confirm-install"]',
			removeContent: 'button[data-action="remove-content"]',
			upload: '#twizard-file-upload',
			globalProgress: '#twizard-import-progress'
		},

		globalProgress: null,

		init: function(){

			$( function() {

				TwizardDataImport.globalProgress = $( TwizardDataImport.selectors.globalProgress ).find( '.twiz-progress__bar' );

				$( 'body' )
				.on( 'click.twizImport', TwizardDataImport.selectors.trigger, TwizardDataImport.goToImport )
				.on( 'click.twizImport', TwizardDataImport.selectors.advancedTrigger, TwizardDataImport.advancedImport )
				.on( 'click.twizImport', TwizardDataImport.selectors.popupTrigger, TwizardDataImport.confirmImport )
				.on( 'click.twizImport', TwizardDataImport.selectors.removeContent, TwizardDataImport.removeContent )
				.on( 'focus.twizImport', '.twiz-remove-form__input', TwizardDataImport.clearRemoveNotices )
				.on( 'change.twizImport', 'input[name="install-type"]', TwizardDataImport.advancedNotice )
				.on( 'click.twizImport', '.twiz-advanced-popup__close', TwizardDataImport.closePopup );

				$( document )
				.on( 'twizard-install-finished', TwizardDataImport.wizardPopup )
				.on( 'twizSliderInit', TwizardDataImport.initSlider );

				if ( window.TwizardDataImportVars.autorun ) {
					TwizardDataImport.startImport();
				}

				if ( undefined !== window.TwizardRegenerateData ) {
					TwizardDataImport.regenerateThumbnails();
				}

				TwizardDataImport.fileUpload();

				TwizardDataImport.initSlider();

			} );

		},

		initSlider: function() {

			var $slider = $( '.twiz-slider .swiper-container' );

			if ( ! $slider.length ) {
				return;
			}

			new Swiper( $slider[0], {
				paginationClickable: true,
				autoplay: 15000,
				pagination: '.slider-pagination',
				parallax: true,
				speed: 600
			} );

		},

		wizardPopup: function () {
			$( '.twiz-advanced-popup' ).removeClass( 'popup-hidden' ).trigger( 'twiz-popup-opened' );
		},

		removeContent: function() {

			var $this    = $( this ),
				$pass    = $this.prev(),
				$form    = $this.closest( '.twiz-remove-form' ),
				$notices = $( '.twiz-remove-form__notices', $form ),
				data     = {};

			if ( $this.hasClass( 'in-progress' ) ) {
				return;
			}

			data.action   = 'twizard-import-remove-content';
			data.nonce    = window.TwizardDataImportVars.nonce;
			data.password = $pass.val();

			$this.addClass( 'in-progress' );

			$.ajax({
				url: window.ajaxurl,
				type: 'post',
				dataType: 'json',
				data: data,
				error: function() {
					$this.removeClass( 'in-progress' );
				}
			}).done( function( response ) {
				if ( true == response.success ) {

					$form.addClass( 'content-removed' );
					$notices.removeClass( 'twiz-hide' );
					$notices.html( response.data.message ).removeClass( 'twiz-error' );

					if ( undefined !== response.data.slider ) {
						TwizardDataImport.showSlider( $form, response.data.slider );
					}

					TwizardDataImport.startImport();

				} else {
					$notices.addClass( 'twiz-error' ).removeClass( 'twiz-hide' );
					$notices.html( response.data.message );
				}

				$this.removeClass( 'in-progress' );
			});

		},

		showSlider: function( where, slider ) {
			setTimeout( function() {
				where.before( slider );
				where.remove();
				console.log('');
				$( document ).trigger( 'twizSliderInit' );
			}, 2000 );
		},

		clearRemoveNotices: function() {

			var $this = $( this ),
				$form    = $this.closest( '.twiz-remove-form' ),
				$notices = $( '.twiz-remove-form__notices', $form );

			$notices.removeClass( 'twiz-error' ).addClass( 'twiz-hide' );

		},

		closePopup: function() {
			$( '.twiz-advanced-popup' ).addClass( 'popup-hidden' ).data( 'url', null );
			$( '.twiz-btn.in-progress' ).removeClass( 'in-progress' );
		},

		confirmImport: function() {
			var $this     = $( this ),
				$popup    = $this.closest( '.twiz-advanced-popup' ),
				$checkbox = $( '.twiz-advanced-popup__item input[type="radio"]:checked', $popup ),
				type      = 'append',
				url       = $popup.data( 'url' );

			$this.addClass( 'in-progress' );

			if ( undefined !== $checkbox.val() && '' !== $checkbox.val() ) {
				type = $checkbox.val();
			}

			url = url + '&type=' + type;

			window.location = url;
		},

		advancedImport: function() {

			var $this = $( this ),
				$item = $this.closest( '.advanced-item' ),
				$type = $( '.advanced-item__type-checkbox input[type="checkbox"]', $item ),
				url   = window.TwizardDataImportVars.advURLMask,
				full  = $item.data( 'full' ),
				min   = $item.data( 'lite' );

			$this.addClass( 'in-progress' );

			if ( $type.is(':checked') ) {
				url = url.replace( '<-file->', min );
			} else {
				url = url.replace( '<-file->', full );
			}

			$( '.twiz-advanced-popup' ).removeClass( 'popup-hidden' ).data( 'url', url );

		},

		advancedNotice: function() {
			var $this   = $( this ),
				$popup  = $this.closest( '.twiz-advanced-popup__content' ),
				$notice = $( '.twiz-advanced-popup__warning', $popup );

			if ( $this.is( ':checked' ) && 'replace' === $this.val() ) {
				$notice.removeClass( 'twiz-hide' );
			} else if ( ! $notice.hasClass( 'twiz-hide' ) ) {
				$notice.addClass( 'twiz-hide' );
			}

		},

		regenerateThumbnails: function() {

			var data = {
				action: 'twizard-regenerate-thumbnails',
				offset: 0,
				step:   window.TwizardRegenerateData.step,
				total:  window.TwizardRegenerateData.totalSteps
			};

			TwizardDataImport.ajaxRequest( data );
		},

		ajaxRequest: function( data ) {

			var complete;

			data.nonce = window.TwizardDataImportVars.nonce;
			data.file  = window.TwizardDataImportVars.file;

			$.ajax({
				url: window.ajaxurl,
				type: 'get',
				dataType: 'json',
				data: data,
				error: function() {

					if ( data.step ) {

						complete = Math.ceil( ( data.offset + data.step ) * 100 / ( data.total * data.step ) );

						TwizardDataImport.globalProgress
							.css( 'width', complete + '%' )
							.find( '.twiz-progress__label' ).text( complete + '%' );

						data.offset = data.offset + data.step;

						TwizardDataImport.ajaxRequest( data );
					} else {
						$( '#twizard-import-progress' ).replaceWith(
							'<div class="import-failed">' + window.TwizardDataImportVars.error + '</div>'
						);
					}
				}
			}).done( function( response ) {
				if ( true === response.success && ! response.data.isLast ) {
					TwizardDataImport.ajaxRequest( response.data );
				}

				if ( response.data && response.data.redirect ) {
					window.location = response.data.redirect;
				}

				if ( response.data && response.data.complete ) {

					TwizardDataImport.globalProgress
						.css( 'width', response.data.complete + '%' )
						.find( '.twiz-progress__label' ).text( response.data.complete + '%' )
						.closest( '.twiz-progress__bar' )
						.next( '.twiz-progress__sub-label' ).text( response.data.complete + '%' );

					TwizardDataImport.globalProgress.siblings( '.twiz-progress__placeholder' ).remove();
				}

				if ( response.data && response.data.processed ) {
					$.each( response.data.processed, TwizardDataImport.updateSummary );
				}

			});

		},

		updateSummary: function( index, value ) {

			var $row       = $( 'tr[data-item="' + index + '"]' ),
				total      = parseInt( $row.data( 'total' ) ),
				$done      = $( '.twiz-install-summary__done', $row ),
				$percent   = $( '.twiz-install-summary__percent', $row ),
				$progress  = $( '.twiz-progress__bar', $row ),
				$status    = $( '.twiz-progress-status', $row ),
				percentVal = Math.round( ( parseInt( value ) / total ) * 100 );

			if ( $done.hasClass( 'is-finished' ) ) {
				return;
			}

			if ( 100 === percentVal ) {
				$done.addClass( 'is-finished' ).closest( 'td' ).addClass( 'is-finished' );
				$status.html( '<span class="dashicons dashicons-yes"></span>' );
			}

			$done.html( value );
			$percent.html( percentVal );
			$progress.css( 'width', percentVal + '%' );

		},

		startImport: function() {

			var data    = {
					action: 'twizard-import-chunk',
					chunk:  1
				};

			TwizardDataImport.ajaxRequest( data );

		},

		prepareImportArgs: function() {

			var file    = null,
				$upload = $( 'input[name="upload_file"]' ),
				$select = $( 'select[name="import_file"]' );

			if ( $upload.length && '' !== $upload.val() ) {
				file = $upload.val();
			}

			if ( $select.length && null == file ) {
				file = $( 'option:selected', $select ).val();
			}

			return '&tab=' + window.TwizardDataImportVars.tab + '&step=2&file=' + file;

		},

		goToImport: function() {

			var url = $('input[name="referrer"]').val();

			if ( ! $( this ).hasClass( 'disabled' ) ) {
				window.location = url + TwizardDataImport.prepareImportArgs();
			}

		},

		fileUpload: function() {

			var $button      = $( TwizardDataImport.selectors.upload ),
				$container   = $button.closest('.import-file'),
				$placeholder = $container.find('.import-file__placeholder'),
				$input       = $container.find('.import-file__input'),
				uploader     = wp.media.frames.file_frame = wp.media({
					title: window.TwizardDataImportVars.uploadTitle,
					button: {
						text: window.TwizardDataImportVars.uploadBtn
					},
					multiple: false
				}),
				openFrame = function () {
					uploader.open();
					return !1;
				},
				onFileSelect = function() {
					var attachment = uploader.state().get( 'selection' ).toJSON(),
						xmlData    = attachment[0],
						inputVal   = '';

					$placeholder.val( xmlData.url );
					TwizardDataImport.getFilePath( xmlData.url, $input );
				};

			$button.on( 'click', openFrame );
			uploader.on('select', onFileSelect );

		},

		getFilePath: function( fileUrl, $input ) {

			var $importBtn = $( TwizardDataImport.selectors.trigger ),
				path       = '';

			$importBtn.addClass( 'disabled' );

			$.ajax({
				url: window.ajaxurl,
				type: 'get',
				dataType: 'json',
				data: {
					action: 'twizard-import-get-file-path',
					file: fileUrl,
					nonce: window.TwizardDataImportVars.nonce
				},
				error: function() {
					$importBtn.removeClass( 'disabled' );
					return !1;
				}
			}).done( function( response ) {
				$importBtn.removeClass( 'disabled' );
				if ( true === response.success ) {
					$input.val( response.data.path );
				}
			});

		}

	}

	TwizardDataImport.init();

}( jQuery, window.TwizardDataImport ) );
