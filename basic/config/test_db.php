<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db = [
    'dsn' => 'pgsql:host=yii2-test-db;port=5432;dbname=track_test',
    'class' => 'yii\db\Connection',
    'username' => 'user',
    'password' => 'password',
    'charset' => 'utf8',
];

return $db;
