<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\EmployeeModel;
use Modules\Admin\Models\AdminsModel;
use Modules\Admin\Models\BranchModel;
use Modules\Admin\Models\DepartmentsModel;
use Modules\Admin\Models\EmployeeBranchesModel;
use Modules\Admin\Models\JobtitleModel;

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
		$EmployeeBranchesModel = new EmployeeBranchesModel();
		
		$data['organizations'] = $AdminsModel->getmasterdata('organization');
        $data['departments'] = $AdminsModel->getmasterdata('departments');
		$data['jobtitles'] = $AdminsModel->getmasterdata('jobtitle');
		$data['branches'] = $AdminsModel->getmasterdata('branches');
        $data['roles'] = $AdminsModel->getmasterdata('roles');
		$data['shifts'] = $AdminsModel->getmasterdata('shifts');
		$data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		$data['error']="";
		if ($this->request->getMethod() == 'post') {

			/*$img = '';
			if ($this->request->getFile('ProfilePic') != '') {
				$orginalextension = $this->request->getFile('ProfilePic')->getClientExtension();
				$randcharforimg = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);
				$newimgname = $randcharforimg . '-' . time() . '.' . $orginalextension;
				$this->request->getFile('ProfilePic')->move(SAURL . WRITEPATH . 'uploads/ProfilePics/', $newimgname);
				$img = 'writable/uploads/ProfilePics/' . $newimgname;
			}*/

			if($this->request->getVar('Gender')=='M'){
				$img = "writable/uploads/ProfilePics/man.png";
			}else if($this->request->getVar('Gender')=='M'){
				$img = "writable/uploads/ProfilePics/woman.png";
			}

			if($this->request->getVar('EmailID')!=""){
				$exist_emp = $EmployeeModel->where('EmailID',$this->request->getVar('EmailID'))->first();
				if(!$exist_emp){
					$data = [
						'RoleID' => '',
						'EmpName' => $this->request->getVar('EmpName'),
						'DeptID' => $this->request->getVar('ParentDept'),
						'OrgID' => $this->request->getVar('OrgID'),
						'JobTID' => $this->request->getVar('JobTID'),             
						'Gender' => ($this->request->getVar('Gender')==""?'':$this->request->getVar('Gender')),
						'EmailID' => $this->request->getVar('EmailID'),
						'Password' => md5('123456'),
						'Address' => $this->request->getVar('Address'),
						'Contact' => $this->request->getVar('Contact'),
						'JobType' => $this->request->getVar('JobType'),
						'City' => '',
						'DateOfJoining' => $this->request->getVar('DateOfJoining'),
						'Doc' => '',
						'ProfilePic' => '',
						'Status' => 1,
						'Shift' => $this->request->getVar('Shift')
					];
					if ($this->request->getVar('ParentDept') != '') {
						$departmentdata['ParentDept'] = $this->request->getVar('ParentDept');
					}
					$save = $EmployeeModel->insert($data);
					$empid = $EmployeeModel->getInsertID();
					$BrID=$this->request->getVar('BrID');
					if(!empty($BrID)){
						for($i=0;$i<count($BrID);$i++){
							$data1 = [
								"EmpID" => $empid,
								"BrID" => $BrID[$i]
							];
							$EmployeeBranchesModel->insert($data1);
						}
					}
					$msg = 'Data Saved Successfully';
					return redirect()->to(base_url('admin/employees'))->with('msg', $msg);
				}else{
					$data['error'] = 'Email ID alreay Exist!';
				}
			}
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\employee_form',$data);
	}

	public function edit_employee($id = null)
	{
		
		$EmployeeModel = new EmployeeModel();
        $AdminsModel = new AdminsModel();
		$DepartmentsModel = new DepartmentsModel();
		$BranchModel = new BranchModel();
		$EmployeeBranchesModel = new EmployeeBranchesModel();
		$JobtitleModel = new JobtitleModel();
		$data['organizations'] = $AdminsModel->getmasterdata('organization');
		$data['roles'] = $AdminsModel->getmasterdata('roles');
		$data['shifts'] = $AdminsModel->getmasterdata('shifts');
		$data['employee'] = $EmployeeModel->where('EmpID', $id)->first();
		$data['departments'] = $DepartmentsModel->where('OrgID',$data['employee']['OrgID'])->findAll();
        $data['total_cats'] = $this->buildTree($data['departments'], 'ParentDept', 'DeptID');
		$data['branches'] = $BranchModel->where('OrgID',$data['employee']['OrgID'])->findAll();
		$data['jobtitles'] = $JobtitleModel->where('OrgID',$data['employee']['OrgID'])->findAll();
		$branches = $EmployeeBranchesModel->where('EmpID', $id)->findAll();
		$selbranches=[];
		foreach($branches as $b){
			$selbranches[]=$b['BrID'];
		}
		$data['selbranches'] = $selbranches;
		if ($this->request->getMethod() == 'post') {

			/*$img = '';
            if ($this->request->getFile('ProfilePic') != '') {
				if(isset($data['employee']['ProfilePic'])){
					if(file_exists($data['employee']['ProfilePic'])){
						unlink($data['employee']['ProfilePic']);
					}
				}
                $orginalextension = $this->request->getFile('ProfilePic')->getClientExtension();
                $randcharforimg = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);
                $newimgname = $randcharforimg . '-' . time() . '.' . $orginalextension;
                $this->request->getFile('ProfilePic')->move(SAURL . 'uploads/ProfilePics/', $newimgname);
                $img = 'writable/uploads/ProfilePics/' . $newimgname;
            }else{
                $img = $this->request->getVar('OldProfilePic') ;
            }*/
			if($this->request->getVar('Gender')=='M'){
				$img = "writable/uploads/ProfilePics/man.png";
			}else if($this->request->getVar('Gender')=='M'){
				$img = "writable/uploads/ProfilePics/woman.png";
			}
			

			if($data['employee']['EmailID']!=$this->request->getVar('EmailID')){
				$exist_emp = $EmployeeModel->where('EmailID',$this->request->getVar('EmailID'))->first();
				if($exist_emp){
					$msg = 'Email ID Already Exist, Please Enter Another Email ID!';
					return redirect()->to(base_url('admin/employees/edit_employee/'.$id))->with('error', $msg);
				}else{
					$data = [
						'RoleID' => '',
						'EmpName' => $this->request->getVar('EmpName'),                
						'DeptID' => $this->request->getVar('ParentDept'),  
						'OrgID' => $this->request->getVar('OrgID'), 
						'JobTID' => $this->request->getVar('JobTID'),         
						'Gender' => $this->request->getVar('Gender'),
						'EmailID' => $this->request->getVar('EmailID'),
						'Password' => md5('123456'),
						'Address' => $this->request->getVar('Address'),
						'Contact' => $this->request->getVar('Contact'),
						'JobType' => $this->request->getVar('JobType'),
						'City' => '',
						'DateOfJoining' => $this->request->getVar('DateOfJoining'),
						'Doc' => '',
						'ProfilePic' => '',
						'Shift' => $this->request->getVar('Shift')
					];
					
					if ($this->request->getVar('ParentDept') != '') {
						$departmentdata['ParentDept'] = $this->request->getVar('ParentDept');
					}
					$EmployeeModel->update($id, $data);
					$EmployeeBranchesModel->where('EmpID', $id)->delete();
					$BrID=$this->request->getVar('BrID');
					if(!empty($BrID)){
						for($i=0;$i<count($BrID);$i++){				
							$data1 = [
								'EmpID' => $id,  
								'BrID' => $BrID[$i]						
							];			
							$save1 = $EmployeeBranchesModel->insert($data1);
						}
					}
					$msg = 'Data Updated Successfully';
					return redirect()->to(base_url('admin/employees'))->with('msg', $msg);
				}
			}else{
			
				

				
				$data = [
					'RoleID' => '',
					'EmpName' => $this->request->getVar('EmpName'),                
					'DeptID' => $this->request->getVar('ParentDept'),  
					'OrgID' => $this->request->getVar('OrgID'), 
					'JobTID' => $this->request->getVar('JobTID'),         
					'Gender' => $this->request->getVar('Gender'),
					'EmailID' => $this->request->getVar('EmailID'),
					'Password' => md5('123456'),
					'Address' => $this->request->getVar('Address'),
					'Contact' => $this->request->getVar('Contact'),
					'JobType' => $this->request->getVar('JobType'),
					'City' => '',
					'DateOfJoining' => $this->request->getVar('DateOfJoining'),
					'Doc' => '',
					'ProfilePic' => $img,
					'Shift' => $this->request->getVar('Shift')
				];
				
				if ($this->request->getVar('ParentDept') != '') {
					$departmentdata['ParentDept'] = $this->request->getVar('ParentDept');
				}
				$EmployeeModel->update($id, $data);
				$EmployeeBranchesModel->where('EmpID', $id)->delete();
				$BrID=$this->request->getVar('BrID');
				if(!empty($BrID)){
					for($i=0;$i<count($BrID);$i++){				
						$data1 = [
							'EmpID' => $id,  
							'BrID' => $BrID[$i]						
						];			
						$save1 = $EmployeeBranchesModel->insert($data1);
					}
				}
				$msg = 'Data Updated Successfully';
				return redirect()->to(base_url('admin/employees'))->with('msg', $msg);
			}
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\employee_edit_form', $data);
	}
}