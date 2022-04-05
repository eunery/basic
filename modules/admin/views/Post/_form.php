<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'head')->textInput(['maxlength' => true]) ?>

<!--    $form->field($model, 'category_id')->dropDownList( \app\models\Category::getCategories(), ['class'=>'form-control']) -->

<!--    $form->field($model, 'author')->textInput(['maxlength' => true])-->
<!---->
<!--    $form->field($model, 'status')->textInput()-->
<!---->
<!--    $form->field($model, 'user')->textInput()-->


<!--    $form->field($model, 'image')->textInput()-->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
