<?php

namespace thienhungho\TermManagement\modules\TermBase\query;

/**
 * This is the ActiveQuery class for [[TermRelationships]].
 *
 * @see TermRelationships
 */
class TermRelationshipsQuery extends \thienhungho\ActiveQuery\models\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TermRelationships[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TermRelationships|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
