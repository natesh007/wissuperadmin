<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class AdminsModel extends Model
{
  protected $table = 'admins';
  protected $primaryKey = 'AID';

  protected $allowedFields = ['Name', 'Email', 'Password', 'Role', 'Status', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'];


protected function beforeInsert(array $data) {
  $data['data']['CreatedBy']=session()->get('AID');
  $data['data']['CreatedDate']=date('Y-m-d H:i:s');
  $data['data']['UpdatedBy']=session()->get('aid');
  $data['data']['UpdatedDate']=date('Y-m-d H:i:s');
  $data = $this->passwordHash($data);
  return $data;
}

protected function beforeUpdate(array $data) {
  $data['data']['UpdatedBy']=session()->get('AID');
  $data['data']['UpdatedDate']=date('Y-m-d H:i:s');
  $data = $this->passwordHash($data);
  return $data;
}

protected function passwordHash(array $data) {
  if (isset($data['data']['Password'])) $data['data']['Password']=password_hash($data['data']['Password'], PASSWORD_DEFAULT);
  return $data;
}

function get_admins($page, $perpage, $keyword, $status) {
  $start_from=($page - 1) * $perpage;
  $query='SELECT a.*,r.RoleName FROM admins as a left join roles as r on r.RoleID = a.Role';

  if ($keyword !=''&& $status !='') {
    $query .=' where (a.Email like "%'. $keyword . '%" or a.Name like "%'. $keyword . '%" or r.RoleName like "%'. $keyword . '%") and a.Status = '.$status;
  }

  else if ($keyword !=''&& $status=='') {
    $query .=' where a.Email like "%'. $keyword . '%" or a.Name like "%'. $keyword . '%" or r.RoleName like "%'. $keyword . '%"';
  }

  else if ($keyword==''&& $status !='') {
    $query .=' where a.Status = '.$status;
  }

  $query .=' ORDER BY a.Priority ASC Limit '. $start_from . ','. $perpage;
  $admins['results']=$this->db->query($query)->getResultArray();
  foreach($admins['results'] as $key => $res){
    $result = $this->db->query('SELECT Name FROM admins WHERE AID = '.$res['UpdatedBy'])->getRowArray();
    $admins['results'][$key]['UpdatedBy'] = '' ;
    if(!empty($result) && isset($result['Name'])){
      $admins['results'][$key]['UpdatedBy'] = $result['Name'];
    } 
  }
  $countquery = 'SELECT count(AID) as ttl_rows FROM admins as a left join roles as r on r.RoleID = a.Role';

  if ($keyword !=''&& $status !='') {
    $countquery .=' where (a.Email like "%'. $keyword . '%" or a.Name like "%'. $keyword . '%" or r.RoleName like "%'. $keyword . '%") and a.Status = '.$status;
  }

  else if ($keyword !=''&& $status=='') {
    $countquery .=' where a.Email like "%'. $keyword . '%" or a.Name like "%'. $keyword . '%" or r.RoleName like "%'. $keyword . '%"';
  }

  else if ($keyword==''&& $status !='') {
    $countquery .=' where a.Status = '.$status;
  }

  $row=$this->db->query($countquery)->getRow();
  $query_str_actual_link="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $actual_link_array=explode('?', $query_str_actual_link);
  $actual_link=$actual_link_array[0];

  if ($keyword=='') {
    $actual_link=$actual_link_array[0] . '?';
  }

  else {
    $actual_link=$actual_link_array[0] . '?'. 'key_word='. $keyword . '&';
  }

  $admins['ttl_rows']=$row->ttl_rows;
  $adjacents="2";
  $previous_page=$page - 1;
  $next_page=$page+1;
  $totalPages=ceil($row->ttl_rows / $perpage);
  $second_last=$totalPages - 1; // total page minus 1
  $utilmodel=new UtilModel;
  $pagelinks=$utilmodel->build_pagelinks($actual_link, $previous_page, $next_page, $totalPages, $adjacents, $page, $second_last);
  $admins['pagelinks']=$pagelinks;
  return $admins;
}

public function activate_inactivate($id, $tbl, $col, $data) {
  $this->db->table($tbl)->where($col, $id)->update($data);
  return true;
}

public function deletedata($id, $tbl, $col, $image, $thumb) {
  if($image != ''){
    $query = 'SELECT '.$image;
    if($thumb != ''){
      $query .= ', '.$thumb;
    }
    $query .= ' FROM '. $tbl . ' where ' . $col . ' = ' . $id;
    $img = $this->db->query($query)->getRowArray(); 
    if(isset($img[$image])){
      if(file_exists($img[$image])){
        unlink($img[$image]);
      }
    }
    if($thumb != ''){
      if(isset($img[$thumb])){
        if(file_exists($img[$thumb])){
          unlink($img[$thumb]);
        }
      }
    }
  }
  $this->db->table($tbl)->where($col, $id)->delete();
  return true;
}

public function changepriority($i, $v, $tbl, $col1, $col2) {
  $this->db->query("Update ". $tbl . " SET ". $col1 . " = ". $i . ", UpdatedDate = '" . date('Y-m-d H:i:s') . "', UpdatedBy = '" . session()->get('aid') . "' WHERE ". $col2 . " = ". $v);
  return true;
}

public function getmasterdata($table) {
  return $this->db->query('SELECT * FROM '. $table . ' where Status = 1 ORDER BY Priority ASC')->getResultArray();
}





}
