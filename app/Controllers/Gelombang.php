<?php

namespace App\Controllers;

use App\Models\InformasiModel;
use App\Models\PengaturanModel;
use App\Models\GelModel;

class Gelombang extends BaseController
{
    protected $pengaturanModel;
    protected $informasiModel;
    protected $gelModel;
    // protected $table = 'users';
    public function __construct()
    {
        $this->informasiModel = new InformasiModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->gelModel = new GelModel();
        $this->db = \Config\Database::connect();
        helper('pmb');
        is_logged_in();
    }


    public function index()
    {

        //$query = $db->table('users');
        $data = [
            'title' => 'Gelombang Pendaftaran',
            'informasi' => $this->informasiModel->getInformasi(),
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'gelombang' => $this->gelModel->getGelombang(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/gelombang/index', $data);
    }

    public function gelombang()
    {

        //$query = $db->table('users');
        $data = [

            'gelombang' => $this->gelModel->getGelombang()
        ];

        return view(base_url('front/index'), $data);
    }

    public function create()
    {
        $data = [
            'title' => 'SiPMB | Form Tambah Data',
            'validation' => \Config\Services::validation(),
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray()
        ];

        return view('admin/gelombang/create', $data);
    }

    public function save()
    {
        //validasi
        if (!$this->validate([
            'tgl_buka' => [
                'rules' => 'required|trim|is_unique[gelombang.tgl_buka]',
                'errors' => [
                    'required' => 'Tanggal Buka harus diisi!.',
                    'is_unique' => 'Tanggal periode yang anda pilih sudah ada!'
                ]
            ],
            'tgl_tutup' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal Tutup harus diisi!'
                ]
            ],
            'keterangan' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Keterangan harus diisi!'
                ]
            ],
            'status' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Pilih Status!'
                ]
            ]
        ])) {

            return redirect()->to('/admin/gelombang/create')->withInput();
        }


        $this->gelModel->save([
            'tgl_buka' => $this->request->getVar('tgl_buka'),
            'tgl_tutup' => $this->request->getVar('tgl_tutup'),
            'keterangan' => $this->request->getVar('keterangan'),
            'status' => $this->request->getVar('status')

        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambah');
        return redirect()->to('/admin/gelombang');
    }
    // public function detail($slug)
    // {
    //     $data = [
    //         'title' => 'Detail Informasi',
    //         'informasi' => $this->informasiModel->getInformasi($slug)
    //     ];
    //     // $komik = $this->komikModel->getKomik($slug);
    //     return view('informasi/detail', $data);
    // }

    public function delete($id)
    {
        $this->gelModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/admin/gelombang');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'SiPMB | Form Ubah Data',
            'validation' => \Config\Services::validation(),
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray(),
            'gelombang' => $this->gelModel->getGelombang($id)
        ];

        return view('admin/gelombang/edit', $data);
    }

    public function update($id)
    {
        //cek judul
        // $gelLama = $this->gelModel->getGelombang($this->request->getVar('id_gelombang'));

        // // dd($gelLama);
        // // die;
        // // $lama = $gelLama['id'];
        // // dd($lama);
        // if ($gelLama['tgl_buka'] == $this->request->getVar('tgl_buka')) {
        //     $rule_gel = 'required';
        // } else {
        //     $rule_gel = 'required|is_unique[gelombang.tgl_buka]';
        // }
        //validasi
        if (!$this->validate([
            'tgl_buka' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal Buka harus diisi!.',
                    'is_unique' => 'Tanggal tersebut sudah terdaftar!'
                ]
            ],
            'tgl_tutup' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Tanggal Tutup harus diisi!'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            return redirect()->to('/admin/gelombang/edit/' . $this->request->getVar('id_gelombang'))->withInput();
        }
        //$slug = url_title($this->request->getVar('judul'), '-', true);
        $this->gelModel->save([
            'id' => $id,
            'tgl_buka' => $this->request->getVar('tgl_buka'),
            'tgl_tutup' => $this->request->getVar('tgl_tutup'),
            'keterangan' => $this->request->getVar('keterangan'),
            'status' => $this->request->getVar('status')

        ]);

        session()->setFlashdata('pesan', 'Data berhasil diupdate');
        return redirect()->to('/admin/gelombang');
    }
}
