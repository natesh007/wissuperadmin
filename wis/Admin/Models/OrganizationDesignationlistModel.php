<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class OrganizationDesignationlistModel extends Model {
    protected $table='organizationdesignationlist';
    protected $primaryKey='OdgID';
    protected $allowedFields = ['OrgID','DesignationID', 'CreatedDate'];

    protected $beforeInsert=['beforeInsert'];
    protected $beforeUpdate=['beforeUpdate'];

    protected function beforeInsert(array $data) {        
        $data['data']['CreatedDate']=date('Y-m-d H:i:s');
        return $data;
    }
    
}