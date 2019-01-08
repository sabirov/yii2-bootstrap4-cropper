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
 */

(function ($) {
    const browseSelector = '.btn-file :file';
    let cropper;
    const cropperOptionsObj = JSON.parse(cropperOptions);

    // console.log(cropperOptionsObj);

    $(document).on('change', browseSelector, function () {
        const input = $(this);
        let label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $(browseSelector).on('fileselect', function (event, label) {
        let input = $(this).parents('.input-group').find(':text');

        if (input.length) {
            input.val(label);
        } else {
            if (label) alert(label);
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (event) {
                $(imageId).attr('src', event.target.result);
                initCropper();
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(inputImageId).on('change', function () {
        readURL(this);
    });

    function initCropper() {
        if (typeof (cropper) !== 'undefined') {
            cropper.destroy();
        }

        const image = $(imageId)[0];
        /* add Cropper events*/
        image.addEventListener('crop', (event) => {
            console.log(event.detail.x);
            console.log(event.detail.y);
            console.log(event.detail.width);
            console.log(event.detail.height);
            console.log(event.detail.rotate);
            console.log(event.detail.scaleX);
            console.log(event.detail.scaleY);
        });
        /* initialize Cropper */
        cropper = new Cropper(
            image,
            cropperOptionsObj
        );

        $('.cropper-warning').show();
        $('body').scrollTo(imageId);

        // On crop button clicked
        document.getElementById('crop_button').addEventListener('click', function () {
            var imgurl = cropper.getCroppedCanvas().toDataURL();
            var img = document.createElement("img");
            img.src = imgurl;
            document.getElementById("cropped_result").appendChild(img);

            /* ---------------- SEND IMAGE TO THE SERVER-------------------------

                cropper.getCroppedCanvas().toBlob(function (blob) {
                      var formData = new FormData();
                      formData.append('croppedImage', blob);
                      // Use `jQuery.ajax` method
                      $.ajax('/path/to/upload', {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function () {
                          console.log('Upload success');
                        },
                        error: function () {
                          console.log('Upload error');
                        }
                      });
                });
            ----------------------------------------------------*/
        })
    }

    $("button[data-toggle='modal']").on('click', function () {
        const modalId = '#' + $(this).data('target');
        $(modalId).modal('show');
    });
})(jQuery);