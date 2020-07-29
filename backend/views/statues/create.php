<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Statues $model
 */

$this->title = 'Создание Статуи';
$this->params['breadcrumbs'][] = ['label' => 'Статуи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statues-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
