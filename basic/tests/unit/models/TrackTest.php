<?php

namespace app\tests\unit\models;

use app\models\Track;
use Codeception\Test\Unit;
use Yii;

class TrackTest extends Unit
{
    public function testValidationFailsWithoutTrackNumber()
    {
        $model = new Track();
        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('track_number', $model->getErrors());
    }

    public function testValidationPassesWithValidData()
    {
        $model = new Track([
            'track_number' => 'TRACK123',
            'status' => Track::STATUS_IN_PROGRESS,
        ]);
        $this->assertTrue($model->validate());
    }

    public function testDefaultStatusIsNew()
    {
        $model = new Track(['track_number' => 'T123']);
        $model->save(false);
        $this->assertEquals(Track::STATUS_NEW, $model->status);
    }

    public function testUpdatedAtIsSet()
    {
        $model = new Track(['track_number' => 'T999']);
        $model->save(false);

        $originalUpdatedAt = $model->updated_at;

        sleep(1);

        $model->status = Track::STATUS_FAILED;
        $model->save(false);
        $model->refresh();

        $this->assertNotEquals($originalUpdatedAt, $model->updated_at);
    }
}