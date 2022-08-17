<?php
namespace Modules\Admin\Controllers;

use Modules\Admin\Models\ComplaintCategoryModel;
use Modules\Admin\Models\ComplaintCategoryOrganizationModel;
use Modules\Admin\Models\AdminsModel;
use Modules\Admin\Models\OrganizationModel;

class ComplaintCategory extends BaseController
{
   
    public function index($order = '', $sort = '', $starting = 0)
    {
		session()->set('complaintcategory_page', '/complaintcategories');
		$data['pager'] = \Config\Services::pager();
		$model = new ComplaintCategoryModel();
		$ComplaintCategoryOrganizationModel = new ComplaintCategoryOrganizationModel();
		$OrganizationModel = new OrganizationModel();
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

		$complaintcategory = $model->get_complaintcategories($page, $perPage, $keyword, '');
		//echo "<pre>";print_r($complaintcategory);exit;
		$data['keyword'] = $keyword;

		$data['complaintcategory'] = $complaintcategory['results'];
		$orgs = [];
		foreach($data['complaintcategory'] as $rec){
			$orgnames = $model->getorgnames($rec['ComCatID']);
			$o = [];
			foreach($orgnames as $org){
				$o[$rec['ComCatID']][] = $org['OrgName'];echo " ";
			}
			
			$orgs[$rec['ComCatID']] = implode(", ",$o[$rec['ComCatID']]);
		}
		$data['orgs'] = $orgs;
		$data['pagelinks'] = $complaintcategory['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintcategory', $data);
    }
    public function active_complaintcategories($order = '', $sort = '', $starting = 0)
	{
		
		session()->set('complaintcategory_page', '/active_complaintcategories');
		$data['pager'] = \Config\Services::pager();
		$model = new ComplaintCategoryModel();
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
		$complaintcategory = $model->get_complaintcategories($page, $perPage, $keyword, '1');
		$data['keyword'] = $keyword;
		$data['complaintcategory'] = $complaintcategory['results'];
		$orgs = [];
		foreach($data['complaintcategory'] as $rec){
			$orgnames = $model->getorgnames($rec['ComCatID']);
			$o = [];
			foreach($orgnames as $org){
				$o[$rec['ComCatID']][] = $org['OrgName'];echo " ";
			}
			
			$orgs[$rec['ComCatID']] = implode(", ",$o[$rec['ComCatID']]);
		}
		$data['orgs'] = $orgs;
		$data['pagelinks'] = $complaintcategory['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintcategory', $data);
	}
	public function inactive_complaintcategories($order = '', $sort = '', $starting = 0)
	{
        
		session()->set('complaintcategory_page', '/inactive_complaintcategories');
		$data['pager'] = \Config\Services::pager();
		$model = new ComplaintCategoryModel();
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
		$complaintcategory = $model->get_complaintcategories($page, $perPage, $keyword, '0');
		$data['complaintcategory'] = $complaintcategory['results'];
		$orgs = [];
		foreach($data['complaintcategory'] as $rec){
			$orgnames = $model->getorgnames($rec['ComCatID']);
			$o = [];
			foreach($orgnames as $org){
				$o[$rec['ComCatID']][] = $org['OrgName'];echo " ";
			}
			
			$orgs[$rec['ComCatID']] = implode(", ",$o[$rec['ComCatID']]);
		}
		$data['orgs'] = $orgs;
		
		$data['keyword'] = $keyword;
		$data['complaintcategory'] = $complaintcategory['results'];
		$data['pagelinks'] = $complaintcategory['pagelinks'];
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintcategory', $data);
	}

    public function add_complaintcategory()
	{
		$ComplaintCategoryModel = new ComplaintCategoryModel();
		$ComplaintCategoryOrganizationModel = new ComplaintCategoryOrganizationModel();
        $AdminsModel = new AdminsModel();
		
        $data['organizations'] = $AdminsModel->getmasterdata('organization');
		
		if ($this->request->getMethod() == 'post') {
			$OrgID=$this->request->getVar('OrgID');
			//echo "<pre>";print_r($OrgID);exit;
				$img = '';
				if ($this->request->getFile('CategoryIcon') != '') {
					$orginalextension = $this->request->getFile('CategoryIcon')->getClientExtension();
					$randcharforimg = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);
					$newimgname = $randcharforimg . '-' . time() . '.' . $orginalextension;
					$this->request->getFile('CategoryIcon')->move(WRITEPATH . 'uploads/category/', $newimgname);
					$img = 'writable/uploads/category/' . $newimgname;
				}
				//ECHO $img;exit;
				
			
			if(!empty($OrgID)){
				
				$data = [
					'CategoryName' => $this->request->getVar('CategoryName'),  
					'CategoryIcon' => $img,
					'Status' => 1
				];
			
				$save = $ComplaintCategoryModel->insert($data);
				$catid= $ComplaintCategoryModel->insertID;
				for($i=0;$i<count($OrgID);$i++){
					$data1 = [
						'OrgID' =>$OrgID[$i], 
						'ComCatID' => $catid,  		
					];
				
				$save1 = $ComplaintCategoryOrganizationModel->insert($data1);
				
				}
			$msg = 'Data Saved Successfully';
			return redirect()->to(base_url('admin/complaintcategories'))->with('msg', $msg);
			}
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintcategory_form',$data);
	}

	public function edit_complaintcategory($id = null)
	{
		
		$ComplaintCategoryModel = new ComplaintCategoryModel();
		$ComplaintCategoryOrganizationModel = new ComplaintCategoryOrganizationModel();
        $AdminsModel = new AdminsModel();
        //echo $session->get('AID');exit;
        $data['Organizations'] = $AdminsModel->getmasterdata('organization');
		
		$data['complaintcategory'] = $ComplaintCategoryModel->where('ComCatID', $id)->first();

		$organizations = $ComplaintCategoryOrganizationModel->where('ComCatID', $data['complaintcategory']['ComCatID'])->findAll();
		$selorganizations=[];
		foreach($organizations as $c){
			$selorganizations[]=$c['OrgID'];
		}
		$data['selorganizations'] = $selorganizations;
		if ($this->request->getMethod() == 'post') {
			$img = '';
            if ($this->request->getFile('CategoryIcon') != '') {
				if(isset($data['complaintcategory']['CategoryIcon'])){
					if(file_exists($data['complaintcategory']['CategoryIcon'])){
						unlink($data['complaintcategory']['CategoryIcon']);
					}
				}
                $orginalextension = $this->request->getFile('CategoryIcon')->getClientExtension();
                $randcharforimg = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8 / strlen($x)))), 1, 8);
                $newimgname = $randcharforimg . '-' . time() . '.' . $orginalextension;
                $this->request->getFile('CategoryIcon')->move(WRITEPATH . 'uploads/category/', $newimgname);
                $img = 'writable/uploads/category/' . $newimgname;
            }else{
                $img = $this->request->getVar('OldCategoryIcon') ;
            }

			
			$organizations=$this->request->getVar('OrgID');
			//echo "<pre>";print_r($cities);exit;
			if($organizations){
			$data = [
				'CategoryName' => $this->request->getVar('CategoryName'),  
				'CategoryIcon' => $img		
			];
		
			$ComplaintCategoryModel->update($id, $data);
			$ComplaintCategoryOrganizationModel->where('ComCatID', $id)->delete();
			for($i=0;$i<count($organizations);$i++){				
					$data1 = [
						'ComCatID' => $id,  
						'OrgID' => $organizations[$i]
					];			
					$save1 = $ComplaintCategoryOrganizationModel->insert($data1);
			
			}
			$msg = 'Data Updated Successfully';
			return redirect()->to(base_url('admin/complaintcategories'))->with('msg', $msg);
			}
		}
		echo view('Modules\Admin\Views\common\header');
		echo view('Modules\Admin\Views\complaintcategory_edit_form', $data);
	}

	function deletecomplaintcategory(){
		$ComplaintCategoryModel = new ComplaintCategoryModel();
		$ComplaintCategoryOrganizationModel = new ComplaintCategoryOrganizationModel();
		$id = $this->request->getVar('Id');
		$ComplaintCategoryModel->where('ComCatID', $id)->delete();
		$ComplaintCategoryOrganizationModel->where('ComCatID', $id)->delete();
	}
}