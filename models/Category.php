<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $name
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }

    public function getPostsCount()
    {
        return $this->getPosts()->count();
    }

    public static function getAll()
    {
        return Category::find()->all();
    }

    public static function getCategories()
    {
        return ArrayHelper::map(Category::find()->all(), 'id', 'name');
    }

    public static function getPostsByCategory($id)
    {
        // делаем запрос в базу данных чтобы получить все статьи +
        // можно добавить проверку по статусу:
        // $query = Post::find()->where(['status'=> 1])->all();
        $query = Post::find()->where(['category_id' => $id]);

        // получаем количество статей
        $count = $query->count();

        // создаем объект пагинации с конечным числом
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 6]);

        //ограничиваем запрос используя пагинацию и получаем статьи
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data['posts'] = $posts;
        $data['pagination'] = $pagination;

        return $data;
    }
}
