<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class ComplaintCategoryOrganizationModel extends Model {
    protected $table='complaintcategoryorganizations';
    protected $primaryKey='ComCatOrgID';
    protected $allowedFields = ['ComCatID','OrgID', 'CreatedDate'];

    protected $beforeInsert=['beforeInsert'];
    protected $beforeUpdate=['beforeUpdate'];

    protected function beforeInsert(array $data) {
        $data['data']['CreatedDate']=date('Y-m-d H:i:s');
        return $data;
    }

      
}