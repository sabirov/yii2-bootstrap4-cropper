Yii2 Bootstrap4 Image Cropper InputWidget 
==========================================

Cropper for Yii2 which uses Bootstrap4.

Wrapper for [cropperjs](https://github.com/fengyuanchen/cropperjs).


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist sabirov/yii2-bootstrap4-cropper "dev-master"
```

or add

```
"sabirov/yii2-bootstrap4-cropper": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

In your model you need to add the following code  :

```php
    public $_avatar;    // variable to get the picture

    public function rules()
    {
        return [
            ['_avatar', 'safe'],    // must be set to "safe"
        ];
    }
    
    public function beforeSave($insert)
    {
        if (is_string($this->_avatar) && strstr($this->_avatar, 'data:image')) {
            $uploadPath = Yii::getAlias('@web') . '/upload';    // set a directory to save picture
            $data = $this->_avatar;
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            $fileName = Yii::$app->security->generateRandomString() . '.png';   // generate picture name
            file_put_contents($uploadPath . DIRECTORY_SEPARATOR . $fileName, $data);
        
            if (!empty($this->avatar)) {    // "avatar" model attribute which stores picture name
                unlink(Yii::getAlias($uploadPath . DIRECTORY_SEPARATOR . $this->avatar));   // delete old picture
            }
            
            $this->avatar = $fileName;  // set new picture name to attribute
        }

        return parent::beforeSave($insert);
    }
```
Simple usage in view file
-----
```php
use sabirov\cropper\Cropper;

$uploadPath = Yii::getAlias('@web') . '/upload';
$img_url = is_null($model->avatar) ? null : $uploadPath . DIRECTORY_SEPARATOR . $model->avatar;

$form = ActiveForm::begin();

echo $form->field($model, '_avatar')->widget(Cropper::class, [
    'previewImageUrl' => $img_url,  // if 'null' set url to no-image.svg
]);

echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

ActiveForm::end();
```

Advanced usage in view file
-----
```php
use sabirov\cropper\Cropper;

$uploadPath = Yii::getAlias('@web') . '/upload';
$img_url = is_null($model->avatar) ? null : $uploadPath . DIRECTORY_SEPARATOR . $model->avatar;

$form = ActiveForm::begin();

echo $form->field($model, '_avatar')->widget(Cropper::class, [
    'previewImageUrl' => $img_url,  // if 'null' set url to no-image.svg
    'extensionOptions' => [
        'preview' => [
            'width' => 270,
            'height' => 270
        ],
        'browseButtonText' => 'Выбрать',
        'cropButtonText' => 'Обрезать',
        'changeButtonText' => 'Изменить',
        'closeButtonText' => 'Закрыть',
        'cropperWarningText' => 'Двойной клик - переключение между перемещением изображения и выбором области обрезки.'
    ],
    'cropperOptions' => [
        'viewMode' => 1,
        'aspectRatio' => 1,
        'minContainerHeight' => 270,
        'minCropBoxHeight' => 270
    ]
]);

echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

ActiveForm::end();
```

**extensionOptions** properties:

| Name     | Description       | Default |  Required   |
| --------|-----------------|-------|------|
|preview| Array consisting of 'width' and 'height' parameters of preview image, may be with 'px', '%' and without any.| [ 'width' => '100px','height' => '300px'] | NO
|browseButtonText|Text in 'browse' button.|'Browse'|NO|
|cropButtonText|Text in 'crop' button.|'Crop'|NO|
|changeButtonText|Text in 'change' button.|'Change'|NO|
|closeButtonText|Text in 'close' button.|'Close'|NO|
|cropperWarningText|Text of warning which displayed below cropped image|'Double-click to switch between moving the image and selecting the cropping area.'|NO|


**cropperOptions** see  [cropperjs options](https://github.com/fengyuanchen/cropperjs/blob/master/README.md#options).