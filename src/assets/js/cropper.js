/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 *
 * @param {string} inputImageId id of image input field
 * @param {string} imageId id of cropper image
 * @param {string} cropperOptions json encode cropper options
 * @param {string} cropButtonId id of Crop button
 * @param {string} modalId
 * @param {string} previewImageId
 * @param {string} thisId id of active form input field
 */

(function ($, inputImageId, imageId, cropperOptions, cropButtonId, modalId, previewImageId, thisId) {
    let cropper;
    const cropperOptionsObj = JSON.parse(cropperOptions);

    $(document).on('change', inputImageId, function () {
        const input = $(this);
        let label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $(inputImageId).on('fileselect', function (event, label) {
        let input = $(this).parents('.input-group').find(':text');

        if (input.length) {
            input.val(label);
        } else {
            if (label) alert(label);
        }
    });

    $(inputImageId).on('change', function () {
        readURL(this);
    });

    $(modalId).on("hidden.bs.modal", function () {
        alert('close');
    });

    const readURL = function (input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (event) {
                $(imageId).attr('src', event.target.result);
                initCropper();
            };

            reader.readAsDataURL(input.files[0]);
        }
    };

    const initCropper = function () {
        if (typeof (cropper) !== 'undefined') {
            cropper.destroy();
        }

        const image = $(imageId)[0];

        /* add Cropper events*/
        /*image.addEventListener('crop', (event) => {
            console.log(event.detail.x);
            console.log(event.detail.y);
            console.log(event.detail.width);
            console.log(event.detail.height);
            console.log(event.detail.rotate);
            console.log(event.detail.scaleX);
            console.log(event.detail.scaleY);
        });*/

        /* initialize Cropper */
        cropper = new Cropper(
            image,
            cropperOptionsObj
        );

        $('.cropper-warning').show();

        /* On crop button click */
        $(cropButtonId).on('click', function () {
            const imgUrl = cropper.getCroppedCanvas().toDataURL();
            $(previewImageId).attr('src', imgUrl);

            cropper.getCroppedCanvas().toBlob((blob) => {
                let reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    const base64data = reader.result;
                    $(thisId).val(base64data);

                    $(modalId).modal('hide');
                }
            });
        });
    }
})(jQuery);