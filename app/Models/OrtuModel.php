<?php

namespace App\Models;

use CodeIgniter\Model;

class OrtuModel extends Model
{
    protected $table = "data_ortu";
    protected $UseTimestamps = TRUE;
    protected $allowedFields = [
        'id', 'nama_ayah', 'nama_ibu', 'alamat_ayah', 'alamat_ibu', 'pekerjaan_ayah',
        'pekerjaan_ibu', 'pendidikan_ayah', 'pendidikan_ibu', 'telepon_ortu', 'id_pendaftar'
    ];



    public function getDataortu($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
