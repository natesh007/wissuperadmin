<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationDesignationModel;

class OrganizationDesignation extends BaseController
{
   
    public function index($status = '')
    {
		if($status == ''){
			session()->set('organizationdesignation_page', '/organizationdesignation');
		}else{
			session()->set('organizationdesignation_page', '/organizationdesignation/'.$status);
		}
		
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationDesignationModel();
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

		$organizationdesignation = $model->get_organizationdesignation($page, $perPage, $keyword, $status);

		$data['keyword'] = $keyword;

		$data['organizationdesignation'] = $organizationdesignation['results'];


		$data['pagelinks'] = $organizationdesignation['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdesignation', $data);
    }
    
    public function add_organizationdesignation()
	{
		
		$OrganizationDesignationModel = new OrganizationDesignationModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Designation' => $this->request->getVar('Designation'),
				'Status' => 1
			];
			$save = $OrganizationDesignationModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organizationdesignation'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdesignation_form');
	}

	public function edit_organizationdesignation($id = null)
	{
		
		$OrganizationDesignationModel = new OrganizationDesignationModel();
		$data['organizationdesignation'] = $OrganizationDesignationModel->where('OrgDesignationID', $id)->first();
		//echo "<pre>";print_r($data['organizationdesignation']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Designation' => $this->request->getVar('Designation')			
			];
			//print_r($data);exit;
			$OrganizationDesignationModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organizationdesignation'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdesignation_edit_form', $data);
	}
}