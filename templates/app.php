<!doctype html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Join ToDo</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" href="css/main.css?v=<?php echo filemtime('css/main.css'); ?>">
      <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
      <script src="assets/lodash.min.js"></script>
      <script src="js/Todo.js?v=<?php echo filemtime('css/main.css'); ?>"></script>
   </head>
   <body>
      <div class="app-wrapper" ng-app="Todo" ng-cloak>

         <div class="list-wrapper" ng-controller="TodoController">

            <div class="form-group">
               <form ng-submit="create()">
                  <input ng-model="new" class="form-control input-lg" type="text" placeholder="Your next todo" required>
               </form>
            </div>

            <div ng-hide="loading" ng-if="todos.length">
               <ul class="nav nav-tabs">
                  <li role="presentation" ng-class="{'active':filter_completed == null}">
                     <a ng-click="showOnly(null)">All <b>{{todos.length}}</b> tasks</a>
                  </li>
                  <li role="presentation" ng-class="{'active':filter_completed == 0}">
                     <a ng-click="showOnly(0)"><b>{{remaining()}}</b> remaining</a>
                  </li>
                  <li role="presentation" ng-class="{'active':filter_completed == 1}">
                     <a ng-click="showOnly(1)"><b>{{completed()}}</b> completed</a>
                  </li>
               </ul>

               <ul class="list-group">
                  <li class="list-group-item" ng-repeat="todo in todos" ng-if="filter_completed == null || todo.completed == filter_completed" ng-class="{'completed':todo.completed}">

                     <div class="todo" ng-if="!todo.editing">
                        <span class="todo-area todo-complete" ng-click="complete(todo.id)">
                           <span ng-show="!todo.completed" class="glyphicon glyphicon-unchecked"></span>
                           <span ng-show="todo.completed" class="glyphicon glyphicon-check"></span>
                        </span>

                        <span class="todo-area todo-label" ng-click="complete(todo.id)">
                           {{todo.label}}
                        </span>

                        <span class="todo-area todo-actions">
                           <span class="action glyphicon glyphicon-pencil" ng-click="todo.editing = true"></span>
                           <span class="action glyphicon glyphicon-remove" ng-click="delete(todo.id)"></span>
                        </span>
                     </div>

                     <form class="todo-editing form-inline" ng-if="todo.editing" ng-submit="patch(todo.id)">
                        <input class="form-control" type="text" ng-model="todo.label">
                     </form>

                  </li>
               </ul>
               
               <div class="well empty" ng-show="filter_completed == 0 && !remaining()">
                  <h2>Nothing here.<br>Good job!</h2>
               </div>
               
               <div class="well empty" ng-show="filter_completed == 1 && !completed()">
                  <h2>No tasks completed yet...</h2>
               </div>
               
            </div>

            <div class="well empty" ng-hide="loading" ng-if="!todos.length">
               <h2>Nothing to do here...</h2><br>
               <img src="assets/sun.png">
            </div>

         </div>
      </div>
      <p class="footer">Test assignment project, by <a href="https://github.com/daniti">daniti</a></p>
   </body>
</html>
