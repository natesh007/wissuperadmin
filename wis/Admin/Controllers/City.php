<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\CityModel;
use Modules\Admin\Models\AdminsModel;

class City extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('city_page', '/cities');
		$data['pager'] = \Config\Services::pager();
		$model = new CityModel();
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

		$city = $model->get_cities($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['city'] = $city['results'];


		$data['pagelinks'] = $city['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\city', $data);
    }
    public function active_cities($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('city_page', '/active_cities');
		$data['pager'] = \Config\Services::pager();
		$model = new CityModel();
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
		$city = $model->get_cities($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['city'] = $city['results'];
		$data['pagelinks'] = $city['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\city', $data);
	}
	public function inactive_cities($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('city_page', '/inactive_cities');
		$data['pager'] = \Config\Services::pager();
		$model = new CityModel();
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
		$city = $model->get_cities($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['city'] = $city['results'];
		$data['pagelinks'] = $city['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\city', $data);
	}

    public function add_city()
	{
		$CityModel = new CityModel();
        $AdminsModel = new AdminsModel();
        
		if ($this->request->getMethod() == 'post') {
			$data = [ 
				'CityName' => $this->request->getVar('CityName'),            
				'Langitude' => $this->request->getVar('Langitude'),
				'Latitude' => $this->request->getVar('Latitude'),
                'Status' => 1
			];
			$save = $CityModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/cities'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\city_form');
	}

	public function edit_city($id = null)
	{
		
		$CityModel = new CityModel();
        $AdminsModel = new AdminsModel();
        
		$data['city'] = $CityModel->where('CityID  ', $id)->first();
		//echo "<pre>";print_r($data['cities']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'CityName' => $this->request->getVar('CityName'),            
				'Langitude' => $this->request->getVar('Langitude'),
				'Latitude' => $this->request->getVar('Latitude')
			];
			//print_r($data);exit;
			$CityModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/cities'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\city_edit_form', $data);
	}
}