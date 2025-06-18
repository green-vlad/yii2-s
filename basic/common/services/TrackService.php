<?php

namespace app\common\services;

use app\models\Track;
use yii\db\Expression;

class TrackService
{
    /**
     * @param array $ids
     * @param string $status
     * @return int
     */
    public function bulkUpdateStatus(array $ids, string $status): int
    {
        return Track::updateAll([
            'status' => $status,
            'updated_at' => new Expression('NOW()'),
        ], ['id' => $ids]);
    }
}