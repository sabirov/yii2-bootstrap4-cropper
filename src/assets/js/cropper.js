/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 *
 * @param {string} sabirovCropperImageId
 */

(function ($) {
    let image = $(sabirovCropperImageId)[0];
    if (image) {
        const cropper = new Cropper(image, {
            aspectRatio: 16 / 9,
            crop(event) {
                console.log(event.detail.x);
                console.log(event.detail.y);
                console.log(event.detail.width);
                console.log(event.detail.height);
                console.log(event.detail.rotate);
                console.log(event.detail.scaleX);
                console.log(event.detail.scaleY);
            },
        });
    }

    $("button[data-toggle='modal']").on('click', function () {
        const modalId = '#' + $(this).data('target');
        $(modalId).modal('show');
    });
})(jQuery);