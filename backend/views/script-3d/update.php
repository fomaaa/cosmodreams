<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Script3d $model
 */

$this->title = 'Обновить: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '3д сценарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="script3d-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
