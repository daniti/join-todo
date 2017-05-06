<?php

namespace Join;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model {

   protected $fillable = ['label', 'completed', 'vieworder'];

   public static function allTodos() {
      return static::orderBy('vieworder', 'asc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
   }

   public static function findTodos($ids) {
      return static::whereIn('id', $ids)->orderBy('vieworder', 'asc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
   }

   public static function applyOrder($order) {
      
      $i = 0;
      foreach ($order as $key) {
         $todo = Todo::find($key);
         if (!$todo) {
            throw new Exception('Could not find todo with id ' . $key);
         }
         $todo->vieworder = ++$i;
         $todo->save();
      }
   }

}
