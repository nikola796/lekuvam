<?php
// public/index.php
echo "hello"; due();
require_once '../config/database.php';
require_once '../app/controllers/CustomerController.php';

// Database connection
//$db = new PDO('mysql:host=localhost;dbname=', '', '');

$controller = new CustomerController($db);
echo "hello"; due();

$action = isset($_GET['action']) ? $_GET['action'] : 'register';

if ($action == 'register') {
    $controller->register();
} elseif ($action == 'success') {
    $controller->success();
}
?>