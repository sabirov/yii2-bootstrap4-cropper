<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 15.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       15.12.18
 */

namespace sabirov\cropper;

use yii\base\Widget;

class Cropper extends Widget
{
    /** @var bool Show crop box in modal window */
    public $modal = false;

    public function init()
    {
        parent::init();

        CropperAsset::register($this->getView());
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