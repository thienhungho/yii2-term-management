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
        <div class="col-sm-8">
            <h2><?= t('app', 'Term').' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
<?=             
             Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . t('app', 'PDF'), 
                ['pdf', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => t('app', 'Will open the generated PDF file in a new window')
                ]
            )?>
<!--            --><?//= Html::a(__t('app', 'Save As New'), ['save-as-new', 'id' => $model->id], ['class' => 'btn btn-info']) ?><!--            -->
            <?= Html::a(t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
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
            'label' => t('app', 'Author'),
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
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-term-relationships']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(t('app', 'Term Relationships')),
        ],
        'columns' => $gridColumnTermRelationships
    ]);
}
?>

    </div>
</div>
