<?php

namespace app\models;

use Cassandra\Date;
use phpDocumentor\Reflection\Types\True_;
use phpDocumentor\Reflection\Utils;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string|null $body
 * @property string|null $head
 * @property string|null $dateCreate
 * @property string|null $author
 * @property int|null $status
 * @property int|null $user
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @var mixed|null
     */

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['dateCreate'], 'date', 'format'=>'php:Y-m-d'],
            [['dateCreate'], 'default', 'value' => date('Y-m-d', 1)], // l jS \of F Y h:i:s A
            [['status', 'user'], 'integer'],
            [['head', 'author'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'body' => 'Body',
            'head' => 'Head',
            'dateCreate' => 'Date Create',
            'author' => 'Author',
            'status' => 'Status',
            'user' => 'User',
        ];
    }

    public function saveImage($filename)
    {
        // получаем имя файла и сохраняем его в базу
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage()
    {
        // если есть картинка то возвращаем ее путь
        // если картинки нет то выводим готовую картинку
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }

    public function deleteImage()
    {
        // удаляем картинку вместе с постом исползуется в методе beforeDelete
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        // каждый раз когда вносим изменения в поле с картинкой
        // то удаляется старая картинка
        $this->deleteImage();
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);
        if($category != null)
        {
            $this->link('category', $category);
            return true;
        }
    }


    // default = 3
    public static function getAll($pageSize = 1)
    {
        // делаем запрос в базу данных чтобы получить все статьи +
        // можно добавить проверку по статусу:
        // $query = Post::find()->where(['status'=> 1])->all();
        $query = Post::find();

        // получаем количество статей
        $count = $query->count();

        // создаем объект пагинации с конечным числом
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);

        //ограничиваем запрос используя пагинацию и получаем статьи
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data['posts'] = $posts;
        $data['pagination'] = $pagination;

        return $data;
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->dateCreate);
    }

    public function getCategory()
    {
        // связываем айди категории с айди в таблице поста поля category_id
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function savePost(){
        $this->dateCreate = date('Y-m-d');
        $this->author = Yii::$app->user->id;
        return $this->save(false);
    }

    public static function getCategories()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'name');
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(),['id'=>'author']);
    }

    public function viewsCounter()
    {
        $this->views += 1;
        return $this->save(false);
    }

}
