<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationModel;
use Modules\Admin\Models\AdminsModel;

class Organization extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('organization_page', '/organizations');
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
        //echo $session->get('AID');exit;
        $data['organization_types'] = $AdminsModel->getmasterdata('organization_type');
        //echo "<pre>";print_r($data['organization_types'] );exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgName' => $this->request->getVar('OrgName'),  
				'OrgType' => $this->request->getVar('OrgType'),
                'Address' => $this->request->getVar('Address'),                
				'Langitude' => $this->request->getVar('Langitude'),                
				'Latitude' => $this->request->getVar('Latitude'),
                'Status' => 1
			];
			$save = $OrganizationModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organizations'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_form',$data);
	}

	public function edit_organization($id = null)
	{
		
		$OrganizationModel = new OrganizationModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organization_types'] = $AdminsModel->getmasterdata('organization_type');
		$data['organization'] = $OrganizationModel->where('OrgID ', $id)->first();
		//echo "<pre>";print_r($data['organizations']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgName' => $this->request->getVar('OrgName'),  
				'OrgType' => $this->request->getVar('OrgType'),
                'Address' => $this->request->getVar('Address'),                
				'Langitude' => $this->request->getVar('Langitude'),                
				'Latitude' => $this->request->getVar('Latitude'),		
			];
			//print_r($data);exit;
			$OrganizationModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organizations'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_edit_form', $data);
	}
}