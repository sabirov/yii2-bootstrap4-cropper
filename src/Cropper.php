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
     * if not specified set url to no-image.svg
     *
     * @var string $imageUrl
     */
    public $imageUrl;

    /**
     *  preview =
     *      [
     *          width => '100px', // may be with 'px', '%' and without any, by default '100px'
     *          height => '100px' // may be with 'px', '%' and without any, by default '100px'
     *      ],
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

        if (isset($this->imageUrl) && !empty($this->imageUrl)) {
            $this->imageUrl = trim($this->imageUrl);
        } else {
            $this->imageUrl = $this->assetBaseUrl . '/img/no-image.svg';
        }

        $this->settingCropperOptions();
    }

    public function run()
    {
        $thisId = $this->options['id'];
        $imageId = 'cropper-img-' . $thisId;
        $modalId = 'cropper-modal-' . $thisId;

        return $this->render('view', [
            'imageId' => $imageId,
            'imageUrl' => $this->imageUrl,
            'cropperOptions' => $this->cropperOptions,
            'modalId' => $modalId
        ]);
    }

    private function settingCropperOptions()
    {
        $options = $this->cropperOptions;
        $adjustedOptions = [];

        /* preview options */
        if (isset($options['preview']) && !empty($options['preview'])) {
            $preview_arr = [];

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
                'width' => '100px',
                'height' => '100px'
            ];
        }

        $this->cropperOptions = $adjustedOptions;
    }
}