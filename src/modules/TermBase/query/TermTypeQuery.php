<?php

namespace thienhungho\TermManagement\modules\TermBase\query;

/**
 * This is the ActiveQuery class for [[TermType]].
 *
 * @see TermType
 */
class TermTypeQuery extends \thienhungho\ActiveQuery\models\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TermType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TermType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
