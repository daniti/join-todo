<?php

use \App\Todo;

$app->get('/', function ($request, $response, $args) {
	// Render index view
	return $this->renderer->render($response, 'app.phtml', $args);
});

$app->get('/todos', function ($request, $response, $args) {
	return $response->withJson(Todo::all());
});
