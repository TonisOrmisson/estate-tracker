<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provider".
 *
 * @property integer $provider_id
 * @property string $name
 * @property string $url
 * @property integer $active
 * @property string $locator_options
 * @property string $comment
 *
 * @property Item[] $items
 * @property Parse[] $parses
 */
class Provider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'locator_options' ], 'required'],
            [['active'], 'integer'],
            [['comment'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['url'], 'string', 'max' => 512],
            [['locator_options'], 'string', 'max' => 1024*2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'provider_id' => Yii::t('app', 'Provider ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Base Url including the {itemKey} tag'),
            'active' => Yii::t('app', 'Active'),
            'locator_options' => Yii::t('app', 'The locator to identify the main content in item listing'),
            'comment' => Yii::t('app', 'comments'),
        ];
    }

    /* @inheritdoc */
    public function getOptionVars()
    {
        return [
            'contentClass'=>[
                'label' => Yii::t('app','Item main content class name'),
            ],
            'priceClass'=>[
                'label' => Yii::t('app','Price element class name'),
            ],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['provider_id' => 'provider_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParses()
    {
        return $this->hasMany(Parse::className(), ['provider_id' => 'provider_id']);
    }
}
