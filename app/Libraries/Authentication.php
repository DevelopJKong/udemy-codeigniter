<?php

namespace App\Libraries;

use App\Models\UserModel;

class Authentication
{
    public function login($email,$password)
    {
        $model = new UserModel();

        $user = $model->where('email',$email)
                    ->first();

        if($user === null) {
            return false; 
        } 

        if(!password_verify($password,$user->password_hash)) {
            return false;
        }


        $session =session();
        $session->regenerate(); // 이렇게 해주는 정확한 이유는 뭐지?
        $session->set('user_id',$user->id);

        return true;
    }

    public function logout()
    {
        session()->destroy();
    }


}