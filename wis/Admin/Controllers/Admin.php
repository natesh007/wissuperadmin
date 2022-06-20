<?php namespace Modules\Admin\Controllers;

use Modules\Admin\Models\AdminsModel;

class Admin extends BaseController
{
	function __construct()
	{
		$this->AdminsModel = new AdminsModel();
	}
	public function index()
	{
		if ($this->request->getMethod() == 'post') {
			$result = $this->AdminsModel->where('Email', $this->request->getVar('Email'))->where('Password', md5($this->request->getVar('Password')))->first();
			if (!empty($result)) {
				$loggedin_user = array(
					'is_logged_in' => true,
					'AID' => $result['AID'],
					'Email' =>  $result['Email'],
					'Name' =>  $result['Name'],
					'Role' =>  $result['Role']
				);
				session()->set($loggedin_user);
				return redirect()->to(base_url('admin/users'));
			}else{
				return redirect()->to(base_url('admin'))->with('errmsg', 'Wrong credentials.');
			}
		}
		echo view('Modules\Admin\Views\login');
	}
	public function users()
	{
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\users');
	}
	public function logout(){
		session()->destroy();
		return redirect()->to(base_url('admin'));
	}
}
