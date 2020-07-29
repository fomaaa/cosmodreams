<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Masks $model
 */

$this->title = 'Создать маску';
$this->params['breadcrumbs'][] = ['label' => 'Маски', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masks-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
