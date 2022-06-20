<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class AdminsModel extends Model
{
  protected $table = 'admins';
  protected $primaryKey = 'AID';

  protected $allowedFields = ['Name', 'Email', 'Password', 'Role', 'Status', 'CreatedBy', 'CreatedDate', 'UpdatedBy', 'UpdatedDate'];
}
