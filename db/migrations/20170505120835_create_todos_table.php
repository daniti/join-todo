<?php

require_once(__DIR__ . '/../db-config.php');

use Phinx\Migration\AbstractMigration;
use Join\EloquentCapsule;
use Illuminate\Database\Schema\Blueprint;

class CreateTodosTable extends AbstractMigration {

   public $schema;

   public function init() {
      $this->schema = EloquentCapsule::schema();
   }

   public function up() {
      $this->schema->create('todos', function (Blueprint $table) {
         $table->increments('id')->unsigned();
         $table->string('label');
         $table->integer('vieworder')->unsigned()->nullable();
         $table->boolean('completed')->default(0);
         $table->timestamps();
      });
   }

   public function down() {
      $this->schema->dropIfExists('todos');
   }

}
