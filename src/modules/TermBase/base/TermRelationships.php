<?php

namespace thienhungho\TermManagement\modules\TermBase\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "{{%term_relationships}}".
 *
 * @property integer $id
 * @property integer $term_id
 * @property string $term_type
 * @property integer $obj_id
 * @property string $obj_type
 *
 * @property \thienhungho\TermManagement\modules\TermBase\Term $term
 */
class TermRelationships extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'term'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term_id', 'term_type', 'obj_id', 'obj_type'], 'required'],
            [['term_id', 'obj_id'], 'integer'],
            [['term_type', 'obj_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%term_relationships}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'term_id' => Yii::t('app', 'Term ID'),
            'term_type' => Yii::t('app', 'Term Type'),
            'obj_id' => Yii::t('app', 'Obj ID'),
            'obj_type' => Yii::t('app', 'Obj Type'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(\thienhungho\TermManagement\modules\TermBase\Term::className(), ['id' => 'term_id']);
    }

    /**
     * @return \thienhungho\TermManagement\modules\TermBase\query\TermRelationshipsQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \thienhungho\TermManagement\modules\TermBase\query\TermRelationshipsQuery(get_called_class());
    }
}
