<!doctype html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>Join ToDo</title>
      <link rel="stylesheet" href="assets/bootstrap.min.css">
      <link rel="stylesheet" href="css/main.css?v=<?php echo filemtime('css/main.css'); ?>">
      <script src="assets/angular.min.js"></script>
      <script src="assets/lodash.min.js"></script>
      <script src="js/Todo.js?v=<?php echo filemtime('css/main.css'); ?>"></script>
   </head>
   <body>
      <div class="app-wrapper" ng-app="Todo" ng-cloak>
         <div class="list-wrapper" ng-controller="TodoController">
            <ul class="list-group">
               <div class="form-group">
                  <form ng-submit="newTodo()">
                     <input ng-model="new_todo" class="form-control input-lg" type="text" placeholder="Your next todo">
                  </form>
               </div>
               <li class="list-group-item" ng-repeat="todo in todos">
                  {{todo.label}}
               </li>
            </ul>
         </div>
      </div>
      <p class="footer">Test assignment project, by <a href="https://github.com/daniti">daniti</a></p>
   </body>
</html>
