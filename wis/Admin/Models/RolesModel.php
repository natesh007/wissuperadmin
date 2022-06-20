<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class RolesModel extends Model {
    protected $table='roles';
    protected $primaryKey='RoleID';
    protected $allowedFields = ['RoleName', 'Priority', 'Status', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'];

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

    function get_roles($page, $perpage, $keyword, $status) {
        $start_from = ($page - 1) * $perpage;
        $query = 'SELECT r.*, a.Name FROM roles r left join admins a on a.AID = r.UpdatedBy';
        if ($keyword !=''&& $status !='') {
            $query .=' where r.RoleName  like "%'. $keyword . '%" AND crStatus = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $query .=' where r.RoleName  like "%'. $keyword . '%"';
        }

        else if ($keyword==''&& $status !='') {
            $query .=' where r.Status = '.$status;
        }
        $query .=' ORDER BY r.Priority ASC Limit ' . $start_from . ',' . $perpage;
        $roles['results'] = $this->db->query($query)->getResultArray();
        $countquery = 'SELECT count(RoleID  ) as ttl_rows FROM roles';
        if ($keyword !=''&& $status !='') {
            $countquery .=' where RoleName  like "%'. $keyword . '%" AND Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $countquery .=' where RoleName like "%'. $keyword . '%"';
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
        $roles ['ttl_rows'] = $row->ttl_rows;
        $adjacents = "2";
        $previous_page = $page - 1;
        $next_page = $page + 1;
        $totalPages = ceil($row->ttl_rows / $perpage);
        $second_last = $totalPages - 1; // total page minus 1
        $utilmodel = new UtilModel;
        $pagelinks = $utilmodel->build_pagelinks($actual_link, $previous_page, $next_page, $totalPages, $adjacents, $page, $second_last);
        $roles['pagelinks'] = $pagelinks;
        return $roles;


    }
}