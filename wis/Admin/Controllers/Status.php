<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\StatusModel;

class Status extends BaseController
{
   
    public function index($status = '')
    {
		if($status == ''){
			session()->set('status_page', '/status');
		}else{
			session()->set('status_page', '/status/'.$status);
		}
		
		$data['pager'] = \Config\Services::pager();
		$model = new StatusModel();
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

		$status = $model->get_status($page, $perPage, $keyword, $status);

		$data['keyword'] = $keyword;

		$data['status'] = $status['results'];


		$data['pagelinks'] = $status['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\status', $data);
    }
    
    public function add_status()
	{
		
		$StatusModel = new StatusModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'StatusName' => $this->request->getVar('StatusName'),
				'Status' => 1
			];
			$save = $StatusModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/status'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\status_form');
	}

	public function edit_status($id = null)
	{
		
		$StatusModel = new StatusModel();
		$data['status'] = $StatusModel->where('StatusID', $id)->first();
		//echo "<pre>";print_r($data['status']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'StatusName' => $this->request->getVar('StatusName')			
			];
			//print_r($data);exit;
			$StatusModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/status'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\status_edit_form', $data);
	}
}