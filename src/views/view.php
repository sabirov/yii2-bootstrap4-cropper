<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

use sabirov\cropper\assets\CropperAsset;
use sabirov\cropper\assets\InitCropperAsset;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $imageId string
 */

$cropper_asset = CropperAsset::register($this);
InitCropperAsset::register($this);

$img_src = $cropper_asset->baseUrl . '/img/no-image.svg';

echo Html::img($img_src, [
    'id' => $imageId,
    'class' => 'cropper-image'
]);

/* passing variables to JS */
$passVariables = <<<JS
const imageId = '#$imageId';
JS;
Yii::$app->view->registerJs($passVariables, $this::POS_HEAD);
