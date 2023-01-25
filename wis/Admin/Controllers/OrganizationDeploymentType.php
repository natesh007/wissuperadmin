<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationDeploymentTypeModel;

class OrganizationDeploymentType extends BaseController
{
   
    public function index($status = '')
    {
		if($status == ''){
			session()->set('organizationdeploymenttype_page', '');
		}else{
			session()->set('organizationdeploymenttype_page', '/'.$status);
		}
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationDeploymentTypeModel();
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

		$organizationdeploymenttype = $model->get_organizationdeploymenttypes($page, $perPage, $keyword, $status);

		$data['keyword'] = $keyword;

		$data['organizationdeploymenttype'] = $organizationdeploymenttype['results'];


		$data['pagelinks'] = $organizationdeploymenttype['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdeploymenttype', $data);
    }
    
        
		
    public function add_organizationdeploymenttype()
	{
		
		$OrganizationDeploymentTypeModel = new OrganizationDeploymentTypeModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'DeploymentType' => $this->request->getVar('DeploymentType'),                
				'Status' => 1
			];
			$save = $OrganizationDeploymentTypeModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organizationdeploymenttypes'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdeploymenttype_form');
	}

	public function edit_organizationdeploymenttype($id = null)
	{
		
		$OrganizationDeploymentTypeModel = new OrganizationDeploymentTypeModel();
		$data['organizationdeploymenttype'] = $OrganizationDeploymentTypeModel->where('OrgDeploymentTypeID ', $id)->first();
		//echo "<pre>";print_r($data['organizationdeploymenttypes']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'DeploymentType' => $this->request->getVar('DeploymentType')		
			];
			//print_r($data);exit;
			$OrganizationDeploymentTypeModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organizationdeploymenttypes'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdeploymenttype_edit_form', $data);
	}
}