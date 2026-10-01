<?php
namespace App\Models;

use CodeIgniter\Model;

class TamboModel extends Model
{
    protected $table = 'tambos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['productor', 'latitud', 'longitud'];
}