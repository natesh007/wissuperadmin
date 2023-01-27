<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationModel;
use Modules\Admin\Models\OrganizationCitiesModel;
use Modules\Admin\Models\AdminsModel;
use Modules\Admin\Models\EmployeeModel;
use Modules\Admin\Models\OrganizationDesignationlistModel;
use Modules\Admin\Models\OrganizationDepartmentlistModel;


class Organization extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('organization_page', '/organizations');
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationModel();
		$OrganizationCitiesModel = new OrganizationCitiesModel();
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

		$organization = $model->get_organizations($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['organization'] = $organization['results'];
		
		$data['pagelinks'] = $organization['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization', $data);
    }
    public function active_organizations($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('organization_page', '/active_organizations');
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationModel();
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
		$organization = $model->get_organizations($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['organization'] = $organization['results'];
		$data['pagelinks'] = $organization['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization', $data);
	}
	public function inactive_organizations($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('organization_page', '/inactive_organizations');
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationModel();
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
		$organization = $model->get_organizations($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['organization'] = $organization['results'];
		$data['pagelinks'] = $organization['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization', $data);
	}

    public function add_organization()
	{
		helper(['url', 'form']);       
		$OrganizationModel = new OrganizationModel();
		$EmployeeModel = new EmployeeModel();
        $AdminsModel = new AdminsModel();
		$OrganizationDesignationlistModel = new OrganizationDesignationlistModel();
		$OrganizationDepartmentlistModel = new OrganizationDepartmentlistModel();
        //echo $session->get('AID');exit;
        $data['organization_types'] = $AdminsModel->getmasterdata('organization_type');
		$data['organizationmanagesby'] = $AdminsModel->getmasterdata('organizationmanagedby');
		$data['organizationdeploymenttypes'] = $AdminsModel->getmasterdata('organizationdeploymenttype');
		$data['organizationreportings'] = $AdminsModel->getmasterdata('organizationreporting');
		$data['organizationsites'] = $AdminsModel->getmasterdata('organizationsite');
		$data['cities'] = $AdminsModel->getmasterdata('cities');
		$data['organizationdesignations'] = $AdminsModel->getmasterdata('organizationdesignation');
		$data['organizationdepartments'] = $AdminsModel->getmasterdata('organizationdepartment');
		$data['statuses'] = $AdminsModel->getmasterdata('status');
		$data['error']="";
        //echo "<pre>";print_r($data['organization_types'] );exit;
		if ($this->request->getMethod() == 'post') {
				//echo "<pre>";print_r($this->request->getVar());exit;
				$img = '';
				if ($this->request->getFile('Logo') != '') {
					$orginalextension = $this->request->getFile('Logo')->getClientExtension();
					$randcharforimg = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);
					$newimgname = $randcharforimg . '-' . time() . '.' . $orginalextension;
					$this->request->getFile('Logo')->move(WRITEPATH . 'uploads/organization/', $newimgname);
					$img = 'writable/uploads/organization/' . $newimgname;
				}
			$Designation = $this->request->getVar('Designation');
			$Department = $this->request->getVar('Department');
			if($Designation && $Department){
				if($this->request->getVar('EmailID')!=""){
					$exist_emp = $EmployeeModel->where('EmailID',$this->request->getVar('EmailID'))->first();
					//echo "<pre>";print_r($exist_emp);exit;
					if($exist_emp){
						$data['error'] = 'Email ID Already Exist, Please Enter Another Email ID!';
					}else{
					$orgdata = [
						'OrgName' => $this->request->getVar('OrgName'),  
						'ManagedBy' => $this->request->getVar('ManagedBy'),
						'DeploymentType' => $this->request->getVar('DeploymentType'),
						'Reporting' => $this->request->getVar('Reporting'),
						'OrgType' => $this->request->getVar('OrgType'),
						'ClientLimit' => $this->request->getVar('ClientLimit'),
						'Site' => $this->request->getVar('Site'),
						'SiteLimit' => $this->request->getVar('SiteLimit'),
						'SiteEmps' => $this->request->getVar('SiteEmps'),
						'SubClients' => $this->request->getVar('SubClients'),
						'SiteLocations' => $this->request->getVar('SiteLocations'),
						'Logo' => $img,
						'Status' => 1
					];
			
					$save = $OrganizationModel->insert($orgdata);
					$orgid= $OrganizationModel->insertID;

					$empdata = [
						'FirstName' => $this->request->getVar('FirstName'),
						'MiddleName' => $this->request->getVar('MiddleName'),
						'LastName' => $this->request->getVar('LastName'),
						'OrgID' => $orgid,
						'EmailID' => $this->request->getVar('EmailID'),
						'Password' => md5($this->request->getVar('Password')),
						'Address' => $this->request->getVar('Address'),
						'Contact' => $this->request->getVar('Phone'),
						'Role' => 1,
						'Status' => 1
					];
					
					$save = $EmployeeModel->insert($empdata);
					$empid = $EmployeeModel->getInsertID();
					
					for($i=0;$i<count($Designation);$i++){
						$data1 = [
							'OrgID' => $orgid,  
							'DesignationID' => $Designation[$i]						
						];				
					$save1 = $OrganizationDesignationlistModel->insert($data1);				
					}

					//echo "<pre>";print_r($data1);exit;
					
					for($j=0;$j<count($Department);$j++){
						$data2 = [
							'OrgID' => $orgid,  
							'DeptID' => $Department[$j]						
						];				
					$save2 = $OrganizationDepartmentlistModel->insert($data2);				
					}
					$msg = 'Data Saved Successfully';
					return redirect()->to(base_url('admin/organizations'))->with('msg', $msg);
				}
			}
			}
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_form',$data);
	}

	public function edit_organization($id = null)
	{
		
		helper(['url', 'form']);       
		$OrganizationModel = new OrganizationModel();
		$EmployeeModel = new EmployeeModel();
        $AdminsModel = new AdminsModel();
		$OrganizationDesignationlistModel = new OrganizationDesignationlistModel();
		$OrganizationDepartmentlistModel = new OrganizationDepartmentlistModel();
        //echo $session->get('AID');exit;
        $data['organization_types'] = $AdminsModel->getmasterdata('organization_type');
		$data['organizationmanagesby'] = $AdminsModel->getmasterdata('organizationmanagedby');
		$data['organizationdeploymenttypes'] = $AdminsModel->getmasterdata('organizationdeploymenttype');
		$data['organizationreportings'] = $AdminsModel->getmasterdata('organizationreporting');
		$data['organizationsites'] = $AdminsModel->getmasterdata('organizationsite');
		$data['cities'] = $AdminsModel->getmasterdata('cities');
		$data['organizationdesignations'] = $AdminsModel->getmasterdata('organizationdesignation');
		$data['organizationdepartments'] = $AdminsModel->getmasterdata('organizationdepartment');
		$data['statuses'] = $AdminsModel->getmasterdata('status');
		$data['organization'] = $OrganizationModel->join('employees','organization.OrgID = employees.OrgID')->where('organization.OrgID ', $id)->first();
		$data['error']="";
		//$data['organization'] = $OrganizationModel->where('OrgID ', $id)->first();

		$designations = $OrganizationDesignationlistModel->where('OrgID', $data['organization']['OrgID'])->findAll();
		$seldesignations=[];
		foreach($designations as $d){
			$seldesignations[]=$d['DesignationID'];
		}
		$data['seldesignations'] = $seldesignations;

		$departments = $OrganizationDepartmentlistModel->where('OrgID', $data['organization']['OrgID'])->findAll();
		$seldepartments=[];
		foreach($departments as $d){
			$seldepartments[]=$d['DeptID'];
		}
		$data['seldepartments'] = $seldepartments;
		if ($this->request->getMethod() == 'post') {
			$img = '';
            if ($this->request->getFile('Logo') != '') {
				if(isset($data['organization']['Logo'])){
					if(file_exists($data['organization']['Logo'])){
						unlink($data['organization']['Logo']);
					}
				}
                $orginalextension = $this->request->getFile('Logo')->getClientExtension();
                $randcharforimg = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);
                $newimgname = $randcharforimg . '-' . time() . '.' . $orginalextension;
                $this->request->getFile('Logo')->move(WRITEPATH . 'uploads/organization/', $newimgname);
                $img = 'writable/uploads/organization/' . $newimgname;
            }else{
                $img = $this->request->getVar('OldLogo') ;
            }
			$Designation = $this->request->getVar('Designation');
			$Department = $this->request->getVar('Department');
			
				//echo "<pre>";print_r($data['organization']);exit;
				if($data['organization']['EmailID'] == $this->request->getVar('EmailID')){
					$email = $data['organization']['EmailID'];
				}else{
					$exist_emp = $EmployeeModel->where('EmailID',$this->request->getVar('EmailID'))->first();
					if($exist_emp){
						$data['error'] = 'Email ID Already Exist, Please Enter Another Email ID!';
						
					}else{
						$email = $this->request->getVar('EmailID');
					}
				}

				
						$orgdata = [
							'OrgName' => $this->request->getVar('OrgName'),  
							'ManagedBy' => $this->request->getVar('ManagedBy'),
							'DeploymentType' => $this->request->getVar('DeploymentType'),
							'Reporting' => $this->request->getVar('Reporting'),
							'OrgType' => $this->request->getVar('OrgType'),
							'ClientLimit' => $this->request->getVar('ClientLimit'),
							'Site' => $this->request->getVar('Site'),
							'SiteLimit' => $this->request->getVar('SiteLimit'),
							'SiteEmps' => $this->request->getVar('SiteEmps'),
							'SubClients' => $this->request->getVar('SubClients'),
							'SiteLocations' => $this->request->getVar('SiteLocations'),
							'Logo' => $img,
							'Status' => 1
						];
				
						$update = $OrganizationModel->update($id, $orgdata);
						$orgid= $data['organization']['OrgID'];
	
						$empdata = [
							'FirstName' => $this->request->getVar('FirstName'),
							'MiddleName' => $this->request->getVar('MiddleName'),
							'LastName' => $this->request->getVar('LastName'),
							'EmailID' => $email,
							'Address' => $this->request->getVar('Address'),
							'Contact' => $this->request->getVar('Phone')
						];
						
						$save = $EmployeeModel->update($data['organization']['EmpID'], $empdata);
						$empid = $data['organization']['EmpID'];
						
						$OrganizationDesignationlistModel->where('OrgID', $id)->delete();
						for($i=0;$i<count($Designation);$i++){
							$data1 = [
								'OrgID' => $orgid,  
								'DesignationID' => $Designation[$i]						
							];				
						$save1 = $OrganizationDesignationlistModel->insert($data1);				
						}
	
						//echo "<pre>";print_r($data1);exit;
						$OrganizationDepartmentlistModel->where('OrgID', $id)->delete();
						for($j=0;$j<count($Department);$j++){
							$data2 = [
								'OrgID' => $orgid,  
								'DeptID' => $Department[$j]						
							];				
						$save2 = $OrganizationDepartmentlistModel->insert($data2);				
						}
						$msg = 'Data Updated Successfully';
						return redirect()->to(base_url('admin/organizations'))->with('msg', $msg);
					}
								
			
		
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_edit_form', $data);
	}
}