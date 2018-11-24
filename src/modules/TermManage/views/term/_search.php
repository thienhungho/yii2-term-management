<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model thienhungho\TermManagement\modules\TermManage\search\TermSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-term-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'Slug']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\thienhungho\UserManagement\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
        'options' => ['placeholder' => t('app', 'Choose User')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php /* echo $form->field($model, 'feature_img')->textInput(['maxlength' => true, 'placeholder' => 'Feature Img']) */ ?>

    <?php /* echo $form->field($model, 'term_parent')->textInput(['placeholder' => 'Term Parent']) */ ?>

    <?php /* echo $form->field($model, 'term_type')->textInput(['maxlength' => true, 'placeholder' => 'Term Type']) */ ?>

    <?php /* echo $form->field($model, 'language')->textInput(['maxlength' => true, 'placeholder' => 'Language']) */ ?>

    <?php /* echo $form->field($model, 'assign_with')->textInput(['placeholder' => 'Assign With']) */ ?>

    <div class="form-group">
        <?= Html::submitButton(t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
