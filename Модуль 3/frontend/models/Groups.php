<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "groups".
 *
 * @property integer $group_id
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property string $conditions
 * @property string $date
 * @property integer $members
 * @property integer $cost
 *
 * @property User $user
 * @property Images[] $images
 * @property Members[] $members0
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'description', 'conditions', 'date', 'members', 'cost'], 'required'],
            [['user_id', 'members', 'cost'], 'integer'],
            [['description', 'conditions'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['date'], 'string', 'max' => 30],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => '№ экскурсии',
            'user_id' => 'ID создателя',
            'name' => 'Название экскурсии',
            'description' => 'Описание',
            'conditions' => 'Требования к участникам',
            'date' => 'Дата проведения',
            'members' => 'Количество участников',
            'cost' => 'Стоимость',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::className(), ['group_id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembers0()
    {
        return $this->hasMany(Members::className(), ['group_id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemb()
    {
        return $this->hasMany(Members::className(), ['group_id' => 'group_id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['group_id' => $id]);
    }
}
