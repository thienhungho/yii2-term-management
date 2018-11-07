<?php

namespace thienhungho\TermManagement\modules\TermBase\base;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "{{%term}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $author
 * @property string $feature_img
 * @property integer $term_parent
 * @property string $term_type
 * @property string $language
 * @property integer $assign_with
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \thienhungho\TermManagement\modules\TermBase\User $author0
 * @property \thienhungho\TermManagement\modules\TermBase\TermRelationships[] $termRelationships
 */
class Term extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'author0',
            'termRelationships'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['description'], 'string'],
            [['author', 'term_parent', 'assign_with', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'feature_img', 'term_type', 'language'], 'string', 'max' => 255],
            [['slug'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%term}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'description' => Yii::t('app', 'Description'),
            'author' => Yii::t('app', 'Author'),
            'feature_img' => Yii::t('app', 'Feature Img'),
            'term_parent' => Yii::t('app', 'Term Parent'),
            'term_type' => Yii::t('app', 'Term Type'),
            'language' => Yii::t('app', 'Language'),
            'assign_with' => Yii::t('app', 'Assign With'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTermRelationships()
    {
        return $this->hasMany(\thienhungho\TermManagement\modules\TermBase\TermRelationships::className(), ['term_id' => 'id']);
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
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @return \thienhungho\TermManagement\modules\TermBase\query\TermQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \thienhungho\TermManagement\modules\TermBase\query\TermQuery(get_called_class());
    }
}
