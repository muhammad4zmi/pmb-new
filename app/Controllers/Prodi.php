<?php

namespace App\Controllers;

use App\Models\PendaftarModel;
use App\Models\PengaturanModel;
use App\Models\ProdiModel;
use App\Models\InformasiModel;

class Prodi extends BaseController
{
    protected $prodiModel;

    public function __construct()
    {
        $this->prodiModel = new ProdiModel();
        $this->pendaftarModel = new PendaftarModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->informasiModel = new InformasiModel();
        $this->db = \Config\Database::connect();
        //$this->email = \Config\Services::email();
        helper('pmb');
        is_logged_in();
    }

    public function index()
    {

        $query = $this->db->table('users');
        $data = [
            'title' => 'Program Studi',
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'informasi' => $this->informasiModel->getInformasi(),
            'user' => $query->getWhere(['email' => session('email')])->getRowArray(),
            'prodi' => $this->prodiModel->getProdi(),
            'validation' => \Config\Services::validation()
            // 'pendaftar' => $this->pendaftarModel->getPendaftar()
        ];
        return view('admin/prodi/index', $data);
    }

    public function addprodi()
    {
        //validasi
        if (!$this->validate([
            'kodeprodi' => [
                'rules' => 'required|is_unique[prodi.kode_prodi]|trim',
                'errors' => [
                    'required' => 'Kode Prodi tidak boleh kosong!',
                    'is_unique' => 'Kode Prodi yang dimasukkan sudah ada!'
                ]
            ],
            'prodi' => [
                'rules' => 'required|trim|is_unique[prodi.prodi]',
                'errors' => [
                    'required' => 'Nama Prodi tidak boleh kosong!',
                    'is_unique' => 'Nama Prodi sudah ada!'
                ]
            ]
        ])) {
            //$validation = \Config\Services::validation();
            return redirect()->to('/admin/prodi/')->withInput();
        }

        $this->prodiModel->save([
            'kode_prodi' => $this->request->getVar('kodeprodi'),
            'prodi' => $this->request->getVar('prodi')

        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        return redirect()->to('/admin/prodi');
    }

    public function update()
    {
        $infoLama = $this->prodiModel->getProdi($this->request->getVar('kodeprodi'));
        if ($infoLama['prodi'] == $this->request->getVar('prodi')) {
            $rule_prodi = 'required';
        } else {
            $rule_prodi = 'required|is_unique[prodi.prodi]';
        }
        //validasi
        if (!$this->validate([
            'kodeprodi' => [
                'rules' => $rule_prodi,
                'errors' => [
                    'required' => 'Kode Prodi tidak boleh kosong!',
                    'is_unique' => 'Kode Prodi yang dimasukkan sudah ada!'
                ]
            ],
            'prodi' => [
                'rules' => 'required|trim|is_unique[prodi.prodi]',
                'errors' => [
                    'required' => 'Nama Prodi tidak boleh kosong!',
                    'is_unique' => 'Nama Prodi sudah ada!'
                ]
            ]
        ])) {
            //$validation = \Config\Services::validation();
            return redirect()->to('/admin/prodi/')->withInput();
        }
        $model = new ProdiModel();
        $id = $this->request->getPost('kodeprodi');
        $data = array(
            'prodi'        => $this->request->getPost('prodi')
        );
        $model->updateProdi($data, $id);
        session()->setFlashdata('pesan', 'Data berhasil di update!');
        return redirect()->to('/admin/prodi');
    }
    // public function delete($kode_prodi)
    // {
    //     $this->db->table('prodi')
    //         ->delete([
    //             'kode_prodi'    => $kode_prodi
    //         ]);
    //     session()->setFlashdata('pesan', 'Data berhasil dihapus');
    //     return redirect()->to('/admin/prodi');
    // }

    public function delete($id)
    {
        $this->db->table('prodi')->delete(array('kode_prodi' => $id));
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin/prodi');
    }
}
