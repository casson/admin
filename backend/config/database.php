<?php


return array(
	'components'=>array(
		'admin' =>array(
			'class' => 'yii\db\Connection',
                  'dsn' => 'mysql:host=localhost;dbname=admin',
                  'username' => 'root',
                  'password' => 'admin',
                  'charset' => 'utf8',
                  'tablePrefix'=>'dt_'  
		),
		'app' => array(
			'class' => 'yii\db\Connection',
                  'dsn' => 'mysql:host=127.0.0.1;dbname=app',
                  'username' => 'root',
                  'password' => 'admin',
                  'charset' => 'utf8'
		)
	));