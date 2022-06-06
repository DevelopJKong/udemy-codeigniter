<?php 

namespace App\Controllers\Admin;

use App\Entities\User;

class Users extends \App\Controllers\BaseController
{
    private $model;
    
    public function __construct()
    {
        $this->model = new \App\Models\UserModel;
    }
    
    public function index()
	{
        $users = $this->model->orderBy('id')
                             ->paginate(5);
        
		return view('Admin/Users/index', [
            'users' => $users,
            'pager' => $this->model->pager
        ]);
    }
    
    public function show($id)
    {
        $user = $this->getUserOr404($id);
		
		return view('Admin/Users/show', [
            'user' => $user
        ]);
	}

    function new () {
        $user = new User();

        return view('Admin/Users/new', [
            'user' => $user,
        ]);
    }

    public function create()
    {

        $user = new User($this->request->getPost());

        $result = $this->model->insert($user);

        if ($result) {
            return redirect()->to("/admin/users/show/{$this->model->insertID}")
                ->with('info', 'User created successfully');
        } else {
            return redirect()->back()
                ->with('errors', $this->model->errors())
                ->with('warning', 'Invalid data')
                ->withInput();
        }
    }

    public function edit($id)
    {

        $user = $this->getUserOr404($id);

        return view('Admin/Users/edit', [
            'user' => $user,
        ]);
    }



    private function getUserOr404($id)
	{
        $user = $this->model->where('id', $id)
                            ->first();
		
		if ($user === null) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException("User with id $id not found");
			
		}		
		
		return $user;
	}
}