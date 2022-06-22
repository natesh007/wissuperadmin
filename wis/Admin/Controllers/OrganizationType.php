<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationTypeModel;

class OrganizationType extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('organization_type_page', '/organization_types');
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationTypeModel();
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

		$organization_type = $model->get_organization_types($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['organization_type'] = $organization_type['results'];


		$data['pagelinks'] = $organization_type['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_type', $data);
    }
    public function active_organization_types($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('organization_type_page', '/active_organization_types');
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationTypeModel();
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
		$organization_type = $model->get_organization_types($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['organization_type'] = $organization_type['results'];
		$data['pagelinks'] = $organization_type['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_type', $data);
	}
	public function inactive_organization_types($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('organization_type_page', '/inactive_organization_types');
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationTypeModel();
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
		$organization_type = $model->get_organization_types($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['organization_type'] = $organization_type['results'];
		$data['pagelinks'] = $organization_type['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_type', $data);
	}
    public function add_organization_type()
	{
		
		$OrganizationTypeModel = new OrganizationTypeModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrganizationType' => $this->request->getVar('OrganizationType'),                
				'Status' => 1
			];
			$save = $OrganizationTypeModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organization_types'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_type_form');
	}

	public function edit_organization_type($id = null)
	{
		
		$OrganizationTypeModel = new OrganizationTypeModel();
		$data['organization_type'] = $OrganizationTypeModel->where('TypeID', $id)->first();
		//echo "<pre>";print_r($data['organization_types']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrganizationType' => $this->request->getVar('OrganizationType')		
			];
			//print_r($data);exit;
			$OrganizationTypeModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organization_types'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organization_type_edit_form', $data);
	}
}