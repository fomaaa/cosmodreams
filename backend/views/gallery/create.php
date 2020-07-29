<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Gallery $model
 */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Галерея №1', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
