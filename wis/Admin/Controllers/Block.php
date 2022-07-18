<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\BlockModel;
use Modules\Admin\Models\BuildingModel;
use Modules\Admin\Models\AdminsModel;

class block extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('block_page', '/blocks');
		$data['pager'] = \Config\Services::pager();
		$model = new BlockModel();
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

		$block = $model->get_blocks($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['block'] = $block['results'];


		$data['pagelinks'] = $block['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\block', $data);
    }
    public function active_blocks($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('block_page', '/active_blocks');
		$data['pager'] = \Config\Services::pager();
		$model = new BlockModel();
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
		$block = $model->get_blocks($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['block'] = $block['results'];
		$data['pagelinks'] = $block['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\block', $data);
	}
	public function inactive_blocks($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('block_page', '/inactive_blocks');
		$data['pager'] = \Config\Services::pager();
		$model = new BlockModel();
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
		$block = $model->get_blocks($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['block'] = $block['results'];
		$data['pagelinks'] = $block['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\block', $data);
	}

    public function add_block()
	{
		$BlockModel = new BlockModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
        $data['buildings'] = $AdminsModel->getmasterdata('building');
       // echo "<pre>";print_r($data['buildings']);exit;
        //echo "<pre>";print_r($data['block_types'] );exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
                'BID' => $this->request->getVar('BID'),  
				'BlockName' => $this->request->getVar('BlockName'),
                'Status' => 1
			];
			$save = $BlockModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/blocks'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\block_form',$data);
	}

	public function edit_block($id = null)
	{
		
		$BlockModel = new BlockModel();
        $AdminsModel = new AdminsModel();
		$BuildingModel = new BuildingModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
        //$data['buildings'] = $AdminsModel->getmasterdata('building');
        
		$data['block'] = $BlockModel->where('BKID', $id)->first();

		$data['buildings'] = $BuildingModel->where('OrgID', $data['block']['OrgID'])->findAll();
		//echo "<pre>";print_r($data['blocks']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
                'BID' => $this->request->getVar('BID'),  
				'BlockName' => $this->request->getVar('BlockName')
			];
			//print_r($data);exit;
			$BlockModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/blocks'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\block_edit_form', $data);
	}

    public function getbuildings(){
        $BuildingModel = new BuildingModel();
        $orgid=$_POST['OrgID'];
        $buildingdata = $BuildingModel->where('OrgID', $orgid)->findAll();
		echo json_encode($buildingdata);       
    }
}