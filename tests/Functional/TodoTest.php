<?php

namespace Tests\Functional;

use Join\Todo;
use Join\EloquentCapsule;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use \PHPUnit_Framework_TestCase as TestCase;

final class TodoTest extends TestCase {

   public function __construct() {
      $this->schema = EloquentCapsule::schema();
   }

   public function testTodoAllIsArray() {
      $todos = Todo::allTodos();
      $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $todos);
   }

   public function testCanSaveAndDeleteTodo() {
      $count = Todo::count();

      $newtodo = new Todo();
      $newtodo->label = 'Test';
      $newtodo->save();

      $this->assertEquals($count + 1, Todo::count());

      $newtodo->delete();

      $this->assertEquals($count, Todo::count());
   }

   public function testCanSaveOrder() {
      $newtodos_ids = [];

      //create new todos
      for ($i = 0; $i < 3; $i++) {
         $newtodo = new Todo();
         $newtodo->label = 'Todo #' . ($i + 1);
         $newtodo->save();
         $newtodos_ids[] = $newtodo->id;
      }

      // create order array id => order
      for ($i = 0; $i < count($newtodos_ids); $i++) {
         $neworder[$newtodos_ids[$i] . ''] = $i + 1;
      }

      // save current order
      Todo::applyOrder($neworder);

      $labels = [];

      foreach (Todo::findTodos($newtodos_ids) as $todo) {
         $labels[] = $todo->label;
      }

      $this->assertEquals(['Todo #1', 'Todo #2', 'Todo #3'], $labels);

      // invert order
      $newtodos_ids = array_reverse($newtodos_ids);

      for ($i = 0; $i < count($newtodos_ids); $i++) {
         $neworder[$newtodos_ids[$i] . ''] = $i + 1;
      }

      // save current order
      Todo::applyOrder($neworder);

      $labels = [];

      foreach (Todo::findTodos($newtodos_ids) as $todo) {
         $labels[] = $todo->label;
         
         $todo->delete();
      }

      $this->assertEquals(['Todo #3', 'Todo #2', 'Todo #1'], $labels);
   }

}
