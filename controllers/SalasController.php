<?php

namespace app\controllers;

use Yii;
use app\models\Salas;
use app\models\SalasSearch;
use app\models\Participantes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SalasController implements the CRUD actions for Salas model.
 */
class SalasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'acess' => [
                'class' => AccessControl::className(),
                'only' => ['delete','create','buscar','view','abandonar','expulsar'],
                'rules' =>
                [
                    [
                        'actions' => ['delete','create','buscar','view','abandonar','expulsar'],
                        'allow' => true,
                        'roles' => ['@']
                    ],

                ],
            ]
        ];
    }

    /**
     * Lists all Salas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Busca cualquier sala que este disponible
     * @return [type] [description]
     */
    public function actionBuscar()
    {

        $model = \app\models\SalasDisponibles::find()->one();

        if ($model == null) {
            Yii::$app->session->setFlash('info', Yii::t('app', 'No hay salas disponibles , crea una si lo desea'));
            return $this->redirect(['index']);
        }

        $participantes = new Participantes(['usuario_id' => Yii::$app->user->identity->id, 'sala_id'=> $model->id]);
        $participantes->save();
        return $this->redirect(['view',
            'id' => $model->id,
        ]);
    }

    /**
     * Displays a single Salas model.
     * @param  [integer] $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!$this->isParticipante($id)) {
            Yii::$app->session->setFlash('info', Yii::t('app', 'No puedes acceder a esta pagina.'));
            $this->redirect(['index']);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Salas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Salas();
        $model->creador_id = Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Salas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Un participantes estandar de la sala , deja la sala
     * @param  [type] $sala_id [description]
     * @return [type]          [description]
     */
    public function actionAbandonar($sala_id)
    {
        $model = Participantes::find()
                ->where(['sala_id' => $sala_id])
                ->andWhere(['usuario_id' => Yii::$app->user->identity->id])
                ->one();
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * El creador de la sala puede expulsar a participantes de la misma
     * @return [type] [description]
     */
    public function actionExpulsar()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = Participantes::find()
                    ->where(['sala_id' => Yii::$app->request->post('sala_id')])
                    ->andWhere(['usuario_id' => Yii::$app->request->post('usuario_id')])
                    ->one();
            if ($model != null && $model->sala->creador_id == Yii::$app->user->identity->id) {
                    return $model->delete();
            }
        }
    }

    /**
     * Finds the Salas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Salas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Salas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Comprueba si el usuario logeado es participante de una sala concreta
     * @param  [type]  $sala_id [description]
     */
    public function isParticipante($sala_id)
    {
        return Participantes::find()->where(['usuario_id' => Yii::$app->user->identity->id])
        ->andWhere(['sala_id'=> $sala_id])->all() != null;
    }
}
