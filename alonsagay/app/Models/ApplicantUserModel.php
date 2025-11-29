<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicantUserModel extends Model
{
    protected $table = 'applicant_users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password_hash',
        'contact',
        'address',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
