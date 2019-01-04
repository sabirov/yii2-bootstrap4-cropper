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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
            setTimeout(initCropper, 1000);
        }
    }
    function initCropper(){
        console.log("Came here")
        var image = document.getElementById('blah');
        var cropper = new Cropper(image, {
            aspectRatio: 1 / 1,
            crop: function(e) {
                console.log(e.detail.x);
                console.log(e.detail.y);
            }
        });

        // On crop button clicked
        document.getElementById('crop_button').addEventListener('click', function(){
            var imgurl =  cropper.getCroppedCanvas().toDataURL();
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
    // let image = $(sabirovCropperImageId)[0];
    // if (image) {
    //     const cropper = new Cropper(image, {
    //         aspectRatio: 16 / 9,
    //         crop(event) {
    //             console.log(event.detail.x);
    //             console.log(event.detail.y);
    //             console.log(event.detail.width);
    //             console.log(event.detail.height);
    //             console.log(event.detail.rotate);
    //             console.log(event.detail.scaleX);
    //             console.log(event.detail.scaleY);
    //         },
    //     });
    // }
    //
    // $("button[data-toggle='modal']").on('click', function () {
    //     const modalId = '#' + $(this).data('target');
    //     $(modalId).modal('show');
    // });
})(jQuery);