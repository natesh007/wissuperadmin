<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\BranchModel;
use Modules\Admin\Models\AdminsModel;

class Branch extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('branch_page', '/branches');
		$data['pager'] = \Config\Services::pager();
		$model = new BranchModel();
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

		$branch = $model->get_branches($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['branch'] = $branch['results'];


		$data['pagelinks'] = $branch['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\branch', $data);
    }
    public function active_branches($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('branch_page', '/active_branches');
		$data['pager'] = \Config\Services::pager();
		$model = new BranchModel();
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
		$branch = $model->get_branches($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['branch'] = $branch['results'];
		$data['pagelinks'] = $branch['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\branch', $data);
	}
	public function inactive_branches($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('branch_page', '/inactive_branches');
		$data['pager'] = \Config\Services::pager();
		$model = new BranchModel();
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
		$branch = $model->get_branches($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['branch'] = $branch['results'];
		$data['pagelinks'] = $branch['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\branch', $data);
	}

    public function add_branch()
	{
		$BranchModel = new BranchModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
        //echo "<pre>";print_r($data['branch_types'] );exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
				'BrName' => $this->request->getVar('BrName'),
                'Address' => $this->request->getVar('Address'),                
				'BrLangitude' => $this->request->getVar('BrLangitude'),                
				'BrLatitude' => $this->request->getVar('BrLatitude'),
                'Status' => 1
			];
			$save = $BranchModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/branches'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\branch_form',$data);
	}

	public function edit_branch($id = null)
	{
		
		$BranchModel = new BranchModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
		$data['branch'] = $BranchModel->where('BrID  ', $id)->first();
		//echo "<pre>";print_r($data['branches']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
				'BrName' => $this->request->getVar('BrName'),
                'Address' => $this->request->getVar('Address'),                
				'BrLangitude' => $this->request->getVar('BrLangitude'),                
				'BrLatitude' => $this->request->getVar('BrLatitude')
			];
			//print_r($data);exit;
			$BranchModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/branches'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\branch_edit_form', $data);
	}
}