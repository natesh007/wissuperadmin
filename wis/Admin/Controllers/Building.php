<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\BuildingModel;
use Modules\Admin\Models\FloorModel;
use Modules\Admin\Models\RoomModel;
use Modules\Admin\Models\BranchModel;
use Modules\Admin\Models\AdminsModel;

class Building extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('building_page', '/buildings');
		$data['pager'] = \Config\Services::pager();
		$model = new BuildingModel();
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

		$building = $model->get_buildings($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['building'] = $building['results'];


		$data['pagelinks'] = $building['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\building', $data);
    }
    public function active_buildings($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('building_page', '/active_buildings');
		$data['pager'] = \Config\Services::pager();
		$model = new BuildingModel();
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
		$building = $model->get_buildings($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['building'] = $building['results'];
		$data['pagelinks'] = $building['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\building', $data);
	}
	public function inactive_buildings($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('building_page', '/inactive_buildings');
		$data['pager'] = \Config\Services::pager();
		$model = new BuildingModel();
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
		$building = $model->get_buildings($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['building'] = $building['results'];
		$data['pagelinks'] = $building['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\building', $data);
	}

    public function add_building()
	{
		$BuildingModel = new BuildingModel();
		$FloorModel = new FloorModel();
		$RoomModel = new RoomModel();
        $AdminsModel = new AdminsModel();
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
		if ($this->request->getMethod() == 'post') {
			$buildingdata = [
				'OrgID' => $this->request->getVar('OrgID'),  
				'BrID' => $this->request->getVar('BrID'),
				'BuildingName' => $this->request->getVar('BuildingName'),
                'Status' => 1
			];
			$buildingid = $BuildingModel->insert($buildingdata);
			if($buildingid){
				for($i = 1; $i <= count($this->request->getVar('FloorName')); $i++){
					if(isset($this->request->getVar('FloorName')[$i]) && $this->request->getVar('FloorName')[$i]){
						$floordata = [
							'OrgID' => $this->request->getVar('OrgID'),  
							'BID' => $buildingid,
							'FloorName' => $this->request->getVar('FloorName')[$i],
							'Status' => 1
						];
						$floorid = $FloorModel->insert($floordata);
						if($floorid){
							if(isset($this->request->getVar('RoomName')[$i])){
								for($j = 1; $j <= count($this->request->getVar('RoomName')[$i]); $j++){
									if(isset($this->request->getVar('RoomName')[$i][$j]) && $this->request->getVar('RoomName')[$i][$j]){
										$roomdata = [
											'OrgID' => $this->request->getVar('OrgID'),  
											'BID' => $buildingid,
											'FID' => $floorid,
											'RoomName' => $this->request->getVar('RoomName')[$i][$j],
											'Status' => 1
										];
										$roomid = $RoomModel->insert($roomdata);			
									}	
								}
							}	
						}
					}		
				}
			}
			return redirect()->to(base_url('admin/buildings'))->with('msg', 'Data Saved Successfully');
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\building_form',$data);
	}

	public function edit_building($id = null)
	{
		$BuildingModel = new BuildingModel();
		$FloorModel = new FloorModel();
		$RoomModel = new RoomModel();
		$BranchModel = new BranchModel();
        $AdminsModel = new AdminsModel();
        $data['building'] = $BuildingModel->get_building_data($id);
		$data['organizations'] = $AdminsModel->getmasterdata('organization');
		$data['branches'] = $BranchModel->where('OrgID', $data['building']['OrgID'])->findAll();
		if ($this->request->getMethod() == 'post') {
			$buildingdata = [
				'OrgID' => $this->request->getVar('OrgID'),  
				'BrID' => $this->request->getVar('BrID'),
				'BuildingName' => $this->request->getVar('BuildingName'),
            ];
			$BuildingModel->update($id, $buildingdata);
			$FloorModel->where('BID', $id)->delete();
			$RoomModel->where('BID', $id)->delete();
			for($i = 1; $i <= count($this->request->getVar('FloorName')); $i++){
				if(isset($this->request->getVar('FloorName')[$i]) && $this->request->getVar('FloorName')[$i]){
					$floordata = [
						'OrgID' => $this->request->getVar('OrgID'),  
						'BID' => $id,
						'FloorName' => $this->request->getVar('FloorName')[$i],
						'Status' => 1
					];
					$floorid = $FloorModel->insert($floordata);
					if($floorid){
						if(isset($this->request->getVar('RoomName')[$i])){
							for($j = 1; $j <= count($this->request->getVar('RoomName')[$i]); $j++){
								if(isset($this->request->getVar('RoomName')[$i][$j]) && $this->request->getVar('RoomName')[$i][$j]){
									$roomdata = [
										'OrgID' => $this->request->getVar('OrgID'),  
										'BID' => $id,
										'FID' => $floorid,
										'RoomName' => $this->request->getVar('RoomName')[$i][$j],
										'Status' => 1
									];
									$roomid = $RoomModel->insert($roomdata);			
								}	
							}
						}	
					}
				}		
			}
			return redirect()->to(base_url('admin/buildings'))->with('msg','Data Updated Successfully');
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\building_edit_form', $data);
	}

	public function deletebuilding()
	{
		$BuildingModel = new BuildingModel();
		$FloorModel = new FloorModel();
		$RoomModel = new RoomModel();
		$id = $this->request->getVar('Id');
		$BuildingModel->where('BID', $id)->delete();
		$FloorModel->where('BID', $id)->delete();
		$RoomModel->where('BID', $id)->delete();
		echo 1;
		exit;
	}
	public function removerelatedrecords(){
		$FloorModel = new FloorModel();
		$RoomModel = new RoomModel();
		if($this->request->getVar('Table') == 'floor'){
			$FloorModel->delete($this->request->getVar('ID'));
			$RoomModel->where('FID', $this->request->getVar('ID'))->delete();
		}else if($this->request->getVar('Table') == 'room'){
			$RoomModel->delete($this->request->getVar('ID'));
		}
		echo 1;
		exit;
	}
}