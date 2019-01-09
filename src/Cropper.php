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
use yii\helpers\Html;

class Cropper extends InputWidget
{
    /**
     * if not specified set url to no-image.svg
     *
     * @var string
     */
    public $previewImageUrl;

    /**
     * @var string attribute to save and pass cropper data
     */
    public $cropDataAttribute;

    /**
     *  preview =
     *      [
     *          width => '100px', // may be with 'px', '%' and without any, by default '100px'
     *          height => '100px' // may be with 'px', '%' and without any, by default '100px'
     *      ],
     *  browseButtonText = 'Browse …'
     *
     * @var array
     */
    public $extensionOptions = [];

    /**
     * @see https://github.com/fengyuanchen/cropperjs/blob/master/README.md#options
     * @var array options for cropperjs
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

        if (isset($this->previewImageUrl) && !empty($this->previewImageUrl)) {
            $this->previewImageUrl = trim($this->previewImageUrl);
        } else {
            $this->previewImageUrl = $this->assetBaseUrl . '/img/no-image.svg';
        }

        $this->settingExtensionOptions();
    }

    public function run()
    {
        $thisId = $this->options['id'];
        $imageId = 'cropper-img-' . $thisId;
        $modalId = 'cropper-modal-' . $thisId;
        $inputImageId = 'cropper-input-image-' . $thisId;
        $cropButtonId = 'cropper-crop-btn-' . $thisId;
        $cropDataAttributeId = Html::getInputId($this->model, $this->cropDataAttribute);

        return $this->render('view', [
            'imageId' => $imageId,
            'previewImageUrl' => $this->previewImageUrl,
            'extensionOptions' => $this->extensionOptions,
            'modalId' => $modalId,
            'inputImageId' => $inputImageId,
            'cropperOptions' => $this->cropperOptions,
            'cropButtonId' => $cropButtonId,
            'cropDataAttribute' => $this->cropDataAttribute,
            'cropDataAttributeId' => $cropDataAttributeId
        ]);
    }

    private function settingExtensionOptions()
    {
        $options = $this->extensionOptions;
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

        /* browse button text */
        if (isset($options['browseButtonText']) && !empty($options['browseButtonText'])) {
            $adjustedOptions['browseButtonText'] = trim($options['browseButtonText']);
        } else {
            $adjustedOptions['browseButtonText'] = 'Browse …';
        }

        $this->extensionOptions = $adjustedOptions;
    }
}