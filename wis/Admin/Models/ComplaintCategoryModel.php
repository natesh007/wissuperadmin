<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class ComplaintCategoryModel extends Model {
    protected $table='complaintcategory';
    protected $primaryKey='ComCatID';
    protected $allowedFields = ['CategoryName','CategoryIcon', 'Status', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'];

    protected $beforeInsert=['beforeInsert'];
    protected $beforeUpdate=['beforeUpdate'];

    protected function beforeInsert(array $data) {
        $data['data']['CreatedBy']=session()->get('AID');
        $data['data']['CreatedDate']=date('Y-m-d H:i:s');
        $data['data']['UpdatedBy']=session()->get('AID');
        $data['data']['UpdatedDate']=date('Y-m-d H:i:s');
        return $data;
    }

    protected function beforeUpdate(array $data) {
        $data['data']['UpdatedBy']=session()->get('AID');
        $data['data']['UpdatedDate']=date('Y-m-d H:i:s');
        return $data;
    }
    function get_complaintcategories($page, $perpage, $keyword, $status) 
    {
        $start_from = ($page - 1) * $perpage;
        $query = "SELECT c.*, a.Name FROM complaintcategory c left join admins a on a.AID = c.UpdatedBy";
        if ($keyword !=''&& $status !='') {
            $query .=' where c.CategoryName  like "%'. $keyword . '%" AND c.Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $query .=' where c.CategoryName  like "%'. $keyword . '%"';
        }

        else if ($keyword==''&& $status !='') {
            $query .=' where c.Status = '.$status;
        }
        $query .=' Limit ' . $start_from . ',' . $perpage;
        $complaintcategory['results'] = $this->db->query($query)->getResultArray();
        $countquery = 'SELECT count(ComCatID) as ttl_rows FROM complaintcategory';
        if ($keyword !=''&& $status !='') {
            $countquery .=' where CategoryName  like "%'. $keyword . '%" AND Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $countquery .=' where CategoryName like "%'. $keyword . '%"';
        }

        else if ($keyword==''&& $status !='') {
            $countquery .=' where Status = '.$status;
        }
        $row   = $this->db->query($countquery)->getRow();
        $query_str_actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link_array = explode('?', $query_str_actual_link);
        $actual_link = $actual_link_array[0];
        if ($keyword == '') {
            $actual_link = $actual_link_array[0] . '?';
        } else {
            $actual_link = $actual_link_array[0] . '?' . 'key_word=' . $keyword . '&';
        }
        $complaintcategory['ttl_rows'] = $row->ttl_rows;
        $adjacents = "2";
        $previous_page = $page - 1;
        $next_page = $page + 1;
        $totalPages = ceil($row->ttl_rows / $perpage);
        $second_last = $totalPages - 1; // total page minus 1
        $utilmodel = new UtilModel;
        $pagelinks = $utilmodel->build_pagelinks($actual_link, $previous_page, $next_page, $totalPages, $adjacents, $page, $second_last);
        $complaintcategory['pagelinks'] = $pagelinks;
        return $complaintcategory;


     
    }

    function getorgnames($id){
        $query = "SELECT o.OrgName FROM complaintcategoryorganizations c left join organization o on o.OrgID = c.OrgID where c.ComCatID = $id";
        $results = $this->db->query($query)->getResultArray();
        //echo "<pre>";print_r($results);
        //echo $this->db->getLastQuery();exit;
        return $results;
    }
    
}