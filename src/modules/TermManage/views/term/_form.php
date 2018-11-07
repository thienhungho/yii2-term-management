<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

if (empty($model->author)) {
    $model->author = Yii::$app->user->id;
}
if (empty($model->language)) {
    $model->language = get_primary_language();
}
if (empty($model->term_type)) {
    $model->term_type = request()->get('type', 'category');
}
if (empty($model->id)) {
    $model->id = 0;
}

?>

<div class="row term-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <div class="col-lg-9 col-xs-12">

        <?= $form->field($model, 'name', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-edit"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Name'),
        ]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'feature_img')->fileInput()
            ->widget(\kartik\file\FileInput::classname(), [
                'options'       => ['accept' => 'image/*'],
                'pluginOptions' => empty($model->feature_img) ? [] : [
                    'initialPreview'       => [
                        '/' . $model->feature_img,
                    ],
                    'initialPreviewAsData' => true,
                    'initialCaption'       => $model->feature_img,
                    'overwriteInitial'     => true,
                ],
            ]);
        ?>
    </div>

    <div class="col-lg-3 col-xs-12">
        <?= $form->field($model, 'author', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(\common\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
            'options'       => ['placeholder' => t('app', 'Choose User')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]); ?>

        <?= $form->field($model, 'term_parent', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-copy"></span>']],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(\thienhungho\TermManagement\modules\TermBase\Term::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
            'options'       => ['placeholder' => t('app', 'Term Parent')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]); ?>

        <?php
        if (is_enable_multiple_language()) {
            echo language_select_input($form, $model, 'language');
            echo $form->field($model, 'assign_with', [
                'addon' => ['prepend' => ['content' => '<span class="fa fa-paperclip"></span>']],
            ])->widget(\kartik\widgets\Select2::classname(), [
                'data'          => \yii\helpers\ArrayHelper::map(\thienhungho\TermManagement\modules\TermBase\Term::find()->orderBy('id')->where(['assign_with' => 0])->andWhere(['term_type' => $model->term_type])->andWhere(['!=' , 'id', $model->id])->andWhere(['<>','id', $model->primaryKey])->andWhere(['<>','language', $model->language])->asArray()->all(), 'id', 'name'),
                'options'       => ['placeholder' => t('app', 'Assign With')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);
        }
        ?>

    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
                <?= Html::submitButton($model->isNewRecord ? t('app', 'Create') : t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?><?php endif; ?><?php if (Yii::$app->controller->action->id != 'create'): ?>
                <?= Html::submitButton(t('app', 'Save As New'), [
                    'class' => 'btn btn-info',
                    'value' => '1',
                    'name'  => '_asnew',
                ]) ?><?php endif; ?>
            <?= Html::a(t('app', 'Cancel'), request()->referrer, ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
