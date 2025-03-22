<?php
// app/controllers/CustomerController.php

require_once '../models/CustomerModel.php';

class CustomerController {
    private $model;

    public function __construct($db) {
        $this->model = new CustomerModel($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->model->registerCustomer($name, $email, $password)) {
                header('Location: /success');
                exit;
            } else {
                echo "Registration failed!";
            }
        } else {
            require '../views/customer/register.php';
        }
    }

    public function success() {
        require '../views/customer/success.php';
    }
}
?>