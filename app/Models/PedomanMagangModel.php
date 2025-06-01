<?php

namespace App\Models;
use CodeIgniter\Model;

class PedomanMagangModel extends Model
{
    protected $table = 'pedoman_magang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'file_path', 'deskripsi', 'created_at'];
}
