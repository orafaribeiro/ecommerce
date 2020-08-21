<?php
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

$app->notFound(function () use ($app) {

  http_response_code(404);
  echo "ok";
  exit;

});

define("URL", $_SERVER['REQUEST_URI']);

require_once("functions.php");
require_once("site.php");
require_once("admin.php");
require_once("admin-users.php");
require_once("admin-categories.php");
require_once("admin-products.php");
require_once("admin-orders.php");

$app->run();

 ?>