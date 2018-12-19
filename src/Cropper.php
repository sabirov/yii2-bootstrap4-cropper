<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 15.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       15.12.18
 */

namespace sabirov\cropper;

use yii\widgets\InputWidget;
use sabirov\cropper\assets\CropperAsset;
use sabirov\cropper\assets\InitCropperAsset;

class Cropper extends InputWidget
{
    /**
     * @var bool $modal Show crop box in modal window
     */
    public $modal = false;

    /**
     * Initializes the widget.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        CropperAsset::register($this->getView());
        InitCropperAsset::register($this->getView());
    }

    public function run()
    {
        if($this->modal){
            return $this->render('modal', []);
        } else {
            return $this->render('view',[]);
        }
    }
}