<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "track".
 *
 * @property int $id
 * @property string $track_number
 * @property string $status
 * @property string $created_at
 * @property int|null $updated_at
 */
class Track extends ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELED = 'canceled';

    public function behaviors()
    {
        return [
            'updatedAt' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'track';
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->isNewRecord) {
            $this->status = self::STATUS_NEW;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => Track::STATUS_NEW],
            [['track_number'], 'required'],
            [['status'], 'string'],
            [['created_at'], 'safe'],
            [['updated_at'], 'safe'],
            [['track_number'], 'string', 'max' => 255],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['track_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'track_number' => 'Track Number',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_NEW => 'new',
            self::STATUS_IN_PROGRESS => 'in_progress',
            self::STATUS_COMPLETED => 'completed',
            self::STATUS_FAILED => 'failed',
            self::STATUS_CANCELED => 'canceled',
        ];
    }

    /**
     * @param $insert
     * @param $changedAttributes
     * @return void
     */
    public function afterSave($insert, $changedAttributes)
    {
        $action = $insert ? 'create' : 'update';

        Yii::info(json_encode([
            'action' => $action,
            'model' => 'Track',
            'id' => $this->id,
            'user_id' => Yii::$app->user->id ?? null,
            'changes' => $changedAttributes,
        ]), 'track_actions');
    }

    /**
     * @return void
     */
    public function afterDelete()
    {
        parent::afterDelete();
        Yii::info(json_encode([
            'action' => 'delete',
            'model' => 'Track',
            'id' => $this->id,
            'user_id' => Yii::$app->user->id ?? null,
        ]), 'track_actions');
    }

    public static function updateAll($attributes, $condition = '', $params = [])
    {
        Yii::info(json_encode([
            'action' => 'bulk update',
            'model' => 'Track',
            'conditions' => json_encode($condition),
            'user_id' => Yii::$app->user->id ?? null,
        ]), 'track_actions');
        return parent::updateAll($attributes, $condition, $params);
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusNew()
    {
        return $this->status === self::STATUS_NEW;
    }

    public function setStatusToNew()
    {
        $this->status = self::STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isStatusInprogress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function setStatusToInprogress()
    {
        $this->status = self::STATUS_IN_PROGRESS;
    }

    /**
     * @return bool
     */
    public function isStatusCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function setStatusToCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isStatusFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function setStatusToFailed()
    {
        $this->status = self::STATUS_FAILED;
    }

    /**
     * @return bool
     */
    public function isStatusCanceled()
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function setStatusToCanceled()
    {
        $this->status = self::STATUS_CANCELED;
    }
}
