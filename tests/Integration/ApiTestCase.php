<?php

namespace Tests\Integration;

use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

abstract class ApiTestCase extends \PHPUnit_Framework_TestCase {

   /** @var Response */
   private $response;

   /** @var App */
   private $app;

   const WITH_MIDDLEWARE = true;

   public static function environment() {
      $settings = require __DIR__ . '/../../src/settings.php';
      $app = new App($settings);

      // Set up dependencies
      require __DIR__ . '/../../src/dependencies.php';

      // Register middleware
      if (static::WITH_MIDDLEWARE) {
         require __DIR__ . '/../../src/middleware.php';
      }

      // Register routes
      require __DIR__ . '/../../src/routes.php';

      // Process the application
      return $app;
   }

   protected function request($method, $url, array $requestParameters = []) {
      $request = $this->prepareRequest($method, $url, $requestParameters);
      $response = new Response();

      $app = $this->app;
      $this->response = $app($request, $response);
   }

   protected function assertThatResponseHasStatus($expectedStatus) {
      $this->assertEquals($expectedStatus, $this->response->getStatusCode());
   }

   protected function assertThatResponseHasContentType($expectedContentType) {
      $exploded = [];
      foreach ($this->response->getHeader('Content-Type') as $contenttype) {
         foreach (explode(';', $contenttype) as $partial) {
            $exploded[] = trim($partial);
         }
      }
      $this->assertContains($expectedContentType, $exploded);
   }

   protected function responseData() {
      return json_decode((string) $this->response->getBody(), true);
   }

   protected function setUp() {
      $this->app = static::environment();
   }

   protected function tearDown() {
      $this->app = null;
      $this->response = null;
   }

   private function prepareRequest($method, $url, array $requestParameters) {
      $env = Environment::mock([
                  'SCRIPT_NAME' => '/index.php',
                  'REQUEST_URI' => $url,
                  'REQUEST_METHOD' => $method,
      ]);

      $parts = explode('?', $url);

      if (isset($parts[1])) {
         $env['QUERY_STRING'] = $parts[1];
      }

      $uri = Uri::createFromEnvironment($env);
      $headers = Headers::createFromEnvironment($env);
      $cookies = [];

      $serverParams = $env->all();

      $body = new RequestBody();
      $body->write(json_encode($requestParameters));

      $request = new Request($method, $uri, $headers, $cookies, $serverParams, $body);

      return $request->withHeader('Content-Type', 'application/json');
   }

}
