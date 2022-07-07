<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\JobtitleModel;
use Modules\Admin\Models\AdminsModel;

class jobtitle extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('jobtitle_page', '/jobtitles');
		$data['pager'] = \Config\Services::pager();
		$model = new JobtitleModel();
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

		$jobtitle = $model->get_jobtitles($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['jobtitle'] = $jobtitle['results'];


		$data['pagelinks'] = $jobtitle['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\jobtitle', $data);
    }
    public function active_jobtitles($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('jobtitle_page', '/active_jobtitles');
		$data['pager'] = \Config\Services::pager();
		$model = new JobtitleModel();
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
		$jobtitle = $model->get_jobtitles($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['jobtitle'] = $jobtitle['results'];
		$data['pagelinks'] = $jobtitle['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\jobtitle', $data);
	}
	public function inactive_jobtitles($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('jobtitle_page', '/inactive_jobtitles');
		$data['pager'] = \Config\Services::pager();
		$model = new JobtitleModel();
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
		$jobtitle = $model->get_jobtitles($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['jobtitle'] = $jobtitle['results'];
		$data['pagelinks'] = $jobtitle['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\jobtitle', $data);
	}

    public function add_jobtitle()
	{
		$JobtitleModel = new JobtitleModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
		
        //echo "<pre>";print_r($data['jobtitle_types'] );exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'), 				 
				'JobTitle' => $this->request->getVar('JobTitle'),               
                'Status' => 1
			];
			$save = $JobtitleModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/jobtitles'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\jobtitle_form',$data);
	}

	public function edit_jobtitle($id = null)
	{
		
		$JobtitleModel = new JobtitleModel();
        $AdminsModel = new AdminsModel();
		
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
		$data['jobtitle'] = $JobtitleModel->where('JobTID  ', $id)->first();
		//echo "<pre>";print_r($data['jobtitles']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'), 				 
				'JobTitle' => $this->request->getVar('JobTitle')
			];
			//print_r($data);exit;
			$JobtitleModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/jobtitles'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\jobtitle_edit_form', $data);
	}

	public function getjobtitle(){
        $JobtitleModel = new JobtitleModel();
        $orgid=$_POST['OrgID'];
        $jobtitles = $JobtitleModel->where('OrgID', $orgid)->findAll();
		//echo "<pre>";print_r($data['branches']);exit;
		//echo view('Modules\Admin\Views\branch_dropdown_ajax',$data);
		echo json_encode($jobtitles);       
    }
}