<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Masks $model
 */

$this->title = 'Обновить: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Маски', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="masks-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
