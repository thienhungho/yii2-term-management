<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\TermManagement\modules\TermBase\Term */
$termType = request()->get('type', 'category');

$this->title = t('app', 'Create New');
$this->params['breadcrumbs'][] = ['label' => t('app', ucfirst($termType)), 'url' => ['index', 'type' => $termType]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'termType' => $termType,
    ]) ?>

</div>
