<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\TermManagement\modules\TermBase\Term */

$this->title = t('app', 'Save As New {modelClass}: ', [
    'modelClass' => 'Term',
]). ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Term'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = t('app', 'Save As New');
?>
<div class="term-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
