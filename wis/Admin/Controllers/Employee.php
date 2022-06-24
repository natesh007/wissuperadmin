<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\EmployeeModel;
use Modules\Admin\Models\AdminsModel;

class Employee extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('employee_page', '/employees');
		$data['pager'] = \Config\Services::pager();
		$model = new EmployeeModel();
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

		$employee = $model->get_employees($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['employee'] = $employee['results'];


		$data['pagelinks'] = $employee['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\employee', $data);
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
    public function active_employees($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('employee_page', '/active_employees');
		$data['pager'] = \Config\Services::pager();
		$model = new EmployeeModel();
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
		$employee = $model->get_employees($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['employee'] = $employee['results'];
		$data['pagelinks'] = $employee['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\employee', $data);
	}
	public function inactive_employees($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('employee_page', '/inactive_employees');
		$data['pager'] = \Config\Services::pager();
		$model = new EmployeeModel();
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
		$employee = $model->get_employees($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['employee'] = $employee['results'];
		$data['pagelinks'] = $employee['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\employee', $data);
	}

    public function add_employee()
	{
		helper(['url', 'form']);       
		$EmployeeModel = new EmployeeModel();
        $AdminsModel = new AdminsModel();
       
        $data['departments'] = $AdminsModel->getmasterdata('departments');
        $data['roles'] = $AdminsModel->getmasterdata('roles');
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		$data['error']="";
		if ($this->request->getMethod() == 'post') {
			if($this->request->getVar('EmailID')!=""){
				$exist_emp = $EmployeeModel->where('EmailID', $this->request->getVar('EmailID'))->first();
				if(!$exist_emp){
					$data = [
						'RoleID' => $this->request->getVar('RoleID'),
						'EmpName' => $this->request->getVar('EmpName'),                
						'DeptID' => $this->request->getVar('ParentDept'),                
						'Gender' => ($this->request->getVar('Gender')==""?'':$this->request->getVar('Gender')),
						'EmailID' => $this->request->getVar('EmailID'),
						'password' => md5('123456'),
						'Address' => $this->request->getVar('Address'),
						'Contact' => $this->request->getVar('Contact'),
						'JobType' => $this->request->getVar('JobType'),
						'City' => $this->request->getVar('City'),
						'DateOfJoining' => $this->request->getVar('DateOfJoining'),
						'Doc' => '',
						'ProfilePic' =>'',
						'Status' => 1
					];
					if ($this->request->getVar('ParentDept') != '') {
						$departmentdata['ParentDept'] = $this->request->getVar('ParentDept');
					}
					$save = $EmployeeModel->insert($data);
					
					$msg = 'Data Saved Successfully';
					return redirect()->to(base_url('admin/employees'))->with('msg', $msg);
				}else{
					$data['error'] = 'Email ID alreay Exist!';
					//return redirect()->to(base_url('admin/add_employee'))->with('msg', $error);
					
				}
			}
			
		}
		//echo "<pre>";print_r($data);exit;
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\employee_form',$data);
	}

	public function edit_employee($id = null)
	{
		
		$EmployeeModel = new EmployeeModel();
        $AdminsModel = new AdminsModel();
        $data['departments'] = $AdminsModel->getmasterdata('departments');
        $data['roles'] = $AdminsModel->getmasterdata('roles');
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		$data['employee'] = $EmployeeModel->where('EmpID  ', $id)->first();
        
		//echo "<pre>";print_r($data['employees']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'RoleID' => $this->request->getVar('RoleID'),
                'EmpName' => $this->request->getVar('EmpName'),                
				'DeptID' => $this->request->getVar('ParentDept'),                
				'Gender' => $this->request->getVar('Gender'),
				'EmailID' => $this->request->getVar('EmailID'),
                'Password' => md5('123456'),
				'Address' => $this->request->getVar('Address'),
				'Contact' => $this->request->getVar('Contact'),
				'JobType' => $this->request->getVar('JobType'),
				'City' => $this->request->getVar('City'),
				'DateOfJoining' => $this->request->getVar('DateOfJoining'),
                'Doc' => '',
                'ProfilePic' =>'',
			];
			
            if ($this->request->getVar('ParentDept') != '') {
				$departmentdata['ParentDept'] = $this->request->getVar('ParentDept');
			}
			//print_r($data);exit;
			$EmployeeModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/employees'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\employee_edit_form', $data);
	}
}