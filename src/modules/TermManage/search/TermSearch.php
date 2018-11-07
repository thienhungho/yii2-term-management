<?php

namespace thienhungho\TermManagement\modules\TermManage\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use thienhungho\TermManagement\modules\TermBase\Term;

/**
 * thienhungho\TermManagement\modules\TermManage\search\TermSearch represents the model behind the search form about `thienhungho\TermManagement\modules\TermBase\Term`.
 */
 class TermSearch extends Term
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author', 'term_parent', 'assign_with', 'created_by', 'updated_by'], 'integer'],
            [['name', 'slug', 'description', 'feature_img', 'term_type', 'language', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Term::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author' => $this->author,
            'term_parent' => $this->term_parent,
            'assign_with' => $this->assign_with,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'feature_img', $this->feature_img])
            ->andFilterWhere(['like', 'term_type', $this->term_type])
            ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }
}
