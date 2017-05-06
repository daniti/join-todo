<?php

use Join\Todo;

$app->get('/', function ($request, $response, $args) {
   // Render index view
   return $this->renderer->render($response, 'app.php', $args);
});

$app->get('/todos', function ($request, $response, $args) {
   return $response->withJson(Todo::all());
});
