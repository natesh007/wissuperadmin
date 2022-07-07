<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\DepartmentsModel;
use Modules\Admin\Models\BranchModel;
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
		$data['organizations'] = $model->getmasterdata('organization');
        //$data['branches'] = $model->getmasterdata('branches');
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		$cmodel = new DepartmentsModel();
		if ($this->request->getMethod() == 'post') {
			$departmentdata = [
				'DeptName'  => $this->request->getVar('DeptName'),
				'OrgID'  => $this->request->getVar('OrgID'),					
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
		$BranchModel = new BranchModel();
		//$data['departments'] = $model->getmasterdata('departments');
        $data['organizations'] = $model->getmasterdata('organization');
		
		$cmodel = new DepartmentsModel();
		$data['cat'] = $cmodel->where('DeptID', $DeptID)->first();
		$data['branches'] = $BranchModel->where('OrgID', $data['cat']['OrgID'])->findAll();
		$data['departments'] = $cmodel->where('OrgID',$data['cat']['OrgID'])->findAll();
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		if ($this->request->getMethod() == 'post') {
			$departmentdata = [
				'DeptName'  => $this->request->getVar('DeptName'),
				'OrgID'  => $this->request->getVar('OrgID'),				
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

	
	public function getbranches(){
        $BranchModel = new BranchModel();
        $orgid=$_POST['OrgID'];
        $branchesdata = $BranchModel->where('OrgID', $orgid)->findAll();
		//echo "<pre>";print_r($data['branches']);exit;
		//echo view('Modules\Admin\Views\branch_dropdown_ajax',$data);
		echo json_encode($branchesdata);       
    }

	public function getdepartments(){
        $DepartmentsModel = new DepartmentsModel();
        $orgid=$_POST['OrgID'];
        $data['departments'] = $DepartmentsModel->where('OrgID', $orgid)->findAll();
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		//echo "<pre>";print_r($data['departments']);exit;
		echo view('Modules\Admin\Views\departments_dropdown_ajax',$data);
		//echo json_encode($branchesdata);       
    }

	public function getBrdepartments(){
        $DepartmentsModel = new DepartmentsModel();
        $brid=$_POST['BrID'];
        $data['departments'] = $DepartmentsModel->whereIn('BrID', $brid)->findAll();
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		//echo "<pre>";print_r($data['departments']);exit;
		echo view('Modules\Admin\Views\departments_dropdown_ajax',$data);
		//echo json_encode($branchesdata);       
    }
	
}
