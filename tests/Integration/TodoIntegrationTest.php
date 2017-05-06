<?php

namespace Tests\Integration;

use Join\Todo;

final class TodoIntegrationTest extends ApiTestCase {

   public function testIndex() {
      $this->request('get', '/todos');
      $this->assertThatResponseHasStatus(200);
      $this->assertThatResponseHasContentType('application/json');
   }

   public function testCreate() {
      $this->request('POST', '/todos', [
          '_method' => 'POST',
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
          '_method' => 'PATCH',
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
          '_method' => 'PATCH',
          'completed' => '1'
      ]);
      $this->assertThatResponseHasStatus(200);
      $this->assertThatResponseHasContentType('application/json');
      $this->assertArrayHasKey('id', $this->responseData());

      $this->assertEquals(1, $this->responseData()['completed']);

      return Todo::find($this->responseData()['id']);
   }

   /** @depends testComplete */
   public function testDelete($todo) {
      $this->request('POST', '/todos/' . $todo->id, [
          '_method' => 'DELETE'
      ]);
      $this->assertThatResponseHasStatus(200);
   }

}
