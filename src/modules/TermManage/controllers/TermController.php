<?php

namespace thienhungho\TermManagement\modules\TermManage\controllers;

use thienhungho\TermManagement\modules\TermBase\Term;
use thienhungho\TermManagement\modules\TermBase\TermType;
use thienhungho\TermManagement\modules\TermManage\search\TermSearch;
use common\modules\seo\Seo;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TermController implements the CRUD actions for Term model.
 */
class TermController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /*
     *
     */
    public function actionIndex($slug = 'category')
    {
        if (!is_term_type_slug($slug)) {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
        $term_type = TermType::find()->select(['name'])->where(['slug' => $slug])->one();
        $searchModel = new TermSearch();
        $queryParams = request()->queryParams;
        $queryParams['TermSearch']['term_type'] = $term_type->name;
        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'term_type'     => $term_type,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerTermRelationships = new \yii\data\ArrayDataProvider([
            'allModels' => $model->termRelationships,
        ]);

        return $this->render('view', [
            'model'                     => $this->findModel($id),
            'providerTermRelationships' => $providerTermRelationships,
        ]);
    }

    /**
     * @param $type
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionCreate($type)
    {
        if (!is_term_type_name($type)) {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
        $model = new Term();
        $model->term_type = $type;
        if ($model->loadAll(request()->post())) {
            $model->term_type = $type;
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                $seo = new Seo([
                    'title'              => $model->name,
                    'slug'               => $model->slug,
                    'description'        => substr(strip_tags($model->description), 0, 255),
                    'social_image'       => $model->feature_img,
                    'social_title'       => $model->name,
                    'social_description' => substr(strip_tags($model->description), 0, 255),
                    'obj_type'           => $model->term_type,
                    'obj_id'             => $model->id,
                ]);
                $seo->save();

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();

                return $this->render('create', [
                    'model'    => $model,
                    'termType' => $type,
                ]);
            }
        }

        return $this->render('create', [
            'model'    => $model,
            'termType' => $type,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        if (request()->post('_asnew') == '1') {
            $model = new Term();
        } else {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                Seo::deleteAll([
                    'obj_type' => $model->term_type,
                    'obj_id'   => $model->primaryKey,
                ]);
                $seo = new Seo([
                    'title'              => $model->name,
                    'slug'               => $model->slug,
                    'description'        => substr(strip_tags($model->description), 0, 255),
                    'social_image'       => $model->feature_img,
                    'social_title'       => $model->name,
                    'social_description' => substr(strip_tags($model->description), 0, 255),
                    'obj_type'           => $model->term_type,
                    'obj_id'             => $model->id,
                ]);
                $seo->save();

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->deleteWithRelated()) {
            Seo::deleteAll([
                'obj_type' => $model->term_type,
                'obj_id'   => $model->primaryKey,
            ]);
            set_flash_success_delete_content();
        } else {
            set_flash_error_delete_content();
        }

        return $this->goBack(request()->referrer);
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPdf($id)
    {
        $model = $this->findModel($id);
        $providerTermRelationships = new \yii\data\ArrayDataProvider([
            'allModels' => $model->termRelationships,
        ]);
        $content = $this->renderAjax('_pdf', [
            'model'                     => $model,
            'providerTermRelationships' => $providerTermRelationships,
        ]);
        $pdf = new \kartik\mpdf\Pdf([
            'mode'        => \kartik\mpdf\Pdf::MODE_UTF8,
            'format'      => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content'     => $content,
            'cssFile'     => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline'   => '.kv-heading-1{font-size:18px}',
            'options'     => ['title' => \Yii::$app->name],
            'methods'     => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ],
        ]);

        return $pdf->render();
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionSaveAsNew($id)
    {
        $model = new Term();
        if (request()->post('_asnew') != '1') {
            $model = $this->findModel($id);
        }
        if ($model->loadAll(request()->post())) {
            if ($model->saveAll()) {
                set_flash_has_been_saved();
                $seo = new Seo([
                    'title'              => $model->name,
                    'slug'               => $model->slug,
                    'description'        => strip_tags($model->description),
                    'social_image'       => $model->feature_img,
                    'social_title'       => $model->name,
                    'social_description' => strip_tags($model->description),
                    'obj_type'           => $model->term_type,
                    'obj_id'             => $model->id,
                ]);
                $seo->save();

                return $this->redirect([
                    'update',
                    'id' => $model->id,
                ]);
            } else {
                set_flash_has_not_been_saved();

                return $this->render('saveAsNew', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('saveAsNew', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Term model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Term the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Term::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddTermRelationships()
    {
        if (request()->isAjax) {
            $row = request()->post('TermRelationships');
            if ((request()->post('isNewRecord') && request()->post('_action') == 'load' && empty($row)) || request()->post('_action') == 'add')
                $row[] = [];

            return $this->renderAjax('_formTermRelationships', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(t('app', 'The requested page does not exist.'));
        }
    }
}
