<?php
/**
 * @param $name
 * @param $type
 *
 * @return bool
 */
function is_term($name, $type)
{
    return \thienhungho\TermManagement\modules\TermBase\Term::find()
        ->where(['name' => $name])
        ->andWhere(['term_type' => $type])
        ->exists();
}

/**
 * @param $name
 *
 * @return bool
 */
function is_term_type_name($name)
{
    return \thienhungho\TermManagement\modules\TermBase\TermType::find()
        ->where(['name' => $name])
        ->exists();
}

/**
 * @param $slug
 *
 * @return bool
 */
function is_term_type_slug($slug)
{
    return \thienhungho\TermManagement\modules\TermBase\TermType::find()
        ->where(['slug' => $slug])
        ->exists();
}

/**
 * @param $term_type
 * @param int $limit
 * @param string $language
 *
 * @return array|\thienhungho\TermManagement\modules\TermBase\Term[]|\thienhungho\TermManagement\modules\TermBase\TermQuery
 */
function get_all_term($term_type, $limit = -1, $language = 'current_language')
{
    if ($limit <= 0) {
        if ($language == 'current_language') {
            return \thienhungho\TermManagement\modules\TermBase\Term::find()
                ->where(['term_type' => $term_type])
                ->andWhere(['language' => get_current_client_language()])
                ->asArray()
                ->all();
        } else {
            return \thienhungho\TermManagement\modules\TermBase\Term::find()
                ->where(['term_type' => $term_type])
                ->andWhere(['language' => $language])
                ->asArray()
                ->all();
        }
    } else {
        if ($language == 'current_language') {
            return \thienhungho\TermManagement\modules\TermBase\Term::find()
                ->where(['term_type' => $term_type])
                ->andWhere(['language' => get_current_client_language()])
                ->limit($limit)
                ->asArray()
                ->all();
        } else {
            return \thienhungho\TermManagement\modules\TermBase\Term::find()
                ->where(['term_type' => $term_type])
                ->andWhere(['language' => $language])
                ->limit($limit)
                ->asArray()
                ->all();
        }
    }
}

/**
 * @param $obj_type
 * @param $obj_id
 * @param $term_type
 * @param int $limit
 *
 * @return array
 */
function get_all_term_of_obj($obj_type, $obj_id, $term_type, $limit = -1)
{
    if ($limit <= 0) {
        return \thienhungho\TermManagement\modules\TermBase\TermRelationships::find()
            ->select('term_id')
            ->where(['obj_type' => $obj_type])
            ->andWhere(['obj_id' => $obj_id])
            ->andWhere(['term_type' => $term_type])
            ->asArray()
            ->with('term')
            ->all();
    } else {
        return \thienhungho\TermManagement\modules\TermBase\TermRelationships::find()
            ->select('term_id')
            ->where(['obj_type' => $obj_type])
            ->andWhere(['obj_id' => $obj_id])
            ->andWhere(['term_type' => $term_type])
            ->asArray()
            ->with('term')
            ->limit($limit)
            ->all();
    }
}

/**
 * @param $obj_type
 * @param $obj_id
 * @param $term_type
 * @param int $limit
 *
 * @return mixed
 */
function get_all_term_name_of_obj($obj_type, $obj_id, $term_type, $limit = -1)
{
    if ($limit <= 0) {
        return \yii\helpers\ArrayHelper::getColumn(\yii\helpers\ArrayHelper::getColumn(
            \thienhungho\TermManagement\modules\TermBase\TermRelationships::find()
                ->select('term_id')
                ->where(['obj_type' => $obj_type])
                ->andWhere(['obj_id' => $obj_id])
                ->andWhere(['term_type' => $term_type])
                ->asArray()
                ->with('term')
                ->all(), 'term'), 'name');
    } else {
        return \yii\helpers\ArrayHelper::getColumn(\yii\helpers\ArrayHelper::getColumn(
            \thienhungho\TermManagement\modules\TermBase\TermRelationships::find()
                ->select('term_id')
                ->where(['obj_type' => $obj_type])
                ->andWhere(['obj_id' => $obj_id])
                ->andWhere(['term_type' => $term_type])
                ->asArray()
                ->with('term')
                ->limit($limit)
                ->all(), 'term'), 'name');
    }
}

/**
 * @param $term_type
 * @param array $terms
 * @param $obj_type
 * @param $obj_id
 *
 * @return bool
 */
function create_term_relationships($term_type, $terms = [], $obj_type, $obj_id)
{
    if (is_term_type_name($term_type)) {
        if (!empty($terms) && is_array($terms)) {
            foreach ($terms as $termName) {
                $term = new \thienhungho\TermManagement\modules\TermBase\Term([
                    'term_type' => $term_type,
                    'name'      => $termName,
                ]);
                if (!is_term($termName, $term_type)) {
                    $term->save();
                }
                $term = \thienhungho\TermManagement\modules\TermBase\Term::find()
                    ->select(['id', 'term_type',])
                    ->where(['term_type' => $term_type])
                    ->andWhere(['name' => $termName])
                    ->one();
                $termRelationships = new \thienhungho\TermManagement\modules\TermBase\TermRelationships([
                    'term_id'   => $term->primaryKey,
                    'term_type' => $term->term_type,
                    'obj_type'  => $obj_type,
                    'obj_id'    => $obj_id,
                ]);
                $termRelationships->save();
            }
        }
    }

    /**
     * Must be update in future
     */
    return true;
}

/**
 * @param $post_type
 * @param $id
 */
function create_all_term_relationships_of_all_term_type_of_post_type($post_type, $id)
{
    \thienhungho\TermManagement\modules\TermBase\TermRelationships::deleteAll([
        'obj_type' => $post_type,
        'obj_id'   => $id,
    ]);
    $termTypes = get_all_term_type_of_post_type($post_type);
    foreach ($termTypes as $termType) {
        create_term_relationships(
            $termType['name'],
            request()->post('term_data_' . $termType['name']),
            $post_type,
            $id
        );
    }
}

/**
 * @param $product_type
 * @param $id
 */
function create_all_term_relationships_of_all_term_type_of_product_type($product_type, $id)
{
    \thienhungho\TermManagement\modules\TermBase\TermRelationships::deleteAll([
        'obj_type' => $product_type,
        'obj_id'   => $id,
    ]);
    $termTypes = get_all_term_type_of_product_type($product_type);
    foreach ($termTypes as $termType) {
        create_term_relationships(
            $termType['name'],
            request()->post('term_data_' . $termType['name']),
            $product_type,
            $id
        );
    }
}

/**
 * @param $term_type
 * @param $term_id
 * @param $obj_type
 *
 * @return array
 */
function get_all_obj_id_in_term($term_type, $term_id, $obj_type)
{
    /**
     * Get All Term Id + Term Child
     */
    $termIds = \yii\helpers\ArrayHelper::getColumn(
        \thienhungho\TermManagement\modules\TermBase\Term::find()
            ->select('id')
            ->where(['id' => $term_id])
            ->orWhere(['term_parent' => $term_id])
            ->asArray()
            ->all(), 'id'
    );

    /**
     * Find all Post Id With Term
     */
    return \yii\helpers\ArrayHelper::getColumn(
        \thienhungho\TermManagement\modules\TermBase\TermRelationships::find()
            ->select('obj_id')
            ->where(['obj_type' => $obj_type])
            ->andWhere(['term_type' => $term_type])
            ->andWhere(['in', 'term_id', $termIds])
            ->asArray()
            ->all(), 'obj_id'
    );
}

/**
 * @param $term_id
 * @param string $obj_type
 *
 * @return int|string
 */
function count_number_obj_in_term($term_id, $obj_type = 'all')
{
    if ($obj_type == 'all') {
        return \thienhungho\TermManagement\modules\TermBase\TermRelationships::find()
            ->where(['term_id' => $term_id])
            ->count();
    } else {
        return \thienhungho\TermManagement\modules\TermBase\TermRelationships::find()
            ->where(['term_id' => $term_id])
            ->andWhere(['obj_type' => $obj_type])
            ->count();
    }
}

/**
 * @return array|\thienhungho\TermManagement\modules\TermBase\Term[]|\thienhungho\TermManagement\modules\TermBase\TermQuery
 */
function get_all_category()
{
    return get_all_term('category');
}

/**
 * @return array|\thienhungho\TermManagement\modules\TermBase\Term[]|\thienhungho\TermManagement\modules\TermBase\TermQuery
 */
function get_all_tag()
{
    return get_all_term('tag');
}

/**
 * @return array|\thienhungho\TermManagement\modules\TermBase\Term[]|\thienhungho\TermManagement\modules\TermBase\TermQuery
 */
function get_all_product_category()
{
    return get_all_term('product-category');
}

/**
 * @return array|\thienhungho\TermManagement\modules\TermBase\Term[]|\thienhungho\TermManagement\modules\TermBase\TermQuery
 */
function get_all_product_tag()
{
    return get_all_term('product-tag');
}