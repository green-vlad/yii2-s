<?php
define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ .'/../vendor/autoload.php';

$config = require __DIR__ . '/../config/test.php';

// Создаём приложение
$app = new yii\console\Application($config);

// Накатываем миграции
$migration = new \yii\console\controllers\MigrateController('migrate', $app);
$migration->interactive = false;
$migration->runAction('up', ['migrationPath' => '@app/migrations', 'interactive' => false]);
