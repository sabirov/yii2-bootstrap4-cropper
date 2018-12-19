<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

/**
 * @var $this \yii\web\View
 */
?>
    <div class="cropper-wrapper clearfix">
        <img id="image" src="img/demo/profile3.jpg">
    </div>
<?php
$passVariables = <<<JS
const test = 'test';
JS;

Yii::$app->view->registerJs($passVariables, $this::POS_HEAD);
