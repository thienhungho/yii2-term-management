<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model thienhungho\TermManagement\modules\TermBase\TermType */

$this->title = t('app', 'Create Term Type');
$this->params['breadcrumbs'][] = ['label' => t('app', 'Term Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
