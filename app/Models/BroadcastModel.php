<?php
namespace App\Models;

use CodeIgniter\Model;

class BroadcastModel extends Model
{
    protected $table = 'broadcast_pesan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'isi', 'untuk', 'created_at'];
}
