<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "members".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $user_id
 * @property integer $status
 *
 * @property Groups $group
 * @property User $user
 */
class Members extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'members';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'user_id', 'status'], 'required'],
            [['group_id', 'user_id', 'status'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['group_id' => 'group_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ участника',
            'group_id' => '№ группы',
            'user_id' => '№ пользователя',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['group_id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public static function findStatus($id, $uid)
    {
        return static::findOne(['group_id' => $id, 'user_id' => $uid]);
    }

}
