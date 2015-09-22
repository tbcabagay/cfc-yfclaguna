Couples for Christ - Youth for Christ Laguna

Go to "/path/to/cfc-yfclaguna"

Edit database settings - "config/db.php"

<pre>
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=enter database name',
    'username' => 'enter user',
    'password' => 'enter password',
    'charset' => 'utf8',
];
</pre>

Run "composer update" to download vendors

Run "./yii/migrate" to create tables

Run "./yii rbac/init" to create RBAC module