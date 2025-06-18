<?php
namespace app\controllers;

use app\common\services\TrackService;
use app\models\TrackBulkStatusForm;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;

class TrackController extends ActiveController
{
    public $modelClass = 'app\models\Track';

    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        return $behaviors;
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionBulkStatus()
    {
        $validator = new TrackBulkStatusForm();
        $validator->load(Yii::$app->request->getBodyParams(), '');
        if (!$validator->validate()) {
            throw new BadRequestHttpException(json_encode($validator->getErrors()));
        }
        $service = new TrackService();
        $res = $service->bulkUpdateStatus($validator->ids, $validator->status);
        \Yii::$app->response->statusCode = 200;
        return ['message' => $res, 'ids' => $validator->ids];
    }
}