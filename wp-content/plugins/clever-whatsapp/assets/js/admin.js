jQuery(function($) {

	'use strict';

	/**
	 * Save the main building block of DOM elements; for the
	 * sake of succinctness
	 **********************************************************************/
	var DOM = (function ( dom ) {

		var dom = dom || {};

		dom.body = $( 'body:eq(0)' );

		return dom;

	} ( DOM ) );

	/**
	* I use MiniColor library for the color picker. It should be use on
	* all inputs with a .minicolors class name.
	**********************************************************************/
	(function () {

		if( $.minicolors ) {
			DOM.body.find( '.minicolors' ).minicolors({
				opacity: true,
				format: 'rgb'
			});
		}

	}());

	/**
	*
	**********************************************************************/
	(function () {

		var handleMediaPicker = function () {

			DOM.body.find( '.media-picker' ).each(function () {
				var el = $( this ),
					container,
					button,
					buttonText = el.data( 'button-text' ),
					preview
					;

				el.wrap( '<div class="cleverwa-picker-container"></div>' );
				container = el.parents( '.cleverwa-picker-container' );
				if ( ! container.find( '.cleverwa-clicker' ).length ) {
					container.append( '<span class="cleverwa-clicker">' + buttonText + '</span>' );
					container.append( '<div class="cleverwa-picker-preview"></div>' );
				}
				button = container.find( 'span.cleverwa-clicker' );
				preview = container.find( '.cleverwa-picker-preview' );

				el.css({
					paddingRight: Math.ceil( parseInt( button.outerWidth() ) ) + 3
				});

				container.off().on( 'click', '.cleverwa-close-preview', function () {
					el.val( '' );
					preview.html( '' );
				} );

				if ( '' !== el.val() ) {
					preview.addClass( 'show' ).html( '<span class="cleverwa-image-container"><img src="' + el.val() + '" /><span class="cleverwa-close-preview"></span></span>' );
				}

			});
		};

		handleMediaPicker();

		/* When the button is clicked, open the media library */
		DOM.body.on( 'click', '.cleverwa-picker-container .cleverwa-clicker', function ( e ) {
			e.preventDefault();

			var el = $( this ),
				inputField = el.prev( 'input' ),
				preview = el.next( '.cleverwa-picker-preview' ),
				insertImage = wp.media.controller.Library.extend({
					defaults :  _.defaults({
							id: 'insert-image',
							title: 'Insert Image Url',
							allowLocalEdits: true,
							displaySettings: true,
							displayUserSettings: true,
							multiple : true,
							type : 'image' /* audio, video, application/pdf, ... etc */
					  }, wp.media.controller.Library.prototype.defaults)
				});

			/* Setup media frame */
			var frame = wp.media({
				button : { text : 'Select' },
				state : 'insert-image',
				states : [
					new insertImage()
				]
			});

			frame.on('select',function() {

				var state = frame.state('insert-image')
					, selection = state.get('selection')
					;

				if (!selection) {
					return;
				}
				var imgSrc = ''
					, attachmentIds = []
					, isImage = true;
					;
				selection.each(function(attachment) {
					var display = state.display(attachment).toJSON()
						, obj_attachment = attachment.toJSON()
						;

					display = wp.media.string.props(display, obj_attachment);
					imgSrc = display['src'] || display['linkUrl'];

					if ( ! display['src'] ) {
						isImage = false;
					}

					/* What is being returned? */
					attachmentIds.push(attachment.id);
				});

				inputField.val( imgSrc );

				/* 	If the selected file is an image, set the value into an <img> and
					show the preview. Otherwise, hide the preview. */
				if ( isImage ) {
					preview.addClass('show').html( '<span class="cleverwa-image-container"><img src="' + imgSrc + '" /><span class="cleverwa-close-preview"></span></span>' );
				}
				else {
					preview.removeClass('show').html( '' );
				}

			});

			/* reset selection in popup, when open the popup */
			frame.on('open',function() {
				var selection = frame.state('insert-image').get('selection');

				/* remove all the selection first */
				selection.each(function(image) {
					var attachment = wp.media.attachment( image.attributes.id );
					attachment.fetch();
					selection.remove(attachment ? [attachment] : []);
				});
			});

			/* now open the popup */
			frame.open();

		} );

		/*	Add new contact. */
		var template = DOM.body.find( 'template#account-item' ).html(),
			currentId = parseInt( DOM.body.find( '.cleverwa-account-item' ).length ),
			accountContainer = DOM.body.find( '.cleverwa-account-items' )
			;

		DOM.body.find( '.cleverwa-add-account' ).on( 'click', function (e) {
			e.preventDefault();
			accountContainer.append( template.replace( /#id#/g, ++currentId ) );
			//$( this ).parents( '.form-table' ).before( template.replace( /#id#/g, ++currentId ) );
			handleMediaPicker();
		} );

		/*	Remove contact. */
		DOM.body.on( 'click', '.cleverwa-remove-account', function (e) {
			e.preventDefault();
			$( this ).parents( '.cleverwa-account-item' ).remove();
		} );

	}());

	/**
	* Search posts to exclude
	**********************************************************************/
	(function () {

		DOM.body.find( '.cleverwa-search-posts input' ).on( 'keydown keyup focus blur', function ( e ) {

			var el = $( this )
				, parent = el.parents( 'td' )
				, searchContainer = parent.find( '.cleverwa-search-posts' )
				, searchList = searchContainer.find( 'ul' )
				, searchInput = searchContainer.find( 'input' )
				, nonce = searchInput.data( 'nonce' )
				, searching
				, xhr = false
				;

			/* Do nothing when Enter key is pressed */
			if( e.keyCode == 13 ) {
				e.preventDefault();
			}

			if ( e.type === 'focus' ) {
				searchList.addClass( 'cleverwa-show' );
				return true;
			}

			if ( e.type === 'blur' ) {
				searchList.removeClass( 'cleverwa-show' );
				return true;
			}

			if ( e.type === 'keyup' ) {

				clearTimeout( searching );
				if ( xhr ) {
					xhr.abort();
					searchContainer.removeClass( 'cleverwa-show-loader' );
				}

				searching = setTimeout( function () {
					var data = {
						action: 'cleverwa_search_posts',
						security: nonce,
						title: el.val()
					};

					if ( '' === data.title ) {
						searchList.removeClass( 'cleverwa-show' ).html( '' );
						return;
					}

					searchContainer.addClass( 'cleverwa-show-loader' );
					xhr = $.post( ajaxurl, data, function( response ) {

						if ( 'no-result' !== response ) {
							searchList.addClass( 'cleverwa-show' ).html( response );
						}
						else {
							searchList.removeClass( 'cleverwa-show' ).html( '' );
						}

						searchContainer.removeClass( 'cleverwa-show-loader' );

					} );

				}, 250 );

			}

		} );

		DOM.body.find( '.cleverwa-search-posts ul' ).on( 'click', 'li', function () {

			var el = $( this )
				, inclusion = el.parents( 'td' ).find( '.cleverwa-inclusion' )
				, id = el.data( 'id' )
				, permalink = el.find( '.cleverwa-permalink' ).text()
				, title = el.find( '.cleverwa-title' ).text()
				, deleteLabel = inclusion.data( 'delete-label' )
				, arrayName = inclusion.is( '.cleverwa-included-posts' ) ? 'cleverwa_included' : 'cleverwa_excluded'
				;

			$(  '<li id="cleverwa-excluded-' + id + '">' +
					'<p class="cleverwa-title">' + title + '</p> ' +
					'<p class="cleverwa-permalink"><a href="' + permalink + '" target="_blank">' + permalink + '</a></p> ' +
					'<span class="dashicons dashicons-no"></span>' +
					'<input type="hidden" name="' + arrayName + '[]" value="' + id + '"/>' +
				'</li>' ).appendTo( inclusion );

		} );

		DOM.body.find( '.cleverwa-inclusion' ).on( 'click', '.dashicons', function () {
			$( this ).parent( 'li' ).remove();
		} );

	}());

	/**
	* Move an account up or down
	**********************************************************************/
	(function () {

		DOM.body.on( 'click', '.cleverwa-queue-buttons span', function () {

			var el = $( this ),
				direction = el.is( '.cleverwa-move-up' ) ? 'up' : 'down',
				table = el.parents( 'table' )
				;

			if ( el.is( '.cleverwa-move-up' ) ) {
				table.insertBefore( table.prev( 'table' ) );
			}
			else {
				table.insertAfter( table.next( 'table' ) );
			}

		} );

	}());

	/**
	* Executed on 'product' post type.
	**********************************************************************/
	(function () {

		var cbRemoveButton = DOM.body.find( 'input#cleverwa_remove_button' ),
			settingsTable = DOM.body.find( '#cleverwa-custom-wc-button-settings' ),
			toggleSettings = function () {
				if ( cbRemoveButton.is( ':checked' ) ) {
					settingsTable.hide();
				}
				else {
					settingsTable.show();
				}
			}
			;

		toggleSettings();

		cbRemoveButton.change(function () {
			toggleSettings();
		});

	}());

	/**
	* Search accounts
	**********************************************************************/
	(function () {

		var accountResult = DOM.body.find( '.cleverwa-account-result .cleverwa-account-list' );

		DOM.body.find( '.cleverwa-account-search input' ).on( 'keydown keyup focus blur', function ( e ) {

			var el = $( this )
				, searchContainer = el.parents( '.cleverwa-account-search' )
				, searchList = searchContainer.find( '.cleverwa-account-list' )
				, searchInput = searchContainer.find( 'input' )
				, nonce = searchInput.data( 'nonce' )
				, searching
				, xhr = false
				;

			/* Do nothing when Enter key is pressed */
			if( e.keyCode == 13 ) {
				e.preventDefault();
			}

			if ( e.type === 'focus' ) {
				searchList.addClass( 'cleverwa-show' );
				return true;
			}

			if ( e.type === 'blur' ) {
				setTimeout( function () {
					searchList.removeClass( 'cleverwa-show' );
				}, 150 );
				return true;
			}

			if ( e.type === 'keyup' ) {

				clearTimeout( searching );
				if ( xhr ) {
					xhr.abort();
					searchContainer.removeClass( 'cleverwa-show-loader' );
				}

				searching = setTimeout( function () {
					var data = {
						action: 'cleverwa_search_accounts',
						security: nonce,
						title: el.val()
					};

					if ( '' === data.title ) {
						searchList.removeClass( 'cleverwa-show' ).html( '' );
						return;
					}

					searchContainer.addClass( 'cleverwa-show-loader' );
					xhr = $.post( ajaxurl, data, function( response ) {

						if ( 'no-result' !== response ) {
							searchList.addClass( 'cleverwa-show' ).html( response );
						}
						else {
							searchList.removeClass( 'cleverwa-show' ).html( '' );
						}

						searchContainer.removeClass( 'cleverwa-show-loader' );

					} );

				}, 250 );

			}

		} );

		DOM.body.find( '.cleverwa-account-search' ).on( 'click', '.cleverwa-item', function () {

			var el = $( this )
				, id = el.data( 'id' )
				, nameTitle = el.data( 'name-title' )
				, removeLabel = el.data( 'remove-label' )
				, imageURL = el.find( '.cleverwa-avatar img' ).attr( 'src' )
				, title = el.find( '.cleverwa-title' ).text()
				;

			$( '<div class="cleverwa-item cleverwa-clearfix" id="cleverwa-item-' + id + '">' +
					'<div class="cleverwa-avatar"><img src="' + imageURL + '" alt=""/></div>' +
					'<div class="cleverwa-info cleverwa-clearfix">' +
						'<a href="post.php?post=' + id + '&action=edit" target="_blank" class="cleverwa-title">' + title + '</a>' +
						'<div class="cleverwa-meta">' +
							nameTitle + ' <br/>' +
							'<span class="cleverwa-remove-account">' + removeLabel + '</span>' +
						'</div>' +
					'</div>' +
					'<div class="cleverwa-updown"><span class="cleverwa-up dashicons dashicons-arrow-up-alt2"></span><span class="cleverwa-down dashicons dashicons-arrow-down-alt2"></span></div>' +
					'<input type="hidden" name="cleverwa_selected_account[]" value="' + id + '"/>' +
				'</div>' ).appendTo( accountResult );

		} );

		accountResult.on( 'click', '.cleverwa-updown span', function () {

			var el = $( this )
				, item = el.parents( '.cleverwa-item' )
				;

			if ( el.is( '.cleverwa-up' ) ) {
				item.insertBefore( item.prev( '.cleverwa-item' ) );
			}
			else {
				item.insertAfter( item.next( '.cleverwa-item' ) );
			}

		});

		accountResult.on( 'click', '.cleverwa-remove-account', function () {
			$( this ).parents( '.cleverwa-item' ).remove();
		} );

	}());

	/**
	*
	**********************************************************************/
	(function () {
		DOM.body.find('#cleverwa-custom-wc-button-settings').on('click', '#cleverwa_availability_apply_to_add_days', function(e){
			var el = $(this);
			var day = el.data('day');
			var day_enable = $('#clever_display_availability_enable_' + day + ':checked').length;
			var hour_start = $('select[name="cleverwa_availability[' + day + '][hour_start]"]').children("option:selected").val();
			var minute_start = $('select[name="cleverwa_availability[' + day + '][minute_start]"]').children("option:selected").val();
			var hour_end = $('select[name="cleverwa_availability[' + day + '][hour_end]"]').children("option:selected").val();
			var minute_end = $('select[name="cleverwa_availability[' + day + '][minute_end]"]').children("option:selected").val();

			var days_array = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
			days_array.forEach((item, i) => {
				if (day_enable==1) {
					$('#clever_display_availability_enable_' + item).prop('checked', true);
				} else {
					$('#clever_display_availability_enable_' + item).prop('checked', false);
				}
				$('select[name="cleverwa_availability[' + item + '][hour_start]"]').val(hour_start);
				$('select[name="cleverwa_availability[' + item + '][minute_start]"]').val(minute_start);
				$('select[name="cleverwa_availability[' + item + '][hour_end]"]').val(hour_end);
				$('select[name="cleverwa_availability[' + item + '][minute_end]"]').val(minute_end);
			});


		});


	}());

});
