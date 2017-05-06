<?php

namespace Join;

require_once(__DIR__ . '/../db/db-config.php');

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentCapsule {

   public static function schema() {
      $capsule = new Capsule;
      $capsule->addConnection([
          'driver' => DB_DRIV,
          'host' => DB_HOST,
          'port' => DB_PORT,
          'database' => DB_NAME,
          'username' => DB_USER,
          'password' => DB_PASS,
          'charset' => DB_CHAR,
          'collation' => DB_COLL,
      ]);
      $capsule->bootEloquent();
      $capsule->setAsGlobal();
      return $capsule->schema();
   }

}
