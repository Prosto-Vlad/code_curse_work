<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Worker;
use yii\helpers\Url;

class LoginController extends Controller
{
    public function actionIndex()
    {
        return $this->render('main');
    }

    public function actionAuth()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;

        $username = $request->post('name');
        $password = $request->post('pass');

        $md5_pass = md5($password);

        $user = Worker::findOne(['login' => $username, 'password' => $md5_pass]);

        if ($user) {
            if ($user->role_id == 1) {
                Yii::$app->session->set('user', $user->attributes);
                return $this->redirect(Url::to(['librarian/index']));
            } else {
                Yii::$app->session->set('user', $user->attributes);
                return $this->redirect(Url::to(['admin/index']));
            }
        } else {
            return ['status' => 'error'];
        }
    }

    public function actionLogout()
    {
        Yii::$app->session->remove('user');
        return $this->redirect(Url::to(['login/index']));
    }

    

    
}
