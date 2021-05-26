<?php

namespace App\Controllers;

use App\Models\PengaturanModel;
use App\Models\InformasiModel;
use App\Models\PendaftarModel;
use App\Models\IdentitasModel;
use App\Models\OrtuModel;



class Formulir extends BaseController
{
    protected $pengaturanModel;
    protected $informasiModel;
    protected $pendaftarModel;
    protected $identitasModel;
    protected $ortuModel;
    public function __construct()
    {
        // helper('pmb');
        // is_logged_in();
        $this->pengaturanModel = new PengaturanModel();
        $this->informasiModel = new InformasiModel();
        $this->pendaftarModel = new PendaftarModel();
        $this->identitasModel = new IdentitasModel();
        $this->ortuModel = new OrtuModel();
        $this->db = \Config\Database::connect();
    }
    //cetak formulir
    public function cetakformulir($id_pendaftar)
    {
        $data = [
            'title' => 'SiPMB | Formulir Pendaftaran',
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'informasi' => $this->informasiModel->getInformasi(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray(),
            'prodi' => $this->db->table('prodi')->get()->getResultArray(),
            'pekerjaan' => $this->db->table('pekerjaan')->get()->getResultArray(),
            'validation' => \Config\Services::validation(),
            'pendaftar' => $this->pendaftarModel->getDetail($id_pendaftar),
            'detail_ortu' => $this->pendaftarModel->getDetailortu($id_pendaftar)
            // 'pendaftar' = $this->db->table('pendaftar')->getWhere('')
        ];

        return view('user/formulir/cetakformulir', $data);
    }
}
