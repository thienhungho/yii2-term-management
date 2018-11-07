<?php

namespace thienhungho\TermManagement\modules\TermBase\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Class TermType
 * @package thienhungho\TermManagement\modules\TermBase\base
 */
class TermType extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'terms',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%term_type}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this->hasMany(\thienhungho\TermManagement\modules\TermBase\Term::className(), ['term_type' => 'name']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return \thienhungho\TermManagement\modules\TermBase\query\TermTypeQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \thienhungho\TermManagement\modules\TermBase\query\TermTypeQuery(get_called_class());
    }
}
