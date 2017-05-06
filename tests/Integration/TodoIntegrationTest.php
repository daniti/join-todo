<?php

namespace Tests\Integration;

use Join\Todo;

final class TodoIntegrationTest extends ApiTestCase {

   public function testIndex() {
      $this->request('get', '/todos');
      $this->assertThatResponseHasStatus(200);
      $this->assertThatResponseHasContentType('application/json');
   }

   public function testCannotCreateEmptyTask() {
      $this->request('POST', '/todos', [
          '_METHOD' => 'POST',
          'label' => ''
      ]);
      $this->assertThatResponseHasStatus(400);
   }

   public function testCreate() {
      $this->request('POST', '/todos', [
          '_METHOD' => 'POST',
          'label' => 'New test todo'
      ]);
      $this->assertThatResponseHasStatus(201);
      $this->assertThatResponseHasContentType('application/json');
      $this->assertArrayHasKey('id', $this->responseData());
      return Todo::find($this->responseData()['id']);
   }

   /** @depends testCreate */
   public function testEditLabel($todo) {
      $this->request('POST', '/todos/' . $todo->id, [
          '_METHOD' => 'PATCH',
          'label' => 'Modified label'
      ]);
      $this->assertThatResponseHasStatus(200);
      $this->assertThatResponseHasContentType('application/json');
      $this->assertArrayHasKey('id', $this->responseData());

      $this->assertEquals('Modified label', $this->responseData()['label']);

      return Todo::find($this->responseData()['id']);
   }

   /** @depends testCreate */
   public function testComplete($todo) {
      $this->request('POST', '/todos/' . $todo->id, [
          '_METHOD' => 'PATCH',
          'completed' => '1'
      ]);
      $this->assertThatResponseHasStatus(200);
      $this->assertThatResponseHasContentType('application/json');
      $this->assertArrayHasKey('id', $this->responseData());

      $this->assertEquals(1, $this->responseData()['completed']);

      return Todo::find($this->responseData()['id']);
   }

   public function testOrder() {
      $newtodos_ids = [];

      //create new todos
      for ($i = 0; $i < 3; $i++) {
         $newtodo = new Todo();
         $newtodo->label = 'Todo #' . ($i + 1);
         $newtodo->save();
         $newtodos_ids[] = $newtodo->id;
      }

      $this->request('POST', '/todos', [
          '_METHOD' => 'PATCH',
          'order' => $newtodos_ids
      ]);
      $this->assertThatResponseHasStatus(200);

      foreach (Todo::findTodos($newtodos_ids) as $todo) {
         $todo->delete();
      }
   }

   /** @depends testComplete */
   public function testDelete($todo) {
      $this->request('POST', '/todos/' . $todo->id, [
          '_METHOD' => 'DELETE'
      ]);
      $this->assertThatResponseHasStatus(200);
   }

}
