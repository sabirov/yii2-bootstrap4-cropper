/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 *
 * @param {string} imageId
 * @param {string} modalId
 */

/*----------------------------------------
        Document Ready
    ----------------------------------------*/
document.addEventListener('DOMContentLoaded', () => {
/*const image = document.getElementById(imageId);
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
}*/

    document.querySelectorAll("[data-toggle='modal']").onclick = function(){
        console.log(modalId);
    };

//
// $(document).ready(function() {
//     // При клике по кнопке, с id="btnModal"
//     $(".btn-primary").click(function() {
//         console.log(modalId);
//         modalId = '#' + modalId;
//         // Открыть модальное окно с id="exampleModal"
//         $(modalId).modal('show');
//     });
// });
});