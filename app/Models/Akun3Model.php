<?php

namespace App\Models;

use CodeIgniter\Model;

class Akun3Model extends Model
{
    protected $table            = 'akun_3';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_akun_2', 'kode_akun_3', 'nama_akun_3', 'saldo_normal'];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAkun3Complete()
    {
        return $this->select('akun_3.*, akun_2.nama_akun_2, akun_1.nama_akun_1')
                    ->join('akun_2', 'akun_2.id = akun_3.id_akun_2')
                    ->join('akun_1', 'akun_1.id = akun_2.id_akun_1')
                    ->findAll();
    }
}
