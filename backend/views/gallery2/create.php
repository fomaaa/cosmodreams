<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Gallery2 $model
 */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Галерея №2', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery2-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
