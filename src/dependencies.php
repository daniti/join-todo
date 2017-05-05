<?php

require_once(__DIR__ . '/../db/db-config.php');

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
	$settings = $c->get('settings')['renderer'];
	return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
	$settings = $c->get('settings')['logger'];
	$logger = new Monolog\Logger($settings['name']);
	$logger->pushProcessor(new Monolog\Processor\UidProcessor());
	$logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
	return $logger;
};

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
	'driver' => DB_DRIV,
	'host' => DB_HOST,
	'port' => DB_PORT,
	'database' => DB_NAME,
	'username' => DB_USER,
	'password' => DB_PASS,
	'charset' => DB_CHAR,
	'collation' => DB_COLL,
]);
$capsule->bootEloquent();

require_once 'models/Todo.php';
