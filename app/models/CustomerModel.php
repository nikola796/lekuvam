<?php
// app/models/CustomerModel.php
// echo "Hello";die();
// class CustomerModel {
//     dd($_SERVER['REQUEST_METHOD']);
//     private $db;

//     public function __construct($db) {
//         $this->db = $db;
//     }

//     public function registerCustomer($name, $email, $password) {
//         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//         $stmt = $this->db->prepare("INSERT INTO customers (name, email, password) VALUES (?, ?, ?)");
//         return $stmt->execute([$name, $email, $hashedPassword]);
//     }
// }
// ?>