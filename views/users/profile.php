<?php

use app\models\User;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $image  */
/* @var $user app\models\User */
/* @var $commentsProvider \yii\data\ActiveDataProvider*/
/* @var $commentsSearch \app\models\SearchComments*/
/* @var $ideasProvider \yii\data\ActiveDataProvider*/
/* @var $ideasSearch \app\models\SearchIdeas*/

$form = ActiveForm::begin();

$this->title = 'Профиль ' . strval($user->users_name);
?>
<?php if(!$user->status) : ?>
    <div class="row" STYLE="background-color: #FFFFFF; color: #000000">
        <div class="col-lg-5">
            <h3>Профиль <?= Html::encode($user->users_name) ?></h3>
            <?php
            if (Yii::$app->user->id == $user->id_users) {
                echo '<a href="re-profile?id=' . strval($user->id_users) . '" class="btn btn-primary" role="button">Редактировать</a>';
                echo '<h4>Логин : ' . Html::encode($user->username) . '</h4>';
                echo '<h4>' . Html::button('Сменить пароль', ['value' => Url::to('/users/change-password'), 'class' => 'btn btn-success', 'name' => 'change-password-button', 'id' => 'modalButton2']) . '</h4>';
                Modal::begin([
                    'header' => '<h4>Сменить пароль</h4>',
                    'id' => 'modal2',
                    'size' => 'modal-lg',
                ]);
                echo "<div id='modalContent2'></div>";
                Modal::end();
            }
            ?>
        </div>
        <div class="col-lg-4">
            <h2><?= $image ?></h2>
        </div>
    </div>
    <div class="row" STYLE="background-color: #FFFFFF; color: #000000">
        <?php if ($user->users_info != null) : ?>
            <div class="col-lg-3">
                <h3>Информация:</h3>
            </div>
            <div class="col-lg-9">
                <?php
                    echo '<h4><br>' . Html::encode($user->users_info) . '</h4>';
                ?>
            </div>
        <?php endif; ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="row" STYLE="background-color: #FFFFFF; color: #000000">
        <div class="col-lg-12">
            <?php if($ideasProvider->totalCount > 0) : ?>
                <h2>
                    Идеи пользователя
                </h2>
            <?php endif ?>
        </div>
    </div>
    <?php if ($ideasProvider->totalCount > 0) : ?>
        <div class="view-ideas" STYLE="background-color: #FFFFFF; color: #000000">
            <?= GridView::widget([
                'dataProvider' => $ideasProvider,
                'filterModel' => $ideasSearch,
                'layout' => '{items}{pager}',
                'columns' => [
                    [
                        'attribute' => 'id_ideas',
                        'label' => 'Id',
                        'contentOptions'=>['style'=>'width : 100px; background-color: #FFFFFF; color: #000000'],
                    ],
                    [
                        'attribute' => 'ideas_name',
                        'label' => 'Имя',
                        'contentOptions'=>['style'=>'width : 300px; background-color: #FFFFFF; color: #000000'],
                    ],
                    [
                        'label' => 'Тэги',
                        'contentOptions'=>['style'=>'width : 250px; background-color: #FFFFFF; color: #000000'],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $array_tags = [];
                            foreach($data->ideas_tags as $tag) {
                                $array_tags[] = strval($tag->tag).' ';
                            }
                            return implode(", ", $array_tags);
                        },
                    ],
                    [
                        'attribute' => 'creations_day',
                        'label' => 'День',
                        'contentOptions'=>['style'=>'width : 100px; background-color: #FFFFFF; color: #000000'],
                    ],
                    [
                        'attribute' => 'creations_month',
                        'label' => 'Месяц',
                        'contentOptions'=>['style'=>'width : 150px; background-color: #FFFFFF; color: #000000'],
                    ],
                    [
                        'attribute' => 'creations_year',
                        'label' => 'Год',
                        'contentOptions'=>['style'=>'width : 130px; background-color: #FFFFFF; color: #000000'],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions'=>['style'=>'width : 50px; background-color: #FFFFFF; color: #000000'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-eye-open']);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                            },
                            'delete' => function ($url, $model, $key){
                                return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key), 'bool' => false]), ['class' => 'glyphicon glyphicon-trash']);
                            }
                        ]
                    ],
                ],
            ])?>
        </div>
    <?php endif; ?>
    <div class="row" STYLE="background-color: #FFFFFF; color: #000000">
        <div class="col-lg-12">
            <?php if($commentsProvider->totalCount > 0) : ?>
            <h2>
                Комментарии пользователя
            </h2>
            <?php endif ?>
        </div>
    </div>
    <?php if ($commentsProvider->totalCount > 0) : ?>
        <div class="view-idea-comments">
            <?= GridView::widget([
                'dataProvider' => $commentsProvider,
                'layout' => '{items}{pager}',
                'columns' => [
                    [
                        'attribute' => 'comment',
                        'label' => 'Комментарий',
                        'contentOptions'=>['style'=>'width : 500px; background-color: #FFFFFF; color: #000000'],
                    ],
                    [
                        'attribute' => 'creators_id',
                        'label' => 'Комментатор',
                        'contentOptions'=>['style'=>'width : 100px; background-color: #FFFFFF; color: #000000'],
                        'value' => function ($data) {
                            return Html::a(Html::encode($data->getAuthorsName()), Url::toRoute(['/users/profile', 'id' => $data->users_id]));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width : 50px; background-color: #FFFFFF; color: #000000'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($key),]), ['class' => '/*glyphicon glyphicon-eye-open*/']);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('',  Url::toRoute(['/comments/re-comment', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                            },
                            'delete' => function ($url, $model, $key){
                                if (Yii::$app->user->id != $model->users_id){
                                    return Html::a('', Url::toRoute(['/comments/delete-comment', 'id' => strval($key), 'bool' => strval(false)]), ['class' => '']);
                                } else {
                                    return Html::a('', Url::toRoute(['/comments/delete-comment', 'id' => strval($key), 'bool' => strval(false)]), ['class' => 'glyphicon glyphicon-trash']);
                                }
                            }
                        ]
                    ],
                ],
            ])?>
        </div>
    <?php endif; ?>
<?php else : ?>
    <h1>Аккаунт временно заблокирован</h1>
    <?php if(($user->id_users == Yii::$app->user->id) && ($user->status != 2)) : ?>
        <?php
            echo Html::a('Востановить профиль', Url::toRoute(['/users/re-status', 'id' => strval($user->id_users),]), [
                'data-confirm' => 'Вы уверены, что хотите востановить профиль?',
                'data-method' => 'post',
                'data-pjax' => '0',
                'class' => 'btn btn-primary',
                'name' => 'delete-user-button',
            ]);
        ?>
    <?php endif;?>
<?php endif; ?>

