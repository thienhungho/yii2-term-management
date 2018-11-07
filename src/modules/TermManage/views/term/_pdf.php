<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\TermManagement\modules\TermBase\Term */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Term'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= t('app', 'Term').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
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
        'term_type',
        'language',
        'assign_with',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerTermRelationships->totalCount){
    $gridColumnTermRelationships = [
        ['class' => 'yii\grid\SerialColumn'],         [             'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {                 return ['value' => $data->id];             },         ],
        ['attribute' => 'id', 'visible' => false],
                'term_type',
        'obj_id',
        'obj_type',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerTermRelationships,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(t('app', 'Term Relationships')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnTermRelationships
    ]);
}
?>
    </div>
</div>
