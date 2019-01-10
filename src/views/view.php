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
            <span class="input-group-btn">
                <span class="btn btn-default btn-file">
                    <?= $extensionOptions['browseButtonText'] ?> <input type="file" id="<?= $inputImageId ?>">
                </span>
            </span>
        <input type="text" class="form-control" readonly>
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

/* passing variables to JS */
$thisIdVar = 'thisId' . $thisId;
$inputImageIdVar = 'inputImageId' . $thisId;
$imageIdVar = 'imageId' . $thisId;
$cropButtonIdVar = 'cropButtonId' . $thisId;
$modalIdVar = 'modalId' . $thisId;
$previewImageIdVar = 'previewImageId' . $thisId;
$cropperOptionsVar = 'cropperOptions' . $thisId;

$passVariables = <<<JS
const $thisIdVar = '#'+'$thisId';
const $inputImageIdVar  = '#'+'$inputImageId';
const $imageIdVar = '#'+'$imageId';
const $cropButtonIdVar = '#'+'$cropButtonId';
const $modalIdVar = '#' + '$modalId';
const $previewImageIdVar = '#' + '$previewImageId';
const $cropperOptionsVar = '$cropperOptions';
JS;
Yii::$app->view->registerJs($passVariables, $this::POS_HEAD);
