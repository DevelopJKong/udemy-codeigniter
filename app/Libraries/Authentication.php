<?php

namespace App\Libraries;

use App\Models\UserModel;

class Authentication
{
    private $user;

    public function login($email, $password)
    {
        $model = new UserModel();

        $user = $model->findByEmail($email);

        if ($user === null) {
            return false;
        }

        if (!$user->verifyPassword($password)) {
            return false;
        }

        $session = session();
        $session->regenerate(); // 이렇게 해주는 정확한 이유는 뭐지?
        $session->set('user_id', $user->id);

        return true;
    }

    public function logout()
    {
        session()->destroy();
    }

    public function getCurrentUser()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        if ($this->user === null) {
            $model = new UserModel();

            $this->user = $model->find(session()->get('user_id'));
        }
        return $this->user;
    }

    public function isLoggedIn()
    {
        return session()->has('user_id');
    }

}
