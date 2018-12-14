<?php

namespace sabirov\bootstrap4_cropper;


use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Ercan Bilgin <bilginnet@gmail.com>
 */
class CropperHeadAsset extends AssetBundle
{
    public $sourcePath = '@sabirov/bootstrap4_cropper/assets';
    public $jsOptions = ['position' => View::POS_HEAD];
    public $css = [
        'cropper.css',
    ];
    public $js = [
        'cropper.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}