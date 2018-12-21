<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

use yii\bootstrap4\Modal;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $imageId string
 * @var $imageUrl string
 * @var $cropperOptions array
 * @var $modalId string
 */

$img_src = '/img/demo/profile.jpg';

?>
    <div class="cropper-wrapper clearfix">
        <div class="cropper-preview">
            <div class="cropper-preview-img">
                <?= Html::img(
                    $imageUrl,
                    [
                        'width' => $cropperOptions['preview']['width'],
                        'height' => $cropperOptions['preview']['height'],
                        'alt' => 'cropper image preview'
                    ]
                ) ?>
            </div>
            <div class="cropper-preview-buttons">
                <?php
                //                echo Html::button(
                //                    'Change',
                //                    [
                //                        'class' => 'btn btn-primary',
                //                        'type' => 'button',
                //                        'data-toggle' => 'modal',
                //                        'data-target' => $modalId
                //                    ]
                //                );
                Modal::begin([
                    'id' => $modalId,
                    'toggleButton' => [
                        'tag' => 'button',
                        'class' => 'btn btn-lg btn-block btn-info',
                        'label' => 'Нажмите здесь, забавная штука!',
                    ],
                    'header' => '<h2>Hello world</h2>',
                    'footer' => 'Низ окна',
                ]);

                echo 'Проверка модального окна';

                //echo Html::img($img_src, [
                //    'id' => $imageId,
                //    'class' => 'cropper-image'
                //]);

                Modal::end();
                ?>
            </div>
        </div>
    </div>
<?php
Modal::begin([
    'id' => $modalId,
    'class' => 'modal',
    'header' => '<h2>Hello world</h2>',
    'footer' => 'Низ окна',
]);

echo 'Проверка модального окна';

//echo Html::img($img_src, [
//    'id' => $imageId,
//    'class' => 'cropper-image'
//]);

Modal::end();

/* passing variables to JS */
$passVariables = <<<JS
const imageId = '$imageId';
JS;
Yii::$app->view->registerJs($passVariables, $this::POS_HEAD);
