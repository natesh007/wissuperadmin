<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class EmployeeModel extends Model {
    protected $table='employees';
    protected $primaryKey='EmpID';
    protected $allowedFields = ['RoleID','EmpName','DeptID','OrgID','Gender','EmailID','Password','Address','Contact','JobType','City','DateOfJoining','Doc', 'ProfilePic','Status', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'];

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
    function get_employees($page, $perpage, $keyword, $status) 
    {
        $start_from = ($page - 1) * $perpage;
        $query = 'SELECT e.*, a.Name, d.DeptName,o.OrgName FROM employees e left join admins a on a.AID = e.UpdatedBy left join departments d on d.DeptID   = e.DeptID left join organization o on o.OrgID   = e.OrgID';
        if ($keyword !=''&& $status !='') {

            $query .=' where e.EmpName like "%'. $keyword . '%" OR e.EmailID like "%'. $keyword . '%" OR e.Contact like "%'. $keyword . '%" AND e.Status = '.$status ;

        }

        else if ($keyword !=''&& $status=='') {
            $query .=' where e.EmpName like "%'. $keyword . '%" OR e.EmailID like "%'. $keyword . '%" OR e.Contact like "%'. $keyword . '%"' ;
        }

        else if ($keyword==''&& $status !='') {
            $query .=' where e.Status = '.$status;
        }
        $query .=' Limit ' . $start_from . ',' . $perpage;
        $branch['results'] = $this->db->query($query)->getResultArray();
        $countquery = 'SELECT count(EmpID) as ttl_rows FROM employees';
        if ($keyword !=''&& $status !='') {
            $countquery .=' where EmpName  like "%'. $keyword . '%" AND Status = '.$status;
        }

        else if ($keyword !=''&& $status=='') {
            $countquery .=' where EmpName like "%'. $keyword . '%"';
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