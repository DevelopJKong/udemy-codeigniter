<?php

namespace App\Controllers;

use App\Models\TaskModel;

class Tasks extends BaseController
{
    public function index()
    {
     
        $model = new TaskModel();
        $data = $model->findAll();


        return view('Tasks/index', ['tasks' => $data]);
    }

	public function show($id)
    {
        $model = new TaskModel();
		
        $task = $model->find($id);

		return view('Tasks/show', ['task' => $task]);
	}
}