<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model thienhungho\TermManagement\modules\TermBase\Term */

?>
<div class="term-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->name) ?></h2>
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
</div>