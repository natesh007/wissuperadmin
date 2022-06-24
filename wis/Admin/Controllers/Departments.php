<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\DepartmentsModel;
use Modules\Admin\Models\AdminsModel;


class departments extends BaseController
{

	public function index($order = '', $sort = '', $starting = 0)
	{
		session()->set('departments_page', '/departments');
		$data['pager'] = \Config\Services::pager();
		$model = new DepartmentsModel();
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

		if (isset($_REQUEST['nor']) && $_REQUEST['nor'] != '' && $_REQUEST['nor'] != '') {
			$perPage = $_GET['nor'];
		} else {
			$perPage = 10;
		}

		$departments = $model->get_departments($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['departments'] = $departments['results'];


		$data['pagelinks'] = $departments['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\departments', $data);
	}
	function buildTree(array $flatList)
	{
		$grouped = [];
		foreach ($flatList as $node) {
			$grouped[$node['ParentDept']][] = $node;
		}

		$fnBuilder = function ($siblings) use (&$fnBuilder, $grouped) {
			foreach ($siblings as $k => $sibling) {
				$id = $sibling['DeptID'];
				if (isset($grouped[$id])) {
					$sibling['children'] = $fnBuilder($grouped[$id]);
				}
				$siblings[$k] = $sibling;
			}
			return $siblings;
		};

		$tree = (isset($grouped[0])) ? $fnBuilder($grouped[0]) : '';

		return $tree;
	}
	public function active_departments($order = '', $sort = '', $starting = 0)
	{
		session()->set('departments_page', '/active_departments');
		$data['pager'] = \Config\Services::pager();
		$model = new DepartmentsModel();
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
		$departments = $model->get_departments($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['departments'] = $departments['results'];
		$data['pagelinks'] = $departments['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\departments', $data);
	}
	public function inactive_departments($order = '', $sort = '', $starting = 0)
	{
		session()->set('departments_page', '/inactive_departments');
		$data['pager'] = \Config\Services::pager();
		$model = new DepartmentsModel();
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
		$departments = $model->get_departments($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['departments'] = $departments['results'];
		$data['pagelinks'] = $departments['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\departments', $data);
	}

	public function add_department()
	{
		$model = new AdminsModel();
		$data['departments'] = $model->getmasterdata('departments');
        $data['branches'] = $model->getmasterdata('branches');
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		$cmodel = new DepartmentsModel();
		if ($this->request->getMethod() == 'post') {
			$departmentdata = [
				'DeptName'  => $this->request->getVar('DeptName'),
				'DeptURL'  => $this->request->getVar('DeptURL'),				
				'BrID'  => $this->request->getVar('BrID'),
                'Status' => 1
			];
			if ($this->request->getVar('ParentDept') != '') {
				$departmentdata['ParentDept'] = $this->request->getVar('ParentDept');
			}
			
			$save = $cmodel->insert($departmentdata);
			if ($save) {
				$msg = 'Data inserted successfully.';
				return redirect()->to(base_url('admin/departments'))->with('msg', $msg);
			}
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\department_form', $data);
	}
	public function edit_department($DeptID  = null)
	{
		$model = new AdminsModel();
		$data['departments'] = $model->getmasterdata('departments');
        $data['branches'] = $model->getmasterdata('branches');
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		$cmodel = new DepartmentsModel();
		$data['cat'] = $cmodel->where('DeptID', $DeptID)->first();
		if ($this->request->getMethod() == 'post') {
			$departmentdata = [
				'DeptName'  => $this->request->getVar('DeptName'),
				'DeptURL'  => $this->request->getVar('DeptURL'),				
				'BrID'  => $this->request->getVar('BrID'),
			];
			if ($this->request->getVar('ParentDept') != '') {
				$departmentdata['ParentDept'] = $this->request->getVar('ParentDept');
			}
			
			$cmodel->update($DeptID, $departmentdata);
			$msg = 'Data updated successfully.';
			return redirect()->to(base_url('admin/departments'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\department_edit_form', $data);
	}
	public function departmentsajax()
	{
		if ($this->request->getMethod() == 'post') {
			$rules = [
				'DeptName' =>
				[
					'rules'  => 'required|is_unique[departments.DeptName]',
					'errors' =>
					[
						'required' => 'department Name field shouldn\'t be empty.',
						'is_unique' => 'This department Name is already existing in our data base.So please try with another.',
					]
				],
				'DeptURL' =>
				[
					'rules'  => 'required|regex_match[/^[a-zA-Z0-9&-]*$/]|is_unique[departments.DeptURL]',
					'errors' =>
					[
						'required' => 'department Url field shouldn\'t be empty.',
						'is_unique' => 'This department Url is already existing in our data base.So please try with another.',
						'regex_match' => 'department Url field shouldn\'t allows any special characters (- and &) and space.',
					]
				],
			];
			$errorstring = '';
			if (!$this->validate($rules)) {
				$errorstring .= 'DeptName~' . $this->validator->showError('DeptName') . ',DeptURL~' . $this->validator->showError('DeptURL');
				print $errorstring;
				exit;
			}
		}
	}
	public function updatedepartmentsajax()
	{
		if ($this->request->getMethod() == 'post') {
			$rules = [
				'DeptName' =>
				[
					'rules'  => 'required|is_unique[departments.DeptName,DeptID,' . $this->request->getVar('DeptID') . ']',
					'errors' =>
					[
						'required' => 'department Name field shouldn\'t be empty.',
						'is_unique' => 'This department Name is already existing in our data base.So please try with another.',
					]
				],
				'DeptURL' =>
				[
					'rules'  => 'required|regex_match[/^[a-zA-Z0-9&-]*$/]|is_unique[departments.DeptURL,DeptID,' . $this->request->getVar('DeptID') . ']',
					'errors' =>
					[
						'required' => 'department Url field shouldn\'t be empty.',
						'regex_match' => 'department Url field shouldn\'t allows any special characters (- and &) and space.',
						'is_unique' => 'This department Url is already existing in our data base.So please try with another.',
					]
				],
			];
			$errorstring = '';
			if (!$this->validate($rules)) {
				$errorstring .= 'DeptName~' . $this->validator->showError('DeptName') . ',DeptURL~' . $this->validator->showError('DeptURL');
				print $errorstring;
				exit;
			}
		}
	}
	
}
