<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

use yii\bootstrap4\Modal;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \yii\db\ActiveRecord
 * @var $attribute string
 * @var $imageId string
 * @var $previewImageUrl string
 * @var $extensionOptions array
 * @var $modalId string
 * @var $inputImageId string id of image input field
 * @var $cropperOptions string json options for cropperjs
 * @var $cropButtonId string id of Crop button
 * @var $previewImageId string
 * @var $thisId string
 */

echo Html::activeHiddenInput($model, $attribute);
?>
    <div class="cropper-wrapper clearfix">
        <div class="cropper-preview">
            <div class="cropper-preview-img">
                <?= Html::img(
                    $previewImageUrl,
                    [
                        'id' => $previewImageId,
                        'width' => $extensionOptions['preview']['width'],
                        'height' => $extensionOptions['preview']['height'],
                        'alt' => 'cropper image preview'
                    ]
                ) ?>
            </div>
            <div class="cropper-preview-buttons">
                <?php
                echo Html::button(
                    $extensionOptions['changeButtonText'],
                    [
                        'class' => 'btn btn-primary',
                        'type' => 'button',
                        'data-toggle' => 'modal',
                        'data-target' => '#' . $modalId
                    ]
                );
                ?>
            </div>
        </div>
    </div>
<?php
Modal::begin([
    'id' => $modalId,
    'class' => 'modal fade',
    'title' => 'Cropping the Image',
    'footer' => Html::button(
            $extensionOptions['cropButtonText'],
            [
                'id' => $cropButtonId,
                'class' => 'btn btn-primary'
            ]
        ) .
        Html::button(
            $extensionOptions['closeButtonText'],
            [
                'class' => 'btn btn-secondary',
                'data-dismiss' => 'modal'
            ]
        )
    ,
    'size' => Modal::SIZE_LARGE
]);
?>
    <div class="input-group cropper-browse-group">
            <span class="input-group-btn cropper-input-group-btn">
                <span class="btn btn-primary btn-file">
                    <?= $extensionOptions['browseButtonText'] ?> <input type="file" id="<?= $inputImageId ?>">
                </span>
            </span>
        <input type="text" class="form-control" disabled="disabled">
    </div>
<?php
echo Html::tag(
    'div',
    Html::img('#', [
        'id' => $imageId,
        'class' => 'sabirov-cropper-image',
        'alt' => 'Upload a picture',
    ])
);

echo Html::tag(
    'div',
    $extensionOptions['cropperWarningText'],
    [
        'class' => 'alert alert-warning cropper-warning'
    ]
);

Modal::end();

/* add java script */
$js = <<<JS
(function ($) {
    let cropper;
    const cropperOptions = '$cropperOptions';
    const cropperOptionsObj = JSON.parse(cropperOptions);
    const inputImageId = '#'+'$inputImageId';
    const modalId = '#' + '$modalId';
    const imageId = '#'+'$imageId';
    const cropButtonId = '#'+'$cropButtonId';
    const previewImageId = '#' + '$previewImageId';
    const thisId = '#'+'$thisId';

    $(document).on('change', inputImageId, function () {
        const input = $(this);
        let label = input.val().replace(/^.*[\\\/]/, '');
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
        if (typeof (cropper) !== 'undefined') {
            cropper.destroy();
        }

        $(imageId).attr('src', null);
        $(modalId + ' .cropper-browse-group .form-control').val(null);
        $('.cropper-warning').hide();
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
JS;

Yii::$app->view->registerJs($js, $this::POS_LOAD, 'sabirov-cropper-' . $thisId);

