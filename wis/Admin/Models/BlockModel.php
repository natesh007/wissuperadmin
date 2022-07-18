<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class blockModel extends Model {
    protected $table='block';
    protected $primaryKey='BKID';
    protected $allowedFields = ['OrgID','BID','BlockName', 'Status', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'];

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
    function get_blocks($page, $perpage, $keyword, $status) 
    {
        $start_from = ($page - 1) * $perpage;
        $query = 'SELECT bl.*, a.Name, o.OrgName, b.BuildingName FROM block bl left join admins a on a.AID = bl.UpdatedBy left join organization o on o.OrgID  = bl.OrgID left join building b on b.BID   = bl.BID' ;
        if ($keyword !=''&& $status !='') {
            $query .=' where bl.BlockName  like "%'. $keyword . '%" AND bl.Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $query .=' where bl.BlockName  like "%'. $keyword . '%"';
        }

        else if ($keyword==''&& $status !='') {
            $query .=' where bl.Status = '.$status;
        }
        $query .=' Limit ' . $start_from . ',' . $perpage;
        $branch['results'] = $this->db->query($query)->getResultArray();
        $countquery = 'SELECT count(BKID) as ttl_rows FROM block';
        if ($keyword !=''&& $status !='') {
            $countquery .=' where BlockName  like "%'. $keyword . '%" AND Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $countquery .=' where BlockName like "%'. $keyword . '%"';
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