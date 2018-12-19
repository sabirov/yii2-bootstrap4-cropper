<?php
/**
 * @author      Dmitriy Sabirov <web8dew@yandex.ru>
 * @copyright   Dmitriy Sabirov 19.12.18
 * @license     MIT
 * @license     https://opensource.org/licenses/MIT
 * @since       19.12.18
 */

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $imageId string
 */

echo Html::img('/img/demo/profile3.jpg', [
        'id' => $imageId
]);

/* passing variables to JS */
$passVariables = <<<JS
const test = 'test';
JS;
Yii::$app->view->registerJs($passVariables, $this::POS_HEAD);
