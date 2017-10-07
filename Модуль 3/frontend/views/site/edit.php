<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile col-md-6 col-lg-6">
	<h2>Профиль пользователя <?= $user->username; ?></h2>
    
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($userInfo, 'name')->textInput() ?>

                <?= $form->field($userInfo, 'genre')->dropDownList(['Я молодой человек', 'Я юная леди']) ?>

                <?= $form->field($userInfo, 'phone')->textInput() ?>

                <?= $form->field($userInfo, 'about')->textArea() ?>

                <div class="form-group">
                    <?= Html::submitButton('Отредактировать', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
</div>