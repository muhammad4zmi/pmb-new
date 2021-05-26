<?php

namespace App\Controllers;

use App\Models\PendaftarModel;
use App\Models\PengaturanModel;
use App\Models\BerkasModel;

class Berkas extends BaseController
{
    protected $berkasModel;
    public function __construct()
    {
        $this->berkasModel = new BerkasModel();
        $this->pendaftarModel = new PendaftarModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->db = \Config\Database::connect();
        $this->email = \Config\Services::email();
        helper('pmb');
        is_logged_in();
    }
    public function index()
    {
        //$komik = $this->komikModel->findAll();
        $data = [
            'title' => 'Berkas Pendaftaran',
            'berkas' => $this->berkasModel->getBerkas(),
            'pendaftar' => $this->pendaftarModel->getPendaftar(),
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray()
        ];
        return view('admin/berkas/index', $data);
    }
    public function reject($id)
    {
        $berkas = $this->berkasModel->getEmail($id);
        // dd($berkas);
        // die;
        $email = $berkas['email'];
        // dd($email);
        // die;
        $user = $berkas['nama'];
        $now = date("Y-m-d H:i:s");
       
        $berkas1 = $this->db->query("SELECT * FROM berkas  WHERE no_pendaftaran= $id")->getRowArray();
        $scan = $berkas1['scan'];
        if($berkas1){
            unlink('img/'.$scan);
            $this->db->query("UPDATE berkas set scan='' WHERE no_pendaftaran=$id");
            $message = "<h3>Verifikasi Pembayaran</h3><p>Kepada Yth. Calon Mahasiswa Baru <b>" . $user . "</b>
            Berkas Bukti Pembayaran anda gagal diverifikasi! Silahkan <strong><a href='https://pmb.stmiksznw.ac.id/auth' target='_blank' rel='noopener'>Login</a></strong> SiPMB STMIK Syaikh Zainuddin NW Anjani dan lakukan <b>Upload Ulang Bukti Pembayaran</b> anda pada Dasboard akun anda! . Terima Kasih</p>";
        $this->sendEmail($email, 'Verifikasi pembayaran', $message);
            
        }
        


        session()->setFlashdata('pesan', 'Successfully rejected!');
        return redirect()->to('/admin/berkas');
    }
    
     public function verifikasi($id)
    {
        $berkas = $this->berkasModel->getEmail($id);
        // dd($berkas);
        // die;
        $email = $berkas['email'];
        // dd($email);
        // die;
        $user = $berkas['nama'];
        $now = date("Y-m-d H:i:s");
        $this->db->query("UPDATE berkas set status  = 1  WHERE no_pendaftaran= $id");
        $message = "<h3>Verifikasi Pembayaran</h3><p>Kepada Yth. Calon Mahasiswa Baru <b>" . $user . "</b>
            Berkas Bukti Pembayaran anda telah diverifikasi! Silahkan <strong><a href='https://pmb.stmiksznw.ac.id/auth' target='_blank' rel='noopener'>Login</a></strong> SiPMB STMIK Syaikh Zainuddin NW Anjani dan <b>Mencetak Formulir Pendaftaran</b> pada Dasboard akun anda! . Terima Kasih</p>";
        $this->sendEmail($email, 'Verifikasi pembayaran', $message);


        session()->setFlashdata('pesan', 'Successfully verified');
        return redirect()->to('/admin/berkas');
    }

    private function sendEmail($to, $title, $message)
    {

        $this->email->setFrom('pmb@stmiksznw.ac.id', 'PMB STMIK Syaikh Zainuddin NW');
        $this->email->setTo($to);

        //$this->email->attach($attachment);

        $this->email->setSubject($title);
        $this->email->setMessage($message);

        if (!$this->email->send()) {
            return false;
        } else {
            return true;
        }
    }
}
