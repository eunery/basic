<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'body:ntext',
            'head',
            'dateCreate',
            'author',
            [
                'format' => 'html',
                'label' => 'image',
                'value' => function($data){
                    return Html::img($data->getImage(), ['width'=>100]);
                }
            ],
            //'status',
            //'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
