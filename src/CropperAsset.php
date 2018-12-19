<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 15.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       15.12.18
 */

namespace sabirov\cropper;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
    public $sourcePath = '@npm';
    public $css = [
        'cropperjs/dist/cropper.min.css'
    ];
    public $js = [
        'cropperjs/dist/cropper.min.js',
        'jquery-cropper/dist/jquery-cropper.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}