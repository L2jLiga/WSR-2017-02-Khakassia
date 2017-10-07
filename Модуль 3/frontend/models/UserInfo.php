<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property string $name
 * @property integer $genre
 * @property string $phone
 * @property string $about
 * @property integer $role
 *
 * @property User $id0
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'genre'], 'required'],
            [['id', 'genre', 'role'], 'integer'],
            [['about'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 12],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ваши ФИО',
            'genre' => 'Ваш пол:',
            'phone' => 'Ваш номер телефона',
            'about' => 'О себе',
            'role' => 'Роль',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
}
