<?php

use Join\Todo;
use Join\Controllers\Todocontroller;

$app->get('/', function ($request, $response, $args) {
   return $this->renderer->render($response, 'app.php', $args);
});


$app->group('/todos', function() {

   $this->get('', Todocontroller::class . ':' . 'index');
   $this->post('', Todocontroller::class . ':' . 'store');
   $this->patch('', Todocontroller::class . ':' . 'patchOrder');
   $this->patch('/{id}', Todocontroller::class . ':' . 'patch');
   $this->delete('/{id}', Todocontroller::class . ':' . 'delete');
   
});
