var Todo = angular.module('Todo', []);
Todo.controller('TodoController', function ($scope, $http) {
   $scope.todos = [];

   $scope.allTodos = function () {
      $http.get('todos', {
      }).then(function (response) {
         var data = response.data;
         $scope.todos = data;
      });
   }

   $scope.newTodo = function () {
      $http.post('todos', {
         _method: 'POST',
         label: $scope.new_todo
      }).then(function (response) {
         var data = response.data;
         $scope.new_todo = null;
         $scope.todos.unshift(data);
      });
   }

   $scope.init = function () {
      $scope.allTodos();
   }

   $scope.init();
});