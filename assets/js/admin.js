/**
 * Shoobu Theme - Admin JavaScript
 *
 * Handles WordPress media uploader for product gallery
 *
 * @package Shoobu
 * @version 1.0.0
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        var frame;
        var $container = $('#shoobu-gallery-container');
        var $imagesContainer = $('#shoobu-gallery-images');
        var $addButton = $('#shoobu-add-gallery');

        if (!$container.length) {
            return;
        }

        $addButton.on('click', function(e) {
            e.preventDefault();

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: 'Select Gallery Images',
                button: {
                    text: 'Add to Gallery'
                },
                multiple: true
            });

            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();

                attachments.forEach(function(attachment) {
                    if (imageExists(attachment.id)) {
                        return;
                    }

                    var thumbnailUrl = attachment.sizes && attachment.sizes.thumbnail
                        ? attachment.sizes.thumbnail.url
                        : attachment.url;

                    var $image = $('<div class="shoobu-gallery-image" data-id="' + attachment.id + '">' +
                        '<img src="' + thumbnailUrl + '" alt="">' +
                        '<button type="button" class="remove-image">&times;</button>' +
                        '<input type="hidden" name="shoobu_gallery[]" value="' + attachment.id + '">' +
                        '</div>');

                    $imagesContainer.append($image);
                });
            });

            frame.open();
        });

        $container.on('click', '.remove-image', function(e) {
            e.preventDefault();
            $(this).closest('.shoobu-gallery-image').remove();
        });

        function imageExists(id) {
            return $imagesContainer.find('.shoobu-gallery-image[data-id="' + id + '"]').length > 0;
        }

        if (typeof $.fn.sortable !== 'undefined') {
            $imagesContainer.sortable({
                items: '.shoobu-gallery-image',
                cursor: 'move',
                tolerance: 'pointer',
                opacity: 0.7
            });
        }
    });

})(jQuery);
