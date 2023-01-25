<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationReportingModel;

class OrganizationReporting extends BaseController
{
   
    public function index($status = '')
    {
		if($status == ''){
			session()->set('organizationreporting_page', '/organizationreporting');
		}else{
			session()->set('organizationreporting_page', '/organizationreporting/'.$status);
		}
		
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationReportingModel();
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

		$organizationreporting = $model->get_organizationreporting($page, $perPage, $keyword, $status);

		$data['keyword'] = $keyword;

		$data['organizationreporting'] = $organizationreporting['results'];


		$data['pagelinks'] = $organizationreporting['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationreporting', $data);
    }
    
    public function add_organizationreporting()
	{
		
		$OrganizationReportingModel = new OrganizationReportingModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Reporting' => $this->request->getVar('Reporting'),
				'Status' => 1
			];
			$save = $OrganizationReportingModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organizationreporting'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationreporting_form');
	}

	public function edit_organizationreporting($id = null)
	{
		
		$OrganizationReportingModel = new OrganizationReportingModel();
		$data['organizationreporting'] = $OrganizationReportingModel->where('OrgReportingID', $id)->first();
		//echo "<pre>";print_r($data['organizationreporting']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Reporting' => $this->request->getVar('Reporting')			
			];
			//print_r($data);exit;
			$OrganizationReportingModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organizationreporting'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationreporting_edit_form', $data);
	}
}