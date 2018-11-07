<?php
/* @var $this yii\web\View */
/* @var $searchModel thienhungho\TermManagement\modules\TermManage\search\TermSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use yii\helpers\Html;

$term_type_name = $term_type->name;
$this->title = t('app', 'Term') . ' - ' . t('app', $term_type_name);
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>

<div class="term-index-head">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-10">
            <p>
                <?= Html::a(t('app', 'Create New'), [
                    'create',
                    'type' => $term_type_name,
                ], ['class' => 'btn btn-success']) ?>
                <?= Html::a(t('app', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']) ?>
            </p>
        </div>
        <div class="col-lg-2">
            <?php backend_per_page_form() ?>
        </div>
    </div>
    <div class="search-form" style="display:none">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>
</div>

<div class="term-index">
    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        grid_checkbox_column(),
        [
            'class'         => 'kartik\grid\ExpandRowColumn',
            'width'         => '50px',
            'value'         => function($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail'        => function($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,
        ],
        [
            'attribute' => 'id',
            'visible'   => false,
        ],
        [
            'class'     => \yii\grid\DataColumn::className(),
            'format'    => 'raw',
            'attribute' => 'feature_img',
            'value'     => function($model, $key, $index, $column) {
                return Html::a(
                    '<img style="max-width: 50px;" src=/' . $model->feature_img . '>',
                    \yii\helpers\Url::to([
                        '/term-manage/term/view',
                        'id' => $model->id,
                    ]), [
                        'data-pjax' => '0',
                        'target'    => '_blank',
                    ]
                );
            },
        ],
        [
            'class'     => \yii\grid\DataColumn::className(),
            'format'    => 'raw',
            'attribute' => 'name',
            'value'     => function($model, $key, $index, $column) {
                return Html::a(
                    $model->name,
                    \yii\helpers\Url::to([
                        '/term-manage/term/view',
                        'id' => $model->id,
                    ]), [
                        'data-pjax' => '0',
                        'target'    => '_blank',
                    ]
                );
            },
        ],
        [
            'attribute'           => 'author',
            'label'               => t('app', 'Author'),
            'value'               => function($model) {
                if ($model->author0) {
                    return $model->author0->username;
                } else {
                    return null;
                }
            },
            'filterType'          => GridView::FILTER_SELECT2,
            'filter'              => \yii\helpers\ArrayHelper::map(
                \common\models\User::find()
                    ->asArray()
                    ->all(), 'id', 'username'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'User'),
                'id'          => 'grid-term-search-author',
            ],
        ],
        [
            'attribute'           => 'term_parent',
            'label'               => t('app', 'Term Parent'),
            'value'               => function($model) {
                if ($model->term_parent) {
                    return $model->term_parent;
                } else {
                    return null;
                }
            },
            'filterType'          => GridView::FILTER_SELECT2,
            'filter'              => \yii\helpers\ArrayHelper::map(
                \thienhungho\TermManagement\modules\TermBase\Term::find()
                    ->where(['term_type' => $term_type_name])
                    ->asArray()
                    ->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'Term'),
                'id'          => 'grid-term-search-term',
            ],
        ],
    ];
    ?>

    <?php
    if (is_enable_multiple_language()) {
        $gridColumn[] = grid_language_column();
        $gridColumn[] = [
            'attribute'           => 'assign_with',
            'label'               => t('app', 'Assign With'),
            'value'               => function($model) {
                if ($model->assign_with) {
                    return $model->assign_with;
                } else {
                    return null;
                }
            },
            'filterType'          => GridView::FILTER_SELECT2,
            'filter'              => \yii\helpers\ArrayHelper::map(\thienhungho\TermManagement\modules\TermBase\Term::find()->where(['assign_with' => 0])->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions'  => [
                'placeholder' => t('app', 'Term'),
                'id'          => 'grid-post-search-assign-with',
            ],
        ];
    }
    /**
     * Active Button
     */
    $gridColumn[] = grid_view_default_active_column_cofig();
    ?>

    <?= GridView::widget([
        'dataProvider'   => $dataProvider,
        'filterModel'    => $searchModel,
        'columns'        => $gridColumn,
        'condensed'      => true,
        'responsiveWrap' => false,
        'pjax'           => true,
        'pjaxSettings'   => ['options' => ['id' => 'kv-pjax-container-term']],
        'panel'          => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        'toolbar'        => grid_view_toolbar_config($dataProvider, $gridColumn),
    ]); ?>

    <div class="row">
        <div class="col-lg-2">
            <?= \kartik\widgets\Select2::widget([
                'name'    => 'action',
                'data'    => [
                    ACTION_DELETE => t('app', 'Delete'),
                ],
                'theme'   => \kartik\widgets\Select2::THEME_BOOTSTRAP,
                'options' => [
                    'multiple'    => false,
                    'placeholder' => t('app', 'Bulk Actions ...'),
                ],
            ]); ?>
        </div>
        <div class="col-lg-10">
            <?= Html::submitButton(t('app', 'Apply'), [
                'class'        => 'btn btn-primary',
                'data-confirm' => t('app', 'Are you want to do this?'),
            ]) ?>
        </div>
    </div>

</div>
