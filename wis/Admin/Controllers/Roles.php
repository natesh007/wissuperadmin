<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\RolesModel;

class Roles extends BaseController
{

	function __construct()
	{
		$this->RolesModel = new RolesModel();
	}
	public function index($order = '', $sort = '', $starting = 0)
	{
		$data['pager'] = \Config\Services::pager();
		$uri = service('uri');
		$keyword = '';
		if ($this->request->getVar('key_word') != NULL) {
			$keyword = $this->request->getVar('key_word');
		} else if (isset($_GET['key_word'])) {
			$keyword = $_GET['key_word'];
		}

		if (isset($_GET['page'])) {

			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		if (isset($_REQUEST['nor']) && $_REQUEST['nor'] != '') {
			$perPage = $_GET['nor'];
		} else {
			$perPage = 10;
		}

		$roles = $this->RolesModel->get_roles($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['roles'] = $roles['results'];


		$data['pagelinks'] = $roles['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\roles', $data);
	}

	public function active_roles($order = '', $sort = '', $starting = 0)
	{
		session()->set('roles_page', '/active_roles');
		$data['pager'] = \Config\Services::pager();
		$uri = service('uri');
		$keyword = '';
		if ($this->request->getVar('key_word') != NULL) {
			$keyword = $this->request->getVar('key_word');
		} else if (isset($_GET['key_word'])) {
			$keyword = $_GET['key_word'];
		}
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		if (isset($_REQUEST['nor']) && $_REQUEST['nor'] != '') {
			$perPage = $_GET['nor'];
		} else {
			$perPage = 10;
		}
		$roles = $this->RolesModel->get_roles($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['roles'] = $roles['results'];
		$data['pagelinks'] = $roles['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\roles', $data);
	}
	public function inactive_roles($order = '', $sort = '', $starting = 0)
	{
		session()->set('roles_page', '/inactive_roles');
		$data['pager'] = \Config\Services::pager();
		$uri = service('uri');
		$keyword = '';
		if ($this->request->getVar('key_word') != NULL) {
			$keyword = $this->request->getVar('key_word');
		} else if (isset($_GET['key_word'])) {
			$keyword = $_GET['key_word'];
		}
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		if (isset($_REQUEST['nor']) && $_REQUEST['nor'] != '') {
			$perPage = $_GET['nor'];
		} else {
			$perPage = 10;
		}
		$roles = $this->RolesModel->get_roles($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['roles'] = $roles['results'];
		$data['pagelinks'] = $roles['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\roles', $data);
	}
	public function add_role()
	{
		if ($this->request->getMethod() == 'post') {
			$data = [
				'RoleName' => $this->request->getVar('RoleName'),
				'Priority' => $this->request->getVar('Priority'),
			];
			$save = $this->RolesModel->insert($data);
			return redirect()->to(base_url('admin/roles'))->with('msg', 'Data Saved Successfully');
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\role_form');
	}

	public function edit_role($id = null)
	{
		$data['roles'] = $this->RolesModel->where('RoleID', $id)->first();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'RoleName' => $this->request->getVar('RoleName'),
				'Priority' => $this->request->getVar('Priority'),
				
			];
			$this->RolesModel->update($id, $data);
			return redirect()->to(base_url('admin/roles'))->with('msg', 'Data Updated Successfully');
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\role_edit_form', $data);
	}
}
