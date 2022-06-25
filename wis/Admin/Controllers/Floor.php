<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\FloorModel;
use Modules\Admin\Models\BuildingModel;
use Modules\Admin\Models\AdminsModel;

class Floor extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('floor_page', '/floors');
		$data['pager'] = \Config\Services::pager();
		$model = new FloorModel();
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

		$floor = $model->get_floors($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['floor'] = $floor['results'];


		$data['pagelinks'] = $floor['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\floor', $data);
    }
    public function active_floors($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('floor_page', '/active_floors');
		$data['pager'] = \Config\Services::pager();
		$model = new FloorModel();
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
		$floor = $model->get_floors($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['floor'] = $floor['results'];
		$data['pagelinks'] = $floor['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\floor', $data);
	}
	public function inactive_floors($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('floor_page', '/inactive_floors');
		$data['pager'] = \Config\Services::pager();
		$model = new FloorModel();
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
		$floor = $model->get_floors($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['floor'] = $floor['results'];
		$data['pagelinks'] = $floor['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\floor', $data);
	}

    public function add_floor()
	{
		$FloorModel = new FloorModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
        $data['buildings'] = $AdminsModel->getmasterdata('building');
       // echo "<pre>";print_r($data['buildings']);exit;
        //echo "<pre>";print_r($data['floor_types'] );exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
                'BID' => $this->request->getVar('BID'),  
				'FloorName' => $this->request->getVar('FloorName'),
                'Status' => 1
			];
			$save = $FloorModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/floors'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\floor_form',$data);
	}

	public function edit_floor($id = null)
	{
		
		$FloorModel = new FloorModel();
        $AdminsModel = new AdminsModel();
		$BuildingModel = new BuildingModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
        //$data['buildings'] = $AdminsModel->getmasterdata('building');
        
		$data['floor'] = $FloorModel->where('FID', $id)->first();

		$data['buildings'] = $BuildingModel->where('OrgID', $data['floor']['OrgID'])->findAll();
		//echo "<pre>";print_r($data['floors']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
                'BID' => $this->request->getVar('BID'),  
				'FloorName' => $this->request->getVar('FloorName')
			];
			//print_r($data);exit;
			$FloorModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/floors'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\floor_edit_form', $data);
	}

    public function getbuildings(){
        $BuildingModel = new BuildingModel();
        $orgid=$_POST['OrgID'];
        $buildingdata = $BuildingModel->where('OrgID', $orgid)->findAll();
		echo json_encode($buildingdata);       
    }
}