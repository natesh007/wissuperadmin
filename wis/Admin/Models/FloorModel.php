<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class FloorModel extends Model {
    protected $table='floor';
    protected $primaryKey='FID';
    protected $allowedFields = ['OrgID','BKID','FloorName', 'Status', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'];

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
    function get_floors($page, $perpage, $keyword, $status) 
    {
        $start_from = ($page - 1) * $perpage;
        $query = 'SELECT f.*, a.Name, o.OrgName, b.BuildingName FROM floor f left join admins a on a.AID = f.UpdatedBy left join organization o on o.OrgID  = f.OrgID left join building b on b.BID   = f.BID ' ;
        if ($keyword !=''&& $status !='') {
            $query .=' where f.floorName  like "%'. $keyword . '%" AND f.Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $query .=' where f.floorName  like "%'. $keyword . '%"';
        }

        else if ($keyword==''&& $status !='') {
            $query .=' where f.Status = '.$status;
        }
        $query .=' Limit ' . $start_from . ',' . $perpage;
        $branch['results'] = $this->db->query($query)->getResultArray();
        $countquery = 'SELECT count(FID) as ttl_rows FROM floor';
        if ($keyword !=''&& $status !='') {
            $countquery .=' where floorName  like "%'. $keyword . '%" AND Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $countquery .=' where floorName like "%'. $keyword . '%"';
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
        $branch['ttl_rows'] = $row->ttl_rows;
        $adjacents = "2";
        $previous_page = $page - 1;
        $next_page = $page + 1;
        $totalPages = ceil($row->ttl_rows / $perpage);
        $second_last = $totalPages - 1; // total page minus 1
        $utilmodel = new UtilModel;
        $pagelinks = $utilmodel->build_pagelinks($actual_link, $previous_page, $next_page, $totalPages, $adjacents, $page, $second_last);
        $branch['pagelinks'] = $pagelinks;
        return $branch;


     
    }
    
}