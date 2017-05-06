<?php

namespace Join;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model {

   public static function allTodos() {
      return static::orderBy('vieworder', 'asc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
   }

   public static function findTodos($ids) {
      return static::whereIn('id', $ids)->orderBy('vieworder', 'asc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
   }

   public static function applyOrder($order) {
      foreach ($order as $key => $value) {
         $todo = Todo::find($key);
         if (!$todo) {
            throw new Exception('Could not find todo with id ' . $key);
         }
         $todo->vieworder = $value;
         $todo->save();
      }
   }

}
