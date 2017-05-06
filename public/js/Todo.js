var Todo = angular.module('Todo', ['ui.sortable']);

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
         _METHOD: 'POST',
         label: $scope.new
      }).then(function (response) {
         var data = response.data;
         $scope.new = null;
         $scope.todos.unshift(data);
      });
   }

   $scope.delete = function (id) {
      $http.post('todos/' + id, {
         _METHOD: 'DELETE'
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
         _METHOD: 'PATCH',
         completed: completed
      }).then(function (response) {
         todo.completed = completed;
      });
   }

   $scope.patch = function (id) {
      var todo = _.find($scope.todos, {id: id});
      $http.post('todos/' + id, {
         _METHOD: 'PATCH',
         label: todo.label
      }).then(function (response) {
         todo.editing = false;
      });
   }

   $scope.order = function () {
      $http.post('todos', {
         _METHOD: 'PATCH',
         order: _.map($scope.todos, 'id')
      }).then(function (response) {
      });
   }

   $scope.whoIsCompleted = function () {
      return _.filter($scope.todos, function (todo) {
         if (todo.completed)
            return todo;
      });
   }

   $scope.completed = function () {
      return $scope.whoIsCompleted().length;
   }

   $scope.clear = function () {
      _.each($scope.whoIsCompleted(), function (todo) {
         $scope.delete(todo.id);
      });

   }

   $scope.remaining = function () {
      return $scope.todos.length - $scope.completed();
   }

   $scope.showOnly = function (status) {
      $scope.filter_completed = status;
   }

   $scope.sortableTodos = {
      stop: function (e, ui) {
         $scope.order();
      }
   };

   $scope.init = function () {
      $scope.all();
   }

   $scope.init();
});