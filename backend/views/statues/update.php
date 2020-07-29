<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Statues $model
 */

$this->title = 'Обновить статую: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статуи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="statues-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
