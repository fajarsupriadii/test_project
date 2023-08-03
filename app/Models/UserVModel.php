<?php

namespace App\Models;

use CodeIgniter\Model;

class UserVModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_v';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
}
