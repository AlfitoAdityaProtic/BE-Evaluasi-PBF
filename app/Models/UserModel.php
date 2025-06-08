<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'NPM'; // Sesuaikan dengan nama kolommu (case-sensitive)
    protected $useAutoIncrement = false; // Karena npm bukan auto increment
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NPM', 'nama_lengkap', 'password'];

    // Matikan fitur timestamps
    protected $useTimestamps = false;

    // Kalau fitur timestamps mati, field ini tidak perlu diisi
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Optional: jika pakai fitur casts atau tidak
    protected array $casts = [];
    protected array $castHandlers = [];

    // Optional: validasi
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks (boleh kamu matikan semua jika tidak pakai)
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
