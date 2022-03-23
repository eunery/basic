<?php

namespace app\modules\post\models;

use app\models\Post;
use app\models\User;
use yii\base\Model;

final class PostForm extends Model
{
    public $author;
    public $body;
    public $head;
    public $dateCreate;
    public $status;
    /** @var User */
    public $user;

    public function rules(): array
    {
        return[
            [['body', 'head', 'author', 'status'], 'required'],
            ['body', 'string', 'max' => 4096],
            ['head', 'string'],
            ['dateCreate', 'date'],
            ['author', 'safe'],
            ['status', 'in', 'range' => [1, 2, 3]],
        ];
    }

    public function validate()
    {

    }

    public function load()
    {

    }

    public function save()
    {
        return true;
    }

    public function publish()
    {
        $this->publish();
    }

    public function unPublish()
    {
        $this->unPublish();
    }

    public function generatePost(): Post
    {
        return new Post([
            'body' => $this->body,
            'head' => $this->head,
            'dateCreate' => $this->dateCreate,
            'status' => $this->status,
            'author' => $this->author,
        ]);
    }
}