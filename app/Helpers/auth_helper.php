<?php

use App\Models\UserModel;

if(!function_exists('current_user')) {

    function current_user()
    {
        if( ! session()->has('user_id')) {
            return null;
        }

        $model = new UserModel();

        return $model->find(session()->get('user_id'));
        
    }

}