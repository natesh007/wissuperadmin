<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class BuildingModel extends Model {
    protected $table='building';
    protected $primaryKey='BID';
    protected $allowedFields = ['OrgID','BrID','BuildingName','Status', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'];

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
    function get_buildings($page, $perpage, $keyword, $status) 
    {
        $start_from = ($page - 1) * $perpage;
        $query = 'SELECT b.*, a.Name, o.OrgName FROM building b left join admins a on a.AID = b.UpdatedBy left join organization o on o.OrgID  = b.OrgID';
        if ($keyword !=''&& $status !='') {
            $query .=' where b.BuildingName  like "%'. $keyword . '%" AND b.Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $query .=' where b.BuildingName  like "%'. $keyword . '%"';
        }

        else if ($keyword==''&& $status !='') {
            $query .=' where b.Status = '.$status;
        }
        $query .=' Limit ' . $start_from . ',' . $perpage;
        $branch['results'] = $this->db->query($query)->getResultArray();
        $countquery = 'SELECT count(BID) as ttl_rows FROM building';
        if ($keyword !=''&& $status !='') {
            $countquery .=' where BuildingName  like "%'. $keyword . '%" AND Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $countquery .=' where BuildingName like "%'. $keyword . '%"';
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
    function get_building_data($id){
        $data = $this->db->query('SELECT * FROM building WHERE BID = ' . $id)->getRowArray();
        $data['floors'] = $this->db->query('SELECT * FROM floor WHERE BID = ' . $id)->getResultArray();
        if(!empty($data['floors'])){
            foreach($data['floors'] as $i => $floor){
                $data['floors'][$i]['rooms'] = $this->db->query('SELECT * FROM room WHERE FID = ' . $floor['FID'] . ' AND BID = ' . $id)->getResultArray();
            }
        }
        return $data;
    }
}