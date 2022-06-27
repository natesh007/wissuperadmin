<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\RoomModel;
use Modules\Admin\Models\FloorModel;
use Modules\Admin\Models\BuildingModel;
use Modules\Admin\Models\AdminsModel;

class Room extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('room_page', '/rooms');
		$data['pager'] = \Config\Services::pager();
		$model = new RoomModel();
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

		$room = $model->get_rooms($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['room'] = $room['results'];


		$data['pagelinks'] = $room['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\room', $data);
    }
    public function active_rooms($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('room_page', '/active_rooms');
		$data['pager'] = \Config\Services::pager();
		$model = new RoomModel();
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
		$room = $model->get_rooms($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['room'] = $room['results'];
		$data['pagelinks'] = $room['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\room', $data);
	}
	public function inactive_rooms($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('room_page', '/inactive_rooms');
		$data['pager'] = \Config\Services::pager();
		$model = new RoomModel();
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
		$room = $model->get_rooms($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['room'] = $room['results'];
		$data['pagelinks'] = $room['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\room', $data);
	}

    public function add_room()
	{
		$RoomModel = new RoomModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
        $data['buildings'] = $AdminsModel->getmasterdata('building');
       // echo "<pre>";print_r($data['buildings']);exit;
        //echo "<pre>";print_r($data['room_types'] );exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
                'BID' => $this->request->getVar('BID'),  
                'FID' => $this->request->getVar('FID'),  
				'RoomName' => $this->request->getVar('RoomName'),
                'Status' => 1
			];
			$save = $RoomModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/rooms'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\room_form',$data);
	}

	public function edit_room($id = null)
	{
		
		$RoomModel = new RoomModel();
        $AdminsModel = new AdminsModel();
		$BuildingModel = new BuildingModel();
        $FloorModel = new FloorModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
        //$data['buildings'] = $AdminsModel->getmasterdata('building');
        
		$data['room'] = $RoomModel->where('RID', $id)->first();

		$data['buildings'] = $BuildingModel->where('OrgID', $data['room']['OrgID'])->findAll();
        $data['floors'] = $FloorModel->where('BID', $data['room']['BID'])->findAll();
		//echo "<pre>";print_r($data['rooms']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
                'BID' => $this->request->getVar('BID'),  
                'FID' => $this->request->getVar('FID'),  
				'RoomName' => $this->request->getVar('RoomName')
			];
			//print_r($data);exit;
			$RoomModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/rooms'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\room_edit_form', $data);
	}

    public function getbuildings(){
        $BuildingModel = new BuildingModel();
        $orgid=$_POST['OrgID'];
        $buildingdata = $BuildingModel->where('OrgID', $orgid)->findAll();
		echo json_encode($buildingdata);       
    }
    public function getfloors(){
        $FloorModel = new FloorModel();
        $bid=$_POST['BID'];
        $floordata = $FloorModel->where('BID', $bid)->findAll();
		echo json_encode($floordata);       
    }
}