<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\models\Groups;
use frontend\models\Members;
$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile col-md-12 col-lg-12">
	<h2>Список экскурсий:</h2>
    <?php if(sizeof($groups) == 0): ?>
        <h3>Извините, мы не нашли экскурсий..</h3>
    <?php else: foreach($groups AS $group): ?>
    <div class="col-lg-5 col-lg-offset-1 mx-auto text-left">
        <p><strong>Название экскурсии: </strong><?= $group->name; ?></p>
        <p><strong>Описание экскурсии: </strong><?= $group->description; ?></p>
        <p><strong>Требования к участникам: </strong><?= $group->conditions; ?></p>
        <p><strong>Места:</strong> </p>
        <p><strong>Дата экскурсии: </strong><?= $group->date; ?></p>
        <?= Html::a('Подать заявку', ['/site/exrec?id=' . $group->group_id]); ?>
        <p>Изображения: </p>
        <?php foreach($group->getImages()->all() AS $image): ?>

            <img src="<?=$image->image;?>" class="img-responsive col-lg-8" />
        <?php endforeach; ?>
    </div>
    <?php endforeach; endif;?>
</div>
