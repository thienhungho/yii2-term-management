<?php

namespace thienhungho\TermManagement\modules\TermBase;

use Yii;
use \thienhungho\TermManagement\modules\TermBase\base\TermRelationships as BaseTermRelationships;

/**
 * This is the model class for table "term_relationships".
 */
class TermRelationships extends BaseTermRelationships
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['term_id', 'term_type', 'obj_id', 'obj_type'], 'required'],
            [['term_id', 'obj_id'], 'integer'],
            [['term_type', 'obj_type'], 'string', 'max' => 255]
        ]);
    }
	
}
