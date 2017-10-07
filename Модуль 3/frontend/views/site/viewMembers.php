<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\models\Members;

$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile col-md-12 col-lg-12">
	<h2>Список участников:</h2>
    <?php $i = 1; foreach ($members as $member): ?>
    <?php
        $user = $member->getUser()->one();
        $userInfo = $user->getUserInfo()->one();
    ?>
        <?php echo $i; $i++ ?>. <?= $userInfo->name; ?>
        <br/>Статус: <?php
                $st = Members::findStatus(intval($_GET['id']), $user->id)->status;
                if ($st === 0) {
                    echo "Не подтвержден<br/>";
                    echo Html::a("Подтвердить добавление", ['/site/confirmadd?gr_id=' . intval($_GET['id']) . '&id=' . $user->id]);
                }
                else if( $st == 1)
                {
                    echo "подтвержден";
                }
                else
                {
                    echo "Ожидает удаления<br/>";
                    echo Html::a("Подтвердить удаление", ['/site/confirmdel?gr_id=' . intval($_GET['id']) . '&id=' . $user->id]);
                }
            ?>
            <br />
                    <?= Html::a("Удалить", ['/site/confirmdel?gr_id=' . intval($_GET['id']) . '&id=' . $user->id]); ?>
<hr />
    <?php endforeach;?>
</div>
