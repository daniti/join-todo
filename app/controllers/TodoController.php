<?php

namespace Join\Controllers;

use Join\Todo;
use Slim\Container as ContainerInterface;

class Todocontroller {

   public function __construct(ContainerInterface $container) {
      $this->container = $container;
   }

   public function index($request, $response, $args) {
      return $response->withJson(Todo::allTodos());
   }

   public function store($request, $response, $args) {

      $params = $request->getParsedBody();

      if (empty($params['label'])) {
         return $response->withStatus(400)
                         ->withHeader('Content-Type', 'text/html')
                         ->write('Cannot add empty todos...');
      }
      $newtodo = new Todo();
      $newtodo->label = $params['label'];
      $newtodo->save();

      // get all columns
      $newtodo = Todo::find($newtodo->id);

      return $response->withStatus(201)
                      ->withJson($newtodo);
   }

   public function patch($request, $response, $args) {
      $request->getAttribute('id');

      $todo = Todo::find($request->getAttribute('id'));
      if (!$todo) {
         return $response->withStatus(404);
      }

      $params = $request->getParsedBody();

      $todo->label = !empty($params['label']) ? $params['label'] : $todo->label;
      $todo->completed = isset($params['completed']) ? $params['completed'] : $todo->completed;
      $todo->save();

      return $response->withStatus(200)
                      ->withJson($todo);
   }

   public function delete($request, $response, $args) {
      $request->getAttribute('id');

      $todo = Todo::find($request->getAttribute('id'));

      if (!$todo) {
         return $response->withStatus(404);
      }

      $todo->delete();

      return $response->withStatus(200);
   }

   public function patchOrder($request, $response, $args) {

      $params = $request->getParsedBody();

      if (empty($params['order'])) {
         return $response->withStatus(400)
                         ->withHeader('Content-Type', 'text/html')
                         ->write('Wrong order');
      }

      Todo::applyOrder($params['order']);

      return $response->withStatus(200);
   }

}
