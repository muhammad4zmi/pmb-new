<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftarModel extends Model
{
    protected $table = "pendaftar";
    protected $UseTimestamps = TRUE;
    protected $allowedFields = ['no_pendaftaran', 'nama', 'email', 'password', 'status_datadiri', 'status_dataortu', 'users_id'];


    public function getPendaftar()
    {

        $query = "SELECT pendaftar.no_pendaftaran, pendaftar.nama,pendaftar.email,
                         pendaftar.users_id, pendaftar.status_datadiri, pendaftar.status_dataortu, 
                         date_format(pendaftar.created_at, '%d %b %Y') as tgl,data_diri.id_pendaftar,data_diri.kip,data_diri.kode_kip,
                         data_diri.pil_prodi1, data_diri.kip,data_diri.kode_kip,
                         data_diri.pil_prodi2, prodi.kode_prodi,prodi.prodi,users.id, users.image
                 FROM pendaftar,prodi,data_diri,users
                    WHERE pendaftar.id = data_diri.id_pendaftar 
                    AND pendaftar.users_id=users.id
                AND data_diri.pil_prodi1 = prodi.kode_prodi";
        return $this->db->query($query)->getResultArray();
        // if ($id == false) {
        //     return $this->findAll();
        // }

        // return $this->where(['id' => $id])->first();
    }

    public function getDetail($id_pendaftar)
    {
        $query1 = "SELECT pendaftar.no_pendaftaran, pendaftar.nama,pendaftar.email, 
                          pendaftar.users_id,pendaftar.status_datadiri, pendaftar.status_dataortu, 
                          pendaftar.created_at,data_diri.id_pendaftar,data_diri.tmpt_lahir,data_diri.tgl_lahir, 
                          data_diri.jenis_kelamin,data_diri.no_hp,data_diri.anak_ke,data_diri.alamat, 
                          data_diri.asal_madrasah, data_diri.pil_prodi1, data_diri.pil_prodi2, prodi.kode_prodi,
                          prodi.prodi, users.id, users.image, data_diri.asal_madrasah,data_diri.nik, data_diri.kip, data_diri.kode_kip
                    FROM pendaftar,prodi,data_diri, users 
                        WHERE pendaftar.id = data_diri.id_pendaftar 
                        AND data_diri.pil_prodi1 = prodi.kode_prodi 
                        AND pendaftar.users_id=users.id 
                    AND data_diri.id_pendaftar=$id_pendaftar";

        return $this->db->query($query1)->getResultArray();
    }

    public function getDetailortu($id_pendaftar)
    {
        $queryOrtu = "SELECT data_ortu.id, data_ortu.nama_ayah, data_ortu.nama_ibu, 
                             data_ortu.alamat_ayah,data_ortu.alamat_ibu,data_ortu.pendidikan_ayah,data_ortu.pekerjaan_ayah,
                             data_ortu.pekerjaan_ibu, data_ortu.telepon_ortu,
                             data_ortu.telepon_ortu,data_ortu.id_pendaftar, pendaftar.id, 
                             pendaftar.status_dataortu 
                      FROM data_ortu, pendaftar 
                            WHERE data_ortu.id_pendaftar=pendaftar.id 
                      AND data_ortu.id_pendaftar=$id_pendaftar";
        return $this->db->query($queryOrtu)->getResultArray();
    }
    public function getPendaftarExport()
    {

        // $query = "SELECT pendaftar.no_pendaftaran, pendaftar.nama, pendaftar.users_id, data_diri.tmpt_lahir,date_format(data_diri.tgl_lahir, '%d %M %Y') as tgllahir,data_diri.jenis_kelamin,data_diri.agama,data_diri.alamat,data_diri.no_hp, date_format(pendaftar.created_at, '%d %b %Y') as tgl,data_diri.id_pendaftar, data_diri.pil_prodi1, data_diri.pil_prodi2, prodi.kode_prodi,prodi.prodi,users.id, users.image FROM pendaftar,prodi,data_diri,users WHERE pendaftar.id = data_diri.id_pendaftar AND pendaftar.users_id=users.id AND data_diri.pil_prodi1 = prodi.kode_prodi";
        $query = "SELECT pendaftar.no_pendaftaran, pendaftar.nama, data_diri.tmpt_lahir,date_format(data_diri.tgl_lahir, '%d %M %Y') as tgllahir,data_diri.jenis_kelamin,data_diri.no_hp,data_diri.alamat,prodi.prodi,data_diri.asal_madrasah,data_diri.kip,data_diri.kode_kip, date_format(pendaftar.created_at, '%d %M %Y') as tgldaftar FROM pendaftar,prodi,data_diri,users WHERE pendaftar.id = data_diri.id_pendaftar AND pendaftar.users_id=users.id AND data_diri.pil_prodi1 = prodi.kode_prodi";
        return $this->db->query($query)->getResultArray();
        // if ($id == false) {
        //     return $this->findAll();
        // }

        // return $this->where(['id' => $id])->first();
    }

    public function Jum_mahasiswa_perjurusan()
    {
        $queryChart = "SELECT prodi.kode_prodi, prodi.prodi, data_diri.pil_prodi1, COUNT(data_diri.pil_prodi1) as   total FROM data_diri INNER JOIN prodi ON data_diri.pil_prodi1=prodi.kode_prodi where data_diri.pil_prodi1 GROUP BY prodi.kode_prodi";
        return $this->db->query($queryChart)->getResultArray();
    }
    public function Jum_mahasiswa_jeniskelamin()
    {
        $queryJk = "SELECT data_diri.jenis_kelamin, COUNT(data_diri.jenis_kelamin) as total FROM data_diri WHERE data_diri.id_pendaftar GROUP BY data_diri.jenis_kelamin ";
        return $this->db->query($queryJk)->getResultArray();
    }
}
