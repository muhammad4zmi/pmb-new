<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table = "prodi";
    protected $UseTimestamps = TRUE;
    protected $allowedFields = ['kode_prodi', 'prodi'];

    public function getProdi($kode_prodi = false)
    {
        if ($kode_prodi == false) {
            return $this->findAll();
        }

        return $this->where(['kode_prodi' => $kode_prodi])->first();
    }
    public function updateProdi($data, $id)
    {
        $query = $this->db->table('prodi')->update($data, array('kode_prodi' => $id));
        return $query;
    }

    public function deleteProdi($id)
    {
        $query = $this->db->table('prodi')->delete(array('kode_prodi' => $id));
        return $query;
    }
}
