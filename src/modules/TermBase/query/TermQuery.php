<?php

namespace thienhungho\TermManagement\modules\TermBase\query;

/**
 * This is the ActiveQuery class for [[Term]].
 *
 * @see Term
 */
class TermQuery extends \thienhungho\ActiveQuery\models\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Term[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Term|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
