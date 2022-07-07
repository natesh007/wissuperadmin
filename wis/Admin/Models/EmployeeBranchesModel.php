<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class EmployeeBranchesModel extends Model {
    protected $table='employeebranches';
    protected $primaryKey='EmpBrID ';
    protected $allowedFields = ['EmpID','BrID', 'CreatedDate'];

    protected $beforeInsert=['beforeInsert'];
    protected $beforeUpdate=['beforeUpdate'];

    protected function beforeInsert(array $data) {        
        $data['data']['CreatedDate']=date('Y-m-d H:i:s');
        return $data;
    }

    
    
}