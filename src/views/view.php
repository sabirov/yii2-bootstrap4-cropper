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
use yii\helpers\Json;

/**
 * @var $this \yii\web\View
 * @var $model \yii\db\ActiveRecord
 * @var $attribute string
 * @var $imageId string
 * @var $previewImageUrl string
 * @var $extensionOptions array
 * @var $modalId string
 * @var $inputImageId string id of image input field
 * @var $cropperOptions array options for cropperjs
 * @var $cropButtonId string id of Crop button
 * @var $previewImageId string
 * @var $thisId string
 */

$cropperOptions = Json::encode($cropperOptions);

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
                    'Change',
                    [
                        'class' => 'btn btn-primary',
                        'type' => 'button',
                        'data-toggle' => 'modal',
                        'data-target' => $modalId
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
            'Crop',
            [
                'id' => $cropButtonId,
                'class' => 'btn btn-primary'
            ]
        ) .
        Html::button(
            'Close',
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
    'Double-click to switch between moving the image and selecting the cropping area.',
    [
        'class' => 'alert alert-warning cropper-warning'
    ]
);

Modal::end();

/* passing variables to JS */
$passVariables = <<<JS
const inputImageId = '#'+'$inputImageId';
const imageId = '#'+'$imageId';
const cropperOptions = '$cropperOptions';
const cropButtonId = '#'+'$cropButtonId';
const modalId = '#' + '$modalId';
const previewImageId = '#' + '$previewImageId';
const thisId = '#' + ' $thisId ';
JS;
Yii::$app->view->registerJs($passVariables, $this::POS_HEAD);
