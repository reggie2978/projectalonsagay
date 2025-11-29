<?php

namespace App\Models;
use CodeIgniter\Model;

class SystemSettingModel extends Model
{
    protected $table = 'system_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['maintenance_mode'];
}
