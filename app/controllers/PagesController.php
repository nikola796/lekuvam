<?php

namespace App\Controllers;

//use App\Core\App;
use App\Models\User;

class PagesController
{

    public function home()
    {
        if (User::isLogged()) {
            $userRecords = User::getRecords();
            return view('index', compact('userRecords'));
        }
        return view('index');
    }

    public function important()
    {

        return view('index');
    }

    public function login()
    {
        if (User::isLogged()) {
            redirect(uri());
            exit();
        } else {
            $text = 'Test 123';
        }
        return view('login', $text);
    }

    public function about()
    {
        return view('about');
    }

    public function success()
    {
        return view('success');
    }

    public function register()
    {
        return view('register');
    }

    public function notFound()
    {
        return view('404');
    }
}
