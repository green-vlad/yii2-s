<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=yii2-postgres;port=5432;dbname=track',
    'username' => 'user',
    'password' => 'password',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
