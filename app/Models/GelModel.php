<?php

namespace App\Models;

use CodeIgniter\Model;

class GelModel extends Model
{
    protected $table = "gelombang";
    protected $UseTimestamps = TRUE;
    protected $allowedFields = ['tgl_buka', 'tgl_tutup', 'keterangan', 'status'];

    public function getGelombang($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id])->first();
    }
}
