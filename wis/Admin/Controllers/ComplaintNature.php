<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\ComplaintNatureModel;
use Modules\Admin\Models\AdminsModel;

class complaintnature extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('complaintnature_page', '/complaintnatures');
		$data['pager'] = \Config\Services::pager();
		$model = new ComplaintNatureModel();
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

		$complaintnature = $model->get_complaintnatures($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['complaintnature'] = $complaintnature['results'];


		$data['pagelinks'] = $complaintnature['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintnature', $data);
    }
    public function active_complaintnatures($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('complaintnature_page', '/active_complaintnatures');
		$data['pager'] = \Config\Services::pager();
		$model = new ComplaintNatureModel();
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
		$complaintnature = $model->get_complaintnatures($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['complaintnature'] = $complaintnature['results'];
		$data['pagelinks'] = $complaintnature['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintnature', $data);
	}
	public function inactive_complaintnatures($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('complaintnature_page', '/inactive_complaintnatures');
		$data['pager'] = \Config\Services::pager();
		$model = new ComplaintNatureModel();
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
		$complaintnature = $model->get_complaintnatures($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['complaintnature'] = $complaintnature['results'];
		$data['pagelinks'] = $complaintnature['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintnature', $data);
	}

    public function add_complaintnature()
	{
		$ComplaintNatureModel = new ComplaintNatureModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['complaintcategories'] = $AdminsModel->getmasterdata('complaintcategory');
		
        //echo "<pre>";print_r($data['complaintnature_types'] );exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'ComplaintNature' => $this->request->getVar('ComplaintNature'), 				 
				'ComCatID' => $this->request->getVar('ComCatID'),               
                'Status' => 1
			];
			$save = $ComplaintNatureModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/complaintnatures'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintnature_form',$data);
	}

	public function edit_complaintnature($id = null)
	{
		
		$ComplaintNatureModel = new ComplaintNatureModel();
        $AdminsModel = new AdminsModel();
		
        $data['complaintcategories'] = $AdminsModel->getmasterdata('complaintcategory');
		$data['complaintnature'] = $ComplaintNatureModel->where('ComNatID  ', $id)->first();
		//echo "<pre>";print_r($data['complaintnatures']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'ComplaintNature' => $this->request->getVar('ComplaintNature'), 				 
				'ComCatID' => $this->request->getVar('ComCatID'),    
			];
			//print_r($data);exit;
			$ComplaintNatureModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/complaintnatures'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintnature_edit_form', $data);
	}

	public function getcomplaintnature(){
        $ComplaintCategoryModel = new ComplaintCategoryModel();
        $ComCatID=$_POST['ComCatID'];
        $complaintcategory = $ComplaintCategoryModel->where('ComCatID', $ComCatID)->findAll();
		//echo "<pre>";print_r($data['branches']);exit;
		//echo view('Modules\Admin\Views\branch_dropdown_ajax',$data);
		echo json_encode($complaintcategory);       
    }
}