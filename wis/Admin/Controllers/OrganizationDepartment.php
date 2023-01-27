<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\OrganizationDepartmentModel;

class OrganizationDepartment extends BaseController
{
   
    public function index($status = '')
    {
		if($status == ''){
			session()->set('organizationdepartment_page', '/organizationdepartment');
		}else{
			session()->set('organizationdepartment_page', '/organizationdepartment/'.$status);
		}
		
		$data['pager'] = \Config\Services::pager();
		$model = new OrganizationDepartmentModel();
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

		$organizationdepartment = $model->get_organizationdepartment($page, $perPage, $keyword, $status);

		$data['keyword'] = $keyword;

		$data['organizationdepartment'] = $organizationdepartment['results'];


		$data['pagelinks'] = $organizationdepartment['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdepartment', $data);
    }
    
    public function add_organizationdepartment()
	{
		
		$OrganizationDepartmentModel = new OrganizationDepartmentModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Department' => $this->request->getVar('Department'),
				'Status' => 1
			];
			$save = $OrganizationDepartmentModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/organizationdepartment'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdepartment_form');
	}

	public function edit_organizationdepartment($id = null)
	{
		
		$OrganizationDepartmentModel = new OrganizationDepartmentModel();
		$data['organizationdepartment'] = $OrganizationDepartmentModel->where('OrgDepartmentID', $id)->first();
		//echo "<pre>";print_r($data['organizationdepartment']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Department' => $this->request->getVar('Department')			
			];
			//print_r($data);exit;
			$OrganizationDepartmentModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/organizationdepartment'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\organizationdepartment_edit_form', $data);
	}
}