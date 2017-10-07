<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\models\Members;

$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile col-md-6 col-lg-6">
	<h2>Профиль пользователя <?= $user->username; ?></h2>
    <p><strong>ФИО: </strong><?= $userInfo->name; ?></p>
    <p><strong>Пол: </strong><?= $userInfo->genre ? "Женский" : "Мужской" ; ?></p>

    <p><strong>Номер телефона: </strong><?= $userInfo->phone ? $userInfo->phone : "Номер телефона не указан"; ?></p>

    <p><strong>О себе: </strong><?= $userInfo->about ? $userInfo->about : "Пользователь не указал информации о себе"; ?></p>

    <p><strong>Роль в сервисе: </strong><?= $userInfo->role ? "Экскурсовод" : "Участник экскурсии" ; ?></p>


    <p><strong>Связаться: </strong><a href="mailto:<?= $user->email; ?>" class="btn btn-success btn-sm"><?= $user->email; ?></a></p>

</div>
<div class="col-md-3 col-lg-3">
	<?= Html::a('Редактировать профиль', ['site/edit']) ?>.

	<h2>Мои экскурсии:</h2>
	<!-- TO DO: список экскурсий в которых принимает участие/создал человек, ссылки ведут на экскурсию, там есть инфа и чат  -->
    <?php foreach ($groups AS $group): ?>
        <hr />
        <p>Название экскурсии: <?= $group->name; ?></p>
        <?php if($userInfo->role): ?>
            <?= Html::a("Изменить", ['site/editgr?id=' . $group->group_id]); ?><br />
            <?= Html::a("Список участников", ['site/memlistgr?id=' . $group->group_id]); ?>
        <?php else: ?>
            Ваш статус: <?php
                switch(Members::findStatus($group->group_id, Yii::$app->user->id)->status)
                {
                    case 0:
                    echo "Не подтвержден";
                    break;

                    case 1:
                    echo "подтвержден";
                    break;

                    case 2:
                    echo "Ожидает удаления";
                    break;
                }
            ?>
            <br/>
            <?= Html::a("Выйти из группы", ['site/leavegr?id=' . $group->group_id]); ?>
        <?php endif; ?>
        <p><?= Html::a('Подробнее', ['site/viewgr?id=' . $group->group_id]) ?></p>
    <?php endforeach; ?> 
</div>