<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasModel extends Model
{
    // protected $table = "user_sub_menu";
    // protected $UseTimestamps = TRUE;
    // protected $allowedFields = ['judul', 'slug', 'info'];

    public function getBerkas()
    {
        $query = "SELECT pendaftar.no_pendaftaran, pendaftar.nama,pendaftar.email, 
                         pendaftar.users_id, berkas.no_pendaftaran,berkas.scan,berkas.status, 
                         date_format(berkas.created_at, '%d %b %Y') as tgl_upload, time(berkas.created_at) as jam_upload
                 FROM pendaftar,berkas 
                 WHERE pendaftar.no_pendaftaran = berkas.no_pendaftaran 
                 ORDER BY berkas.status ASC ";

        return $this->db->query($query)->getResultArray();
    }

    public function getEmail($id)
    {
        $query2 = "SELECT pendaftar.no_pendaftaran, pendaftar.nama,pendaftar.email, 
                         pendaftar.users_id, berkas.no_pendaftaran,berkas.scan,berkas.status, 
                         date_format(berkas.created_at, '%d %b %Y') as tgl_upload, time(berkas.created_at) as jam_upload
                 FROM pendaftar,berkas 
                 WHERE pendaftar.no_pendaftaran = berkas.no_pendaftaran and pendaftar.no_pendaftaran = $id
                 ORDER BY berkas.status ASC ";
        return $this->db->query($query2)->getRowArray();
    }
}
