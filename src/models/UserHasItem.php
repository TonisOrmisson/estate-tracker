<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_has_item".
 *
 * @property integer $user_has_item_id
 * @property integer $user_id
 * @property integer $item_id
 * @property integer $user_created
 * @property string $time_created
 * @property integer $active
 *
 * @property Item $item
 * @property User $user
 */
class UserHasItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_has_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'item_id', 'user_created', 'time_created'], 'required'],
            [['user_id', 'item_id', 'user_created', 'active'], 'integer'],
            [['time_created'], 'safe'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::class, 'targetAttribute' => ['item_id' => 'item_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_has_item_id' => Yii::t('app', 'User Has Item ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'user_created' => Yii::t('app', 'User Created'),
            'time_created' => Yii::t('app', 'Time created'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::class, ['item_id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
