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
        unset($actions['view'], $actions['index'], $actions['delete'], $actions['update']);
        return $actions;
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
