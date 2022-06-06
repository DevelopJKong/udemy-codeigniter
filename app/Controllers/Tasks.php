<?php

namespace App\Controllers;

use App\Models\TaskModel;
use \App\Entities\Task;

class Tasks extends BaseController
{
    private $model;
	
	private $current_user;

    public function __construct()
    {
        $this->model = new TaskModel;
        $this->current_user = service('auth')->getCurrentUser();
    }

    public function index()
    {

       $data = $this->model->getTasksByUserId($this->current_user->id);

        return view('Tasks/index', ['tasks' => $data]);
    }

    public function show($id)
    {
        $task = $this->getTaskOr404($id);

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

        $task = new Task($this->request->getPost());


        $task->user_id = $this->current_user->id;

        $result = $this->model->insert($task);

        if ($result) {
            return redirect()->to("/tasks/show/{$this->model->insertID}")
                ->with('info', 'Task created successfully');
        } else {
            return redirect()->back()
                ->with('errors', $this->model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();
        }
    }

    public function edit($id)
    {

        $task = $this->getTaskOr404($id);

        return view('Tasks/edit', [
            'task' => $task,
        ]);
    }

    public function update($id)
    {
        $task = $this->getTaskOr404($id);

        $post = $this->request->getPost();
        unset($post['user_id']);

        $task->fill($post);

        if (!$task->hasChanged()) {
            return redirect()->back()
                ->with('warning', 'Nothing to update')
                ->withInput();
        }

        if ($this->model->save($task)) {
            return redirect()->to("/tasks/show/$id")
                ->with('info', 'Task updated successfully');

        } else {
            return redirect()->back()
                ->with('errors', $this->model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();
        }

    }

    public function delete($id)
    {
        $task = $this->getTaskOr404($id);

        if ($this->request->getMethod() === 'post') {

            $this->model->delete($id);

            return redirect()->to('/tasks')
                ->with('info', 'Task deleted');
        }

        return view('Tasks/delete', [
            'task' => $task,
        ]);
    }

    private function getTaskOr404($id)
    {
        $user = service('auth')->getCurrentUser();

        $task = $this->model->find($id);

        $task = $this->model->getTaskByUserId($id,$this->current_user->id);

        if ($task === null) {
            throw new \Codeigniter\Exceptions\PageNotFoundException("Task with id $id not found");
        }
        return $task;
    }
}
