<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\ImageUpload;
use app\models\Post;
use app\models\PostSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->savePost()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $categories = Category::getCategories();


        return $this->render('create', [
            'model' => $model,
            'categories' => $categories
        ]);
    }


    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetImage($id)
    {
        $model = new ImageUpload;

        // если поступила загрузка картинки(метод post only)
        if (Yii::$app->request->isPost)
        {
            // находим этот пост по айди
            $post = $this->findModel($id);
            // получаем файл
            $file = UploadedFile::getInstance($model, 'image');
            // при сохранении получаем тип bool поэтому если сохранилось то
            if($post->saveImage($model->uploadedFile($file, $post->image)))
            {
                // перенаправляем пользователя
                return $this->redirect(['view', 'id'=>$post->id]);
            }
        }

        // отрисовываем
         return $this->render('image', ['model'=>$model]);
    }

    public function getCategories()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'name');
    }

    public function actionSetCategory($id)
    {
        $post = $this->findModel($id);
        $selectedCategory = ($post->category) ? $post->category->id : '0';
        $categories = $this->getCategories();

        if(Yii::$app->request->isPost)
        {
            $category = Yii::$app->request->post('category');
            if($post->saveCategory($category))
            {
                return $this->redirect(['view', 'id'=>$post->id]);
            }
        }

        return $this->render('category', [
            'post' => $post,
            'selectedCategory' => $selectedCategory,
            'categories' => $categories,
        ]);
    }
}
