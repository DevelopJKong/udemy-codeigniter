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
        
        $auth = service('auth');
        
        if ($auth->login($email, $password)) {
            
            $redirect_url = session('redirect_url') ?? '/';
            
			unset($_SESSION['redirect_url']);
            
            return redirect()->to($redirect_url)
                             ->with('info', 'Login successful');
                             
        } else {
            
            return redirect()->back()
                             ->withInput()
                             ->with('warning', 'Invalid login');
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
