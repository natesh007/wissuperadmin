<?php

namespace Modules\Admin\Controllers;

use Modules\Admin\Models\JurisdictionsModel;

class Jurisdictions extends BaseController
{
   
    public function index($status = '')
    {
		if($status == ''){
			session()->set('jurisdictions_page', '/jurisdictions');
		}else{
			session()->set('jurisdictions_page', '/jurisdictions/'.$status);
		}
		
		$data['pager'] = \Config\Services::pager();
		$model = new JurisdictionsModel();
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

		$jurisdictions = $model->get_jurisdictions($page, $perPage, $keyword, $status);

		$data['keyword'] = $keyword;

		$data['jurisdictions'] = $jurisdictions['results'];


		$data['pagelinks'] = $jurisdictions['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\jurisdictions', $data);
    }
    
    public function add_jurisdictions()
	{
		
		$JurisdictionsModel = new JurisdictionsModel();
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Jurisdictions' => $this->request->getVar('Jurisdictions'),
				'Status' => 1
			];
			$save = $JurisdictionsModel->insert($data);
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/jurisdictions'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\jurisdictions_form');
	}

	public function edit_jurisdictions($id = null)
	{
		
		$JurisdictionsModel = new JurisdictionsModel();
		$data['jurisdictions'] = $JurisdictionsModel->where('JurisdictionsID', $id)->first();
		//echo "<pre>";print_r($data['jurisdictions']);exit;
		if ($this->request->getMethod() == 'post') {
			$data = [
				'Jurisdictions' => $this->request->getVar('Jurisdictions')			
			];
			//print_r($data);exit;
			$JurisdictionsModel->update($id, $data);
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/jurisdictions'))->with('msg', $msg);
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\jurisdictions_edit_form', $data);
	}
}