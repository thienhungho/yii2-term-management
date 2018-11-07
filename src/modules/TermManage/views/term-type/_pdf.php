<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\TermManagement\modules\TermBase\TermType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Term Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-type-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= t('app', 'Term Type').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerTerm->totalCount){
    $gridColumnTerm = [
        ['class' => 'yii\grid\SerialColumn'],         [             'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {                 return ['value' => $data->id];             },         ],
        ['attribute' => 'id', 'visible' => false],
        'name',
        'slug',
        'description:ntext',
        [
                'attribute' => 'author0.username',
                'label' => t('app', 'Author')
            ],
        'feature_img',
        'term_parent',
                'language',
        'assign_with',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerTerm,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(t('app', 'Term')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnTerm
    ]);
}
?>
    </div>
</div>
