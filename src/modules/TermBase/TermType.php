<?php

namespace thienhungho\TermManagement\modules\TermBase;

use Yii;
use \thienhungho\TermManagement\modules\TermBase\base\TermType as BaseTermType;

/**
 * This is the model class for table "term_type".
 */
class TermType extends BaseTermType
{
    /**
     * @return array
     */
    public function behaviors()
    {
        parent::behaviors();
        return [
            [
                'class'         => 'yii\behaviors\SluggableBehavior',
                'attribute'     => 'name',
                'immutable'     => true,
                'ensureUnique'  => true,
                'slugAttribute' => 'slug',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'slug'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['slug'], 'unique'],
        ]);
    }
	
}
