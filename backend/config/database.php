<?php


return array(
	'components'=>array(
		'admin' =>array(
			'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=admin',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'tablePrefix'=>'dt_'  
		),
		'app' => array(
			'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=app',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
		)
	));