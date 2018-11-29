<?php

namespace app\controllers;

use Yii;

use app\models\Usuarios;

use yii\rest\ActiveController;

class UsersController extends ActiveController
{
    public $modelClass = 'app\models\Usuarios';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'],$actions['create'], $actions['index'], $actions['delete'], $actions['update']);
        return $actions;
    }

    /**
     * Añade una fila a la table usuarios o devuelve un null como error
     * @return [type] [description]
     */
    public function actionCreate()
    {
        $model = new Usuarios();
        $model->scenario = Usuarios::ESCENARIO_CREAR;
        $model->nombre = $_POST['nombre'];
        $model->email = $_POST['email'];
        $model->password = $_POST['password'];
        $model->password_repeat = $_POST['password'];
        $model->zona_horaria = 'Europe/Madrid';
        $model->biografia = 'aa';

        if ($model->save()) {
            $model->refresh();
            return $model;
        }

        return $model->errors;
    }

    /**
     * Comprueba la disponibilidad de un nombre de usuario
     * @param  [type] $nombre [description]
     * @return boolean         true si esta disponible false si no
     */
    public function actionCheckname($nombre)
    {
        return !Usuarios::find()->where(['nombre' => $nombre])->exists();
    }


    /**
     * Comprueba la disponibilidad de un nombre de usuario
     * @param  [type] $nombre [description]
     * @return boolean         true si esta disponible false si no
     */
    public function actionCheckemail($email)
    {
        return !Usuarios::find()->where(['email' => $email])->exists();
    }

    /**
     * Comprueba credenciales del usuario y devuelve sus datos si existe o falso si no existe
     * @return [type] [description]
     */
    public function actionLogin()
    {
        if (!empty($_POST)) {
            $nombre = $_POST['usuario'];
            $password = $_POST['password'];

            $usuario = Usuarios::findOne(['nombre' => $nombre]);
            if ($usuario != null) {
                return (Yii::$app->getSecurity()->validatePassword($password, $usuario->password)) ? $usuario: false;
            }
        }
    }
}
