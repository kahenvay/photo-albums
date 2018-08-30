(function($) {
'use strict';

/**
 * All of the code for your admin-specific JavaScript source
 * should reside in this file.
 *
 * Note that this assume you're going to use jQuery, so it prepares
 * the $ function reference to be used within the scope of this
 * function.
 *
 * From here, you're able to define handlers for when the DOM is
 * ready:
 *
 * $(function() {
 *
 * });
 *
 * Or when the window is loaded:
 *
 * $( window ).load(function() {
 *
 * });
 *
 * ...and so on.
 *
 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
 * be doing this, we should try to minimize doing that in our own work.
 */

function imagePreviewHtml(src) {
	return '<div id="upload_photos_preview" class="tdy-pa-upload-preview">' +
		'<div class="tdy-pa-close remove_image">&#8722;</div>' +
		'<img style="max-width: 150px; object-fit: contain;" src="' + src + '" />' +
		'</div>'
}

$(function() {

	/*
	*
	*/
	// Let's set up some variables for the image upload and removing the image     
	var frame,
		imgUploadButton = $('#upload_photos_button'),
		imgContainer = $('#upload_photos_preview'),
		imgIdInput = $('#_tdy_pa_photos_meta'),
		// imgPreview = $('#upload_photos_preview'),
		imgDelButton = $('#tdy-pa-delete_photos_button');

	// wp.media add Image
	imgUploadButton.on('click', function(event) {

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if (frame) {
			frame.open();
			return;
		}

		// Create a new media frame
		frame = wp.media({
			title: 'Select or Upload Media for your Photo Album',
			button: {
				text: 'Use as my Photos'
			},
			multiple: true // Set to true to allow multiple files to be selected
		});

		frame.on('open', function() {
			var selection = frame.state().get('selection');
			console.log('selection', selection);
			// ids = jQuery('#my_field_id').val().split(',');
			var inputValue = $('#_tdy_pa_photos_meta').val();
			var inputValueObject = JSON.parse(inputValue);
			inputValueObject.forEach(function(obj) {
				var attachment = wp.media.attachment(obj.id);
				attachment.fetch();
				selection.add(attachment ? [attachment] : []);
			});
		});

		// When an image is selected in the media frame...
		frame.on('select', function() {

			console.log('frame', frame);

			// Get media attachment details from the frame state
			// var attachment = frame.state().get('selection').first().toJSON();
			var attachment = frame.state().get('selection').toJSON();

			console.log('attachment', attachment);

			// Delete old previews
			$('.tdy-pa-upload-preview').remove();

			// Initialse src array to retrun to the input and save
			var srcArray = [];

			// Create image previews for each attachments found and fill are src array
			for (var i = 0; i < attachment.length; i++) {
				$('.tdy-pa-upload-wrapper').append(imagePreviewHtml(attachment[i].url));
				var img = {
					id: attachment[i].id,
					src: attachment[i].url,
				};
				srcArray.push(img);
			}

			// Send the attachment src to our hidden input
			imgIdInput.val(JSON.stringify(srcArray));

			$('.remove_image').on('click', function(e) {
				e.preventDefault();

				var thisImageUrl = $(this).parent().find('img').attr('src');

				var inputValue = $('#_tdy_pa_photos_meta').val();
				var inputValueObject = JSON.parse(inputValue);

				inputValueObject = inputValueObject.filter(function(obj) {
					return obj.src !== thisImageUrl;
				});

				// var index = inputValueObject.indexOf(thisImageUrl);
				// if (index > -1) {
				// 	inputValueObject.splice(index, 1);
				// }

				inputValue = JSON.stringify(inputValueObject);
				$('#_tdy_pa_photos_meta').val(inputValue);

				$(this).parent().remove();
			});

		});

		// Finally, open the modal on click
		frame.open();
	});

	// Erase image url and age preview
	imgDelButton.on('click', function(e) {
		e.preventDefault();
		$('.tdy-pa-upload-preview').remove();
		imgIdInput.val('');
	});

	$('.remove_image').on('click', function(e) {
		e.preventDefault();

		var thisImageUrl = $(this).parent().find('img').attr('src');

		var inputValue = $('#_tdy_pa_photos_meta').val();
		var inputValueObject = JSON.parse(inputValue);

		inputValueObject = inputValueObject.filter(function(obj) {
			return obj.src !== thisImageUrl;
		});

		// var index = inputValueObject.indexOf(thisImageUrl);
		// if (index > -1) {
		// 	inputValueObject.splice(index, 1);
		// }

		inputValue = JSON.stringify(inputValueObject);
		$('#_tdy_pa_photos_meta').val(inputValue);

		$(this).parent().remove();
	});


	jQuery('.datepicker').datepicker({
		dateFormat: 'DD, d MM, yy'
	});


}); // End of DOM Ready

})(jQuery);