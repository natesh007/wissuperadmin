<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationModel;
use Modules\Admin\Models\OrganizationCitiesModel;
use Modules\Admin\Models\AdminsModel;

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
		$OrganizationModel = new OrganizationModel();
        $AdminsModel = new AdminsModel();
		$OrganizationCitiesModel = new OrganizationCitiesModel();
        //echo $session->get('AID');exit;
        $data['organization_types'] = $AdminsModel->getmasterdata('organization_type');
		$data['cities'] = $AdminsModel->getmasterdata('cities');
        //echo "<pre>";print_r($data['organization_types'] );exit;
		if ($this->request->getMethod() == 'post') {

				$img = '';
				if ($this->request->getFile('Logo') != '') {
					$orginalextension = $this->request->getFile('Logo')->getClientExtension();
					$randcharforimg = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);
					$newimgname = $randcharforimg . '-' . time() . '.' . $orginalextension;
					$this->request->getFile('Logo')->move(WRITEPATH . 'uploads/organization/', $newimgname);
					$img = 'writable/uploads/organization/' . $newimgname;
				}
			$cities=$this->request->getVar('cities');
			if($cities){
				$data = [
					'OrgName' => $this->request->getVar('OrgName'),  
					'OrgType' => $this->request->getVar('OrgType'),
					'Logo' => $img,
					'Status' => 1
				];
			
				$save = $OrganizationModel->insert($data);
				$orgid= $OrganizationModel->insertID;
				for($i=0;$i<count($cities);$i++){
					$data1 = [
						'OrgID' => $orgid,  
						'CityID' => $cities[$i],
						
					];
				
				$save1 = $OrganizationCitiesModel->insert($data1);
				
				}
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organizations'))->with('msg', $msg);
			}
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_form',$data);
	}

	public function edit_organization($id = null)
	{
		
		$OrganizationModel = new OrganizationModel();
		$OrganizationCitiesModel = new OrganizationCitiesModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organization_types'] = $AdminsModel->getmasterdata('organization_type');
		$data['cities'] = $AdminsModel->getmasterdata('cities');
		
		$data['organization'] = $OrganizationModel->where('OrgID ', $id)->first();

		$cities = $OrganizationCitiesModel->where('OrgID', $data['organization']['OrgID'])->findAll();
		$selcities=[];
		foreach($cities as $c){
			$selcities[]=$c['CityID'];
		}
		$data['selcities'] = $selcities;
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



			$cities=$this->request->getVar('cities');
			//echo "<pre>";print_r($cities);exit;
			if($cities){
			$data = [
				'OrgName' => $this->request->getVar('OrgName'),  
				'OrgType' => $this->request->getVar('OrgType'),
				'Logo' => $img	
			];
			//print_r($data);exit;
			$OrganizationModel->update($id, $data);
			$OrganizationCitiesModel->where('OrgID', $id)->delete();
			for($i=0;$i<count($cities);$i++){				
					$data1 = [
						'OrgID' => $id,  
						'CityID' => $cities[$i]						
					];			
					$save1 = $OrganizationCitiesModel->insert($data1);
			
			}
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organizations'))->with('msg', $msg);
			}
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_edit_form', $data);
	}
}