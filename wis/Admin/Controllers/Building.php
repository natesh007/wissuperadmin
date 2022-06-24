<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\BuildingModel;
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
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
        //echo "<pre>";print_r($data['building_types'] );exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
				'BuildingName' => $this->request->getVar('BuildingName'),
                'Status' => 1
			];
			$save = $BuildingModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/buildings'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\building_form',$data);
	}

	public function edit_building($id = null)
	{
		
		$BuildingModel = new BuildingModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
		$data['building'] = $BuildingModel->where('BID  ', $id)->first();
		//echo "<pre>";print_r($data['buildings']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'OrgID' => $this->request->getVar('OrgID'),  
				'BuildingName' => $this->request->getVar('BuildingName')
			];
			//print_r($data);exit;
			$BuildingModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/buildings'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\building_edit_form', $data);
	}
}