<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "metrics".
 *
 * @property int $id
 * @property string|null $date_create
 * @property int|null $source_id
 * @property int|null $counter_id
 * @property float|null $value
 */
class Metrics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metrics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create'], 'safe'],
            [['source_id', 'counter_id'], 'integer'],
            [['value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_create' => 'Date Create',
            'source_id' => 'Source ID',
            'counter_id' => 'Counter ID',
            'value' => 'Value',
        ];
    }
}