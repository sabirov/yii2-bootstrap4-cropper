<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

namespace sabirov\cropper\assets;

use yii\web\AssetBundle;

class InitCropperAsset extends AssetBundle
{
    public $sourcePath = '@vendor/sabirov/yii2-cropper/assets/';
    public $css = [];
    public $js = [
        'js/initializeCropper.js'
    ];
    public $depends = [
        'sabirov\cropper\assets\CropperAsset',
    ];
}