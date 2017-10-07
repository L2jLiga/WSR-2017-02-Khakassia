<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $image
 *
 * @property Groups $group
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'image'], 'required'],
            [['group_id'], 'integer'],
            [['image'], 'string', 'max' => 1024],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['group_id' => 'group_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['group_id' => 'group_id']);
    }
}
