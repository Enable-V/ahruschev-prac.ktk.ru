<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Регистрация
     *
     * @return string|void
     */


    /**
     * @return string|void|Response
     */
    public function actionReg()
    {
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $model = new \app\models\RegForm();

        if (($this->request->isPost || $this->request->isPjax) && $model->load(Yii::$app->request->post()) && $model->validate() && $model->reg()) {
           Yii::$app->session->setFlash('success',Yii::t('app','Registration has been successfully completed. Now you can log in'));
           return $this->redirect('/login');
        }

        $model->password = '';
        $model->password2 = '';
        return $this->render('reg', [
            'model' => $model,
        ]);
    }
}
