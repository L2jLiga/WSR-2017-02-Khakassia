<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile col-md-6 col-lg-6">
	<h2>Добавление экскурсии:</h2>
	
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'attributes' => ['enctype' =>"multipart/form-data"]]); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'description')->TextArea(); ?>

                <?= $form->field($model, 'conditions')->TextArea(); ?>

                <?= $form->field($model, 'date')->textInput(['type' => 'date']); ?>

                <?= $form->field($model, 'members')->textInput(); ?>

                <?= $form->field($model, 'cost')->textInput(); ?>

                <?= $form->field($model, 'images[]')->fileInput(['multiple' => 'true', 'accept'=> "image/*"]); ?>

                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
</div>
