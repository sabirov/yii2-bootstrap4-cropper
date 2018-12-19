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

class Cropper extends InputWidget
{
    /**
     * @var array $cropperOptions
     */
    public $cropperOptions = [];

    /**
     * Initializes the widget.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();


    }

    public function run()
    {
        $imageId = 'cropper-img-' . $this->options['id'];

        return $this->render('view', [
            'imageId' => $imageId
        ]);
    }

    private function setcropperOptions()
    {
        $options = $this->cropperOptions;

        /* preview */
        if (isset($options['preview']) && !empty($options['preview'])) {

        } else {
            $options['preview'] = [];
        }
    }
}