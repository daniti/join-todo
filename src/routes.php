<?php

use Join\Todo;

$app->get('/', function ($request, $response, $args) {
   // Render index view
   return $this->renderer->render($response, 'app.php', $args);
});

$app->get('/todos', function ($request, $response, $args) {
   return $response->withJson(Todo::allTodos());
});

$app->post('/todos', function ($request, $response, $args) {
   $params = $request->getParsedBody();

   if (empty($params['label'])) {
      return $response->withStatus(400)
                      ->withHeader('Content-Type', 'text/html')
                      ->write('Cannot add empty todos...');
   }

   switch ($params['_method']) {
      case 'POST':
         $newtodo = new Todo();
         $newtodo->label = $params['label'];
         $newtodo->save();

         return $response->withStatus(201)
                         ->withJson($newtodo);
   }
});

$app->post('/todos/{id}', function ($request, $response, $args) {
   $request->getAttribute('id');

   $todo = Todo::find($request->getAttribute('id'));
   if (!$todo) {
      return $response->withStatus(404);
   }

   $params = $request->getParsedBody();

   switch ($params['_method']) {
      case 'PATCH':
         $todo->label = !empty($params['label']) ? $params['label'] : $todo->label;
         $todo->completed = isset($params['completed']) ? $params['completed'] : $todo->completed;
         $todo->save();

         return $response->withStatus(200)
                         ->withJson($todo);
      case 'DELETE':
         $todo->delete();

         return $response->withStatus(200);
   }
});
