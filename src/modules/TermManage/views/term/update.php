<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model thienhungho\TermManagement\modules\TermBase\Term */

$termType = request()->get('type', 'category');

$this->title = t('app', 'Update {modelClass}: ', [
    'modelClass' => $termType,
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => t('app', ucfirst($termType)), 'url' => ['index', 'type' => $termType]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = t('app', 'Update');
?>
<div class="term-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
