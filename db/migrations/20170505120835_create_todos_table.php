<?php

require_once(__DIR__ . '/../db-config.php');

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;
use Phinx\Migration\AbstractMigration;

class CreateTodosTable extends AbstractMigration {

	public $capsule;
	public $schema;

	public function init() {
		$this->capsule = new Capsule;
		$this->capsule->addConnection([
			'driver' => DB_DRIV,
			'host' => DB_HOST,
			'port' => DB_PORT,
			'database' => DB_NAME,
			'username' => DB_USER,
			'password' => DB_PASS,
			'charset' => DB_CHAR,
			'collation' => DB_COLL,
		]);

		$this->capsule->bootEloquent();
		$this->capsule->setAsGlobal();
		$this->schema = $this->capsule->schema();
	}

	public function up() {
		$this->schema->create('todos', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('label');
			$table->integer('vieworder')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down() {
		$this->schema->dropIfExists('todos');
	}

}
