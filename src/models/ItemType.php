<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_type".
 *
 * @property int $item_type_id
 * @property string $name
 * @property string $comment comments
 *
 * @property Item[] $items
 */
class ItemType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_type_id' => Yii::t('app', 'Item Type ID'),
            'name' => Yii::t('app', 'Name'),
            'comment' => Yii::t('app', 'comments'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['item_type_id' => 'item_type_id']);
    }
}
