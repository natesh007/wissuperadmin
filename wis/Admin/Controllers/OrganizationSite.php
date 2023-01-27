<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationSiteModel;

class OrganizationSite extends BaseController
{
   
    public function index($status = '')
    {
		if($status == ''){
			session()->set('organizationsite_page', '/organizationsite');
		}else{
			session()->set('organizationsite_page', '/organizationsite/'.$status);
		}
		
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationSiteModel();
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

		$organizationsite = $model->get_organizationsite($page, $perPage, $keyword, $status);

		$data['keyword'] = $keyword;

		$data['organizationsite'] = $organizationsite['results'];


		$data['pagelinks'] = $organizationsite['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationsite', $data);
    }
    
    public function add_organizationsite()
	{
		
		$OrganizationSiteModel = new OrganizationSiteModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Site' => $this->request->getVar('Site'),
				'Status' => 1
			];
			$save = $OrganizationSiteModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organizationsite'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationsite_form');
	}

	public function edit_organizationsite($id = null)
	{
		
		$OrganizationSiteModel = new OrganizationSiteModel();
		$data['organizationsite'] = $OrganizationSiteModel->where('OrgSiteID', $id)->first();
		//echo "<pre>";print_r($data['organizationsite']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Site' => $this->request->getVar('Site')			
			];
			//print_r($data);exit;
			$OrganizationSiteModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organizationsite'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationsite_edit_form', $data);
	}
}