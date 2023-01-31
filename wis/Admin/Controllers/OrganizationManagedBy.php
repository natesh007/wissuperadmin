<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationManagedByModel;

class OrganizationManagedBy extends BaseController
{
   
    public function index($status = '')
    {
		if($status == ''){
			session()->set('organizationmanagedby_page', '');
		}else{
			session()->set('organizationmanagedby_page', '/'.$status);
		}
		
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationManagedByModel();
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

		$organizationmanagedby = $model->get_organizationmanagesby($page, $perPage, $keyword, $status);

		$data['keyword'] = $keyword;

		$data['organizationmanagedby'] = $organizationmanagedby['results'];


		$data['pagelinks'] = $organizationmanagedby['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationmanagedby', $data);
    }
    
    public function add_organizationmanagedby()
	{
		
		$OrganizationManagedByModel = new OrganizationManagedByModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgManaged' => $this->request->getVar('OrgManaged'),
				'Status' => 1
			];
			$save = $OrganizationManagedByModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organizationmanagesby'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationmanagedby_form');
	}

	public function edit_organizationmanagedby($id = null)
	{
		
		$OrganizationManagedByModel = new OrganizationManagedByModel();
		$data['organizationmanagedby'] = $OrganizationManagedByModel->where('OrgManagedByID', $id)->first();
		//echo "<pre>";print_r($data['organizationmanagesby']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgManaged' => $this->request->getVar('OrgManaged')			
			];
			//print_r($data);exit;
			$OrganizationManagedByModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organizationmanagesby'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationmanagedby_edit_form', $data);
	}
}