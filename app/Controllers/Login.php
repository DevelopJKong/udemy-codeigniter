<?php

namespace App\Controllers;

use App\Libraries\Authentication;
use Config\Services;

class Login extends BaseController
{
    function new () {
        return view('Login/new');
    }

    public function create()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // $auth = Services::auth();
        $auth = service('auth');

        if ($auth->login($email, $password)) {
            return redirect()->to('/')
                ->with('info', 'Login successful');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('warning', 'Invalid Login');
        }

    }
    public function delete()
    {
        $auth = service('auth');

        $auth->logout();

        return redirect()->to('/login/showLogoutMessage');
    }

    public function showLogoutMessage()
    {
        return redirect()->to('/')
            ->with('info', 'Logout successful');
    }
}
