<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\ShiftModel;

class Shift extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('shift_page', '/shifts');
		$data['pager'] = \Config\Services::pager();
		$model = new ShiftModel();
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

		$shift = $model->get_shifts($page, $perPage, $keyword, '');

		$data['keyword'] = $keyword;

		$data['shift'] = $shift['results'];


		$data['pagelinks'] = $shift['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\shift', $data);
    }
    public function active_shifts($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('shift_page', '/active_shifts');
		$data['pager'] = \Config\Services::pager();
		$model = new ShiftModel();
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
		$shift = $model->get_shifts($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['shift'] = $shift['results'];
		$data['pagelinks'] = $shift['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\shift', $data);
	}
	public function inactive_shifts($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('shift_page', '/inactive_shifts');
		$data['pager'] = \Config\Services::pager();
		$model = new ShiftModel();
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
		$shift = $model->get_shifts($page, $perPage, $keyword, '0');
		$data['keyword'] = $keyword;
		$data['shift'] = $shift['results'];
		$data['pagelinks'] = $shift['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\shift', $data);
	}
    public function add_shift()
	{
		
		$ShiftModel = new ShiftModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'ShCode' => $this->request->getVar('ShCode'),
                'ShType' => $this->request->getVar('ShType'),
                'ShCode' => $this->request->getVar('ShCode'),
				'Status' => 1
			];
			$save = $ShiftModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/shifts'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\shift_form');
	}

	public function edit_shift($id = null)
	{
		
		$ShiftModel = new ShiftModel();
		$data['shift'] = $ShiftModel->where('ShID', $id)->first();
		//echo "<pre>";print_r($data['shifts']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'ShCode' => $this->request->getVar('ShCode'),
                'ShType' => $this->request->getVar('ShType'),
                'ShCode' => $this->request->getVar('ShCode')				
			];
			//print_r($data);exit;
			$ShiftModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/shifts'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\shift_edit_form', $data);
	}
}