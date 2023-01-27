<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class OrganizationDepartmentlistModel extends Model {
    protected $table='organizationdepartmentlist';
    protected $primaryKey='OdID';
    protected $allowedFields = ['OrgID','DeptID', 'CreatedDate'];

    protected $beforeInsert=['beforeInsert'];
    protected $beforeUpdate=['beforeUpdate'];

    protected function beforeInsert(array $data) {        
        $data['data']['CreatedDate']=date('Y-m-d H:i:s');
        return $data;
    } 
    
}