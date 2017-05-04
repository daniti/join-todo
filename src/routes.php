<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Render index view
    return $this->renderer->render($response, 'app.phtml', $args);
});
