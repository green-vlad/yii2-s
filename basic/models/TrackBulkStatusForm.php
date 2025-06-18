<?php

namespace app\models;

use yii\base\Model;

class TrackBulkStatusForm extends Model
{
    public array $ids = [];
    public string $status = Track::STATUS_NEW;

    public function rules()
    {
        return [
            [['ids', 'status'], 'required'],
            ['ids', 'each', 'rule' => ['integer']],
            ['status', 'in', 'range' => [
                Track::STATUS_NEW,
                Track::STATUS_IN_PROGRESS,
                Track::STATUS_COMPLETED,
                Track::STATUS_FAILED,
                Track::STATUS_CANCELED,
            ]],
        ];
    }
}