<?php

namespace thienhungho\TermManagement\modules\TermBase;

use \thienhungho\TermManagement\modules\TermBase\base\Term as BaseTerm;

/**
 * This is the model class for table "term".
 */
class Term extends BaseTerm
{

    const CATEGORY_TERM_TYPE = 'category';
    const TERM_TYPE_TAG = 'tag';
    const DEFAULT_FEATURE_IMG = 'uploads/default-feature-img.png';

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
            [['description'], 'string'],
            [['author', 'term_parent', 'assign_with', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'feature_img', 'term_type', 'language'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['assign_with'], 'default', 'value' => 0],
            [['term_parent'], 'default', 'value' => 0],
            [['created_by'], 'default', 'value' => \Yii::$app->user->id],
            [['updated_by'], 'default', 'value' => \Yii::$app->user->id],
            [['author'], 'default', 'value' => \Yii::$app->user->id],
            [['language'], 'default', 'value' => \Yii::$app->language],
            [
                ['term_type'],
                'default',
                'value' => self::CATEGORY_TERM_TYPE,
            ],
            [['feature_img'], 'default', 'value' => self::DEFAULT_FEATURE_IMG],
        ]);
    }

    /**
     * @param bool $insert
     *
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $img = upload_img('Term[feature_img]');
            if (!empty($img)) {
                $this->feature_img = $img;
            } elseif(empty($img) && !$this->isNewRecord) {
                $model = static::findOne(['id' => $this->id]);
                if ($model) {
                    $this->feature_img = $model->feature_img;
                }
            }

            return true;
        }

        return false;
    }

}
