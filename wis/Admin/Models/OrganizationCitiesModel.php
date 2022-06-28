<?php namespace Modules\Admin\Models;

use CodeIgniter\Model;
use Modules\Admin\Models\UtilModel;

class OrganizationCitiesModel extends Model {
    protected $table='organizationcities';
    protected $primaryKey='OcID';
    protected $allowedFields = ['OrgID','CityID', 'CreatedDate'];

    protected $beforeInsert=['beforeInsert'];
    protected $beforeUpdate=['beforeUpdate'];

    protected function beforeInsert(array $data) {        
        $data['data']['CreatedDate']=date('Y-m-d H:i:s');
        return $data;
    }

    function get_cities($id){
        $query = 'SELECT c.CityName FROM organizationcities oc left join cities c on c.CityID = oc.CityID where oc.OrgID = '.$id;
        $results = $this->db->query($query)->getResultArray();
        return $results;
    }
    
    
}