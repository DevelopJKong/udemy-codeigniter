<?php

namespace App\Controllers;

use App\Models\TaskModel;
use \App\Entities\Task;

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

    function new () {
        $task = new Task();

        return view('Tasks/new', [
            'task' => $task,
        ]);
    }

    public function create()
    {
        $model = new TaskModel();

        $task = new Task($this->request->getPost());

        $result = $model->insert($task);

        if ($result) {
            return redirect()->to("/tasks/show/{$model->insertID}")
                ->with('info', 'Task created successfully');
        } else {
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $model = new TaskModel();

        $task = $model->find($id);

        return view('Tasks/edit', [
            'task' => $task,
        ]);
    }

    public function update($id)
    {
        $model = new TaskModel();

        $result = $model->update($id, [
            'description' => $this->request->getPost('description'),
        ]);

        if ($result) {
            return redirect()->to("/tasks/show/$id")
                ->with('info', 'Task updated successfully');

        } else {
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();
        }

    }
}
