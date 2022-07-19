<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\BuildingModel;
use Modules\Admin\Models\FloorModel;
use Modules\Admin\Models\RoomModel;
use Modules\Admin\Models\BranchModel;
use Modules\Admin\Models\AdminsModel;
use Modules\Admin\Models\BlockModel;

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
        $BlockModel = new BlockModel();
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
				for($i = 1; $i <= count($this->request->getVar('BlockName')); $i++){
					if($this->request->getVar('BlockName')[$i]){
						$blockdata = [
							'OrgID' => $this->request->getVar('OrgID'),  
							'BID' => $buildingid,
							'BlockName' => $this->request->getVar('BlockName')[$i],
							'Status' => 1
						];
						$blockid = $BlockModel->insert($blockdata);
						if($blockid){
							for($j = 1; $j <= count($this->request->getVar('FloorName')[$i]); $j++){
								if($this->request->getVar('FloorName')[$i][$j]){
									$floordata = [
										'OrgID' => $this->request->getVar('OrgID'),  
										'BKID' => $blockid,
										'FloorName' => $this->request->getVar('FloorName')[$i][$j],
										'Status' => 1
									];
									$floorid = $FloorModel->insert($floordata);
									if($floorid){
										for($k = 1; $k <= count($this->request->getVar('RoomName')[$i][$j]); $k++){
											if($this->request->getVar('RoomName')[$i][$j][$k]){
												$roomdata = [
													'OrgID' => $this->request->getVar('OrgID'),  
													'BKID' => $blockid,
													'FID' => $floorid,
													'RoomName' => $this->request->getVar('RoomName')[$i][$j][$k],
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
				}
			}
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/buildings'))->with('msg', $msg);
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
        $data['building'] = $BuildingModel->where('BID', $id)->first();
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
		$data['branches'] = $BranchModel->where('OrgID', $data['building']['OrgID'])->findAll();
		$rooms=[];
		$data['floors'] = $FloorModel->where('BID',$id)->findAll();
		foreach($data['floors'] as $fl){
			$rooms[$fl['FID']] = $RoomModel->where('FID',$fl['FID'])->findAll();
		}
		$data['rooms'] = $rooms;
		
		if ($this->request->getMethod() == 'post') {
			
		//echo "<pre>";print_r($this->request->getVar());exit;				
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
				'BrID' => $this->request->getVar('BrID'),  
				'BuildingName' => $this->request->getVar('BuildingName')
			];
			//print_r($data);exit;
			$BuildingModel->update($id, $data);
			
			$floors = $this->request->getVar('FloorName');
			if($floors){
				$FloorModel->where('BID', $id)->delete();//delete all floors
				$RoomModel->where('BID', $id)->delete();//delete all rooms
				for($i=0;$i<count($floors);$i++){
					$floordata = [
						'OrgID' => $this->request->getVar('OrgID'),	
						'BID' => $id,
						'FloorName' => $this->request->getVar('FloorName')[$i],
						'Status' => 1
					];
					$floorsave = $FloorModel->insert($floordata);
					$floorid = $FloorModel->getInsertID();
					$rooms = $this->request->getVar('RoomName');
					for($j=0;$j<count($rooms[$i]);$j++){
						$roomdata = [
							'OrgID' => $this->request->getVar('OrgID'),	
							'BID' => $id,
							'FID' => $floorid,
							'RoomName' => $this->request->getVar('RoomName')[$i][$j],
							'Status' => 1
						];
						$roomsave = $RoomModel->insert($roomdata);
						//$floorid = $FloorModel->getInsertID();
						
					}				
				}
			}
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/buildings'))->with('msg', $msg);
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
		$BuildingModel->where('BID', $id)->delete();//delete all floors
		$FloorModel->where('BID', $id)->delete();//delete all floors
		$RoomModel->where('BID', $id)->delete();//delete all rooms 
		echo 1;
		exit;
	}
}