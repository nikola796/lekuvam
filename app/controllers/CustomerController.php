<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Post;
//use App\Models\Patient;

//dd($_SERVER['REQUEST_METHOD']);
class CustomerController {
    private $user;
    private $post;
    //private $model;

    // public function __construct($db) {
    //     $this->model = new User($db);
    // }
    public function __construct()
    {
        $this->user = new User();
        $this->post = new Post();
    }

    public function register() {
        //$user = User::getUser(1);
        //dd($_SERVER['REQUEST_METHOD']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $userData = [
                'name' => $name,
                'email' => $email,
                'pass' => password_hash($password, PASSWORD_BCRYPT),
            ];
            $user_info = $this->user->isUserExist($userData); // check if user exist in DB
            if (count($user_info) === 0) {
                $result = $this->user->createUser($userData);
                if ($result['row_counts'] == 1) {
                    $_SESSION['is_logged'] = true;
                    $_SESSION['username'] = $userData['name'];
                    $_SESSION['user_id'] = $result['user_id'];
                    header('Location: ./success');
                    exit;
                } else {
                    echo "Registration failed!";
                }
            } else {
                echo 'Вече съществува потребител с това потребителско име или с този мейл';
            }
        } else {
            require 'app/views/register.php';
        }
    }

    public function success() {
        require '../views/customer/success.php';
    }

    public function getUser($id) {
        $user = User::getUser($id);
        return view('user', compact('user'));
    }

    public function getUsers()
    {
        $users = $this->user->getAllUsers();
        return view('users',  compact('users'));
    }

    public function createUser()
    {
        //echo $_POST;
        //return;
        $user_data = $_POST;
        $user_info = $this->user->isUserExist($user_data); // check if user exist in DB

        //if ($user_data['action'] == 'add') {
            if (count($user_info) === 0) {
                // if($user_data['role'] > 1){
                //     $access = $this->user->checkFoldersReations($user_data['access']);
                // }


                unset($user_data['action'], $user_data['id'], $user_data['access']);

                $result = $this->user->createUser($user_data);
                if ($result['row_counts'] == 1) {
                    $_SESSION['is_logged'] = true;
                    $_SESSION['username'] = $user_data['name'];
                    $_SESSION['user_id'] = $result['user_id'];
                    echo 'Успешно се регистрирахте!';
                } else {
                    $result;
                }
            } else if (count($user_info) === 1) {
                echo($user_info[0]['active'] == 0 ? 'Вече съществува деактивиран потребител с това потребителско име или с този мейл. Използвайте други данни, за да създадете нов потребител или активирайте този потребител от меню Потребители' : 'Вече съществува потребител с това потребителско име или с този мейл');
            } else {
                echo 'Съществуват повече от едни записа с това потребителско име или с този мейл';
            }
        // } elseif ($user_data['action'] == 'edit') {
        //     $access = $this->user->checkFoldersReations($user_data['access']);

        //     unset($user_data['pass'], $user_data['action'], $user_data['access']);

        //     $result = $this->user->editUser($user_data, $access);
        //     echo($result == 1 ? 'Успешно редактирахте потребителя' : '');
        // }
    }

    public function login()
    {
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return view('login');
        }
        $user_data = $_POST;
        $user_info = $this->user->isUserExist($user_data);
        if (count($user_info) === 1) {
            $_SESSION['is_logged'] = true;
            $_SESSION['username'] = $user_info[0]['user_name'];
            $_SESSION['user_id'] = $user_info[0]['user_id'];
            header('Location: ./home');
            exit;
        } else {
            echo 'Грешно потребителско име или парола';
        }
    }
    public function logout()
    {
        if (User::isLogged()) {
            User::logout();
            redirect(uri());
            exit();
        } else {
            $text = 'Test 123';
        }
        return view('login', $text);
    }
    public function savePost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $patient = $_POST['patient'];
            // $simptome = $_POST['simptome'];
            // $treatment = $_POST['treatment'];
            // $physician = $_POST['physician'];
            // $date = $_POST['date'];
            // $notes = $_POST['notes'];

            // Save the data to the database or perform any other action
            // For example, you can use a model to save the data
            // :patient, :simptome, :treatment, :physician, :notes
            $data = array(
                'patient' => $_POST['patient'],
                'simptome' => $_POST['simptome'],
                'treatment' => $_POST['treatment'],
                'physician' => $_POST['physician'],
                'notes' => $_POST['notes']
            );
            $postId = $this->post->create($data);
            return view('index', compact('postId'));
        }
    }
}
?>