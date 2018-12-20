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
     *  preview =
     *      [
     *          url => 'path/to/preview', // if not specified get from model attribute
     *          width => '100px', // may be with 'px', '%' and without any, by default '100px'
     *          height => '100px' // may be with 'px', '%' and without any, by default '100px'
     *      ]
     *
     * @var array $cropperOptions
     */
    public $cropperOptions = [];

    private $assetBaseUrl;

    /**
     * Initializes the widget.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        CropperAsset::register($this->view);
        $initCropperAsset = InitCropperAsset::register($this->view);

        $this->assetBaseUrl = $initCropperAsset->baseUrl;
        $this->settingCropperOptions();
    }

    public function run()
    {
        $imageId = 'cropper-img-' . $this->options['id'];

        return $this->render('view', [
            'imageId' => $imageId,
            'cropperOptions' => $this->cropperOptions
        ]);
    }

    private function settingCropperOptions()
    {
        $options = $this->cropperOptions;
        $adjustedOptions = [];

        /* preview options */
        if (isset($options['preview']) && !empty($options['preview'])) {
            $preview_arr = [];

            if (isset($options['preview']['url']) && !empty($options['preview']['url'])) {
                $preview_arr['url'] = $options['preview']['url'];
            } elseif (isset($this->value) && !empty($this->value)) {
                $preview_arr['url'] = $this->value;
            } else {
                $preview_arr['url'] = $this->assetBaseUrl . '/img/no-image.svg';
            }

            if (isset($options['preview']['width']) && !empty($options['preview']['width'])) {
                $width = preg_replace('/\s+/', '', $options['preview']['width']);

                if (stripos($width, 'px') === false && stripos($width, '%') === false) {
                    $width .= 'px';
                }
                $preview_arr['width'] = $width;
            } else {
                $preview_arr['width'] = '100px';
            }

            if (isset($options['preview']['height']) && !empty($options['preview']['height'])) {
                $height = preg_replace('/\s+/', '', $options['preview']['height']);

                if (stripos($height, 'px') === false && stripos($height, '%') === false) {
                    $height .= 'px';
                }
                $preview_arr['height'] = $height;
            } else {
                $preview_arr['height'] = '100px';
            }

            $adjustedOptions['preview'] = $preview_arr;
        } else {
            $adjustedOptions['preview'] = [
                'url' => $this->assetBaseUrl . '/img/no-image.svg',
                'width' => '100px',
                'height' => '100px'
            ];
        }

        $this->cropperOptions = $adjustedOptions;
    }
}