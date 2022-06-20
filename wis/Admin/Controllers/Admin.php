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
	//Common Functions
	public function activate_inactivate()
	{
		$data = [
			'Status' => $this->request->getVar('status'),
			'UpdatedBy' => session()->get('Aid'),
			'UpdatedDate' => date('Y-m-d H:i:s'),
		];
		$res = $this->AdminsModel->activate_inactivate($this->request->getVar('Id'), $this->request->getVar('table'), $this->request->getVar('column'), $data);
		echo 1;
		exit;
	}

	public function delete()
	{
		$res = $this->AdminsModel->deletedata($this->request->getVar('Id'), $this->request->getVar('table'), $this->request->getVar('column'), $this->request->getVar('Image'), $this->request->getVar('Thumb'));
		echo 1;
		exit;
	}

	public  function active_inactive_all()
	{
		if ($this->request->getVar('checkbox_value')) {
			$id = $this->request->getVar('checkbox_value');
			for ($i = 0; $i < count($id); $i++) {
				$data = [
					'Status' => $this->request->getVar('status'),
					'UpdatedBy' => session()->get('aid'),
					'UpdatedDate' => date('Y-m-d H:i:s'),
				];
				$res = $this->AdminsModel->activate_inactivate($id[$i], $this->request->getVar('table'), $this->request->getVar('column'), $data);
			}
			echo 1;
		}
	}

	public  function delete_all()
	{
		if ($this->request->getVar('checkbox_value')) {
			$id = $this->request->getVar('checkbox_value');
			for ($i = 0; $i < count($id); $i++) {
				$res = $this->AdminsModel->deletedata($id[$i], $this->request->getVar('table'), $this->request->getVar('column'), $this->request->getVar('Image'), $this->request->getVar('Thumb'));
			}
			echo 1;
		}
	}

	public  function changerowpriority()
	{	
		$i = 1;
		foreach ($this->request->getVar('Priority') as $k => $v) {
			$this->AdminsModel->changepriority($i, $v, $this->request->getVar('Table'), $this->request->getVar('ColOne'), $this->request->getVar('ColTwo'));
			$i++;
		}
		echo 1;
		exit;
	}
	public function common_form_validation()
	{
		if ($this->request->getMethod() == 'post') {
			$rules = [
				'Name' =>
				[
					'rules'  => 'required|is_unique[' . $this->request->getVar('Table') . '.' . $this->request->getVar('UniqueColoumn') . ']',
					'errors' =>
					[
						'required' => $this->request->getVar('ColoumnName') . ' shouldn\'t be empty.',
						'is_unique' => 'This '. $this->request->getVar('ColoumnName') .' is already existing in our data base.So please try with another.',
					]
				],
			];
			$errorstring = '';
			if (!$this->validate($rules)) {
				$errorstring .= 'Name~' . $this->validator->showError('Name');
				print $errorstring;
				exit;
			}
		}
	}
	public function common_edit_form_validation()
	{
		if ($this->request->getMethod() == 'post') {
			$rules = [
				'Name' =>
				[
					'rules'  => 'required|is_unique[' . $this->request->getVar('Table') . '.' . $this->request->getVar('UniqueColoumn') . ',' . $this->request->getVar('AutoIncColoumn') . ',' . $this->request->getVar('AutoIncVal') . ']',
					'errors' =>
					[
						'required' => $this->request->getVar('ColoumnName') . ' shouldn\'t be empty.',
						'is_unique' => 'This '. $this->request->getVar('ColoumnName') .' is already existing in our data base.So please try with another.',
					]
				],
			];
			$errorstring = '';
			if (!$this->validate($rules)) {
				$errorstring .= 'Name~' . $this->validator->showError('Name');
				print $errorstring;
				exit;
			}
		}
	}
	public function pagenotfound(){
		if(session()->get('AID') != null) {
			echo view('Modules\Admin\Views\common\header');
			echo view('Modules\Admin\Views\pagenotfound');
		}
	}
	public function logout(){
		session()->destroy();
		return redirect()->to(base_url('admin'));
	}
}
