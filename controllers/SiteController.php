<?php

namespace app\controllers;


use app\models\Ideas;
use app\models\SearchComments;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\ContactForm;
use app\models\GlobalSearchForm;
use app\models\User;
use app\models\SearchUsers;
use app\models\SearchIdeas;

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
     * Displays homepage
     *
     * @return string
    */

    public function actionIndex()
    {
        $ideas = Ideas::find()->all();
        //$ideas =  array_slice($ideas, -5);
        return $this->render('index', [
            'ideas' => $ideas,
        ]);
    }

    /**
     * Displays search-results.
     *
     * @return string
     */

    public function actionSearchResults()
    {
        $model = new GlobalSearchForm();
        $model->load(Yii::$app->request->get());
        $target = $model->target;

        $ideasModel = new SearchIdeas();
        $ideasProvider = $ideasModel->search(Yii::$app->request->get(), Null, $target);
        $usersModel = new SearchUsers();
        $usersProvider = $usersModel->search(Yii::$app->request->get(), Null, $target, true);
        $commentsModel = new SearchComments();
        $commentsProvider = $commentsModel->search(Yii::$app->request->get(), Null,false,  $target);

        return $this->render('search-results',[
            'target' => $target,
            'ideasProvider'=> $ideasProvider,
            'ideasModel' => $ideasModel,
            'usersProvider'=> $usersProvider,
            'usersModel' => $usersModel,
            'commentsProvider' => $commentsProvider,
            'commentsModel' => $commentsModel,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
