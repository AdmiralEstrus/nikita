<?php
ini_set('display_errors', 0);
error_reporting(0);
session_start();

require_once(__DIR__ . '/components/Router.php');
require_once(__DIR__ . '/components/Db.php');

$router = new Router();
$router->run();
