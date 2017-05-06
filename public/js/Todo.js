var Todo = angular.module('Todo', []);
Todo.controller('TodoController', function ($scope, $http) {
   $scope.loading;

   $scope.todos = [];

   $scope.all = function () {
      $scope.loading = true;
      $http.get('todos', {
      }).then(function (response) {
         var data = response.data;
         $scope.todos = data;
         $scope.loading = false;
      });
   }

   $scope.create = function () {
      $http.post('todos', {
         _method: 'POST',
         label: $scope.new
      }).then(function (response) {
         var data = response.data;
         $scope.new = null;
         $scope.todos.unshift(data);
      });
   }

   $scope.delete = function (id) {
      $http.post('todos/' + id, {
         _method: 'DELETE'
      }).then(function (response) {
         _.remove($scope.todos, {
            id: id
         });
      });
   }

   $scope.complete = function (id) {
      var todo = _.find($scope.todos, {id: id});
      var completed = !todo.completed;
      $http.post('todos/' + id, {
         _method: 'PATCH',
         completed: completed
      }).then(function (response) {
         todo.completed = completed;
      });
   }

   $scope.patch = function (id) {
      var todo = _.find($scope.todos, {id: id});
      $http.post('todos/' + id, {
         _method: 'PATCH',
         label: todo.label
      }).then(function (response) {
         todo.editing = false;
      });
   }

   $scope.completed = function () {
      return _.filter($scope.todos, function (todo) {
         if (todo.completed)
            return todo
      }).length;
   }

   $scope.remaining = function () {
      return $scope.todos.length - $scope.completed();
   }

   $scope.showOnly = function (status) {
      $scope.filter_completed = status;
   }

   $scope.init = function () {
      $scope.all();
   }

   $scope.init();
});