<?php

namespace App\Controllers;

use App\Models\PengaturanModel;
use App\Models\InformasiModel;
use App\Models\PendaftarModel;
use App\Models\AuthModel;
use App\Models\GelModel;



class User extends BaseController
{
    protected $pengaturanModel;
    protected $informasiModel;
    protected $pendaftarModel;
    protected $authModel;
    protected $gelModel;
    public function __construct()
    {
        helper('pmb');
        is_logged_in();
        $this->pengaturanModel = new PengaturanModel();
        $this->informasiModel = new InformasiModel();
        $this->pendaftarModel = new PendaftarModel();
        $this->gelModel = new GelModel();
        $this->authModel = new AuthModel();
        $this->db = \Config\Database::connect();
        $this->email = \Config\Services::email();
    }
    public function index()
    {


        $data = [
            'title' => 'SiPMB | Dasboard User',
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'informasi' => $this->informasiModel->getInformasi(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray(),
            'pendaftar' => $this->pendaftarModel->getPendaftar(),
            'gelombang1' => $this->gelModel->getGelombang()
        ];
        return view('user/dasboard/index', $data);
    }

    public function profil()
    {
        $data = [
            'title' => 'Profil',
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'informasi' => $this->informasiModel->getInformasi(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray(),
            'pendaftar' => $this->pendaftarModel->getPendaftar()
        ];
        return view('user/dasboard/profil', $data);
    }

    public function editprofil()
    {
        $data = [
            'title' => 'Edit Profil',
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'informasi' => $this->informasiModel->getInformasi(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray(),
            'pendaftar' => $this->pendaftarModel->getPendaftar(),
            'validation' => \Config\Services::validation()
        ];
        return view('user/editprofil', $data);
    }

    //edit profil
    public function edit_profil()
    {

        if (!$this->validate([
            'nama' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong!'
                ]

            ],
            'image' => [
                'rules' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih File terlebih dahulu!',
                    'max_size' => 'ukuran File terlalu besar!',
                    'is_image' => 'Yang anda pilih bukan gambar!',
                    'mime_in' => 'Yang anda pilih bukan gambar!'
                ]
            ]
        ])) {
            //$validation = \Config\Services::validation();
            return redirect()->to('/user/editprofil')->withInput();
        }
        $fileFoto = $this->request->getFile('image');

        //cek gambar
        if ($fileFoto->getError() == 4) {
            $namaImage = $this->request->getVar('profil');
        } else {
            //generate nama file random
            $namaImage = $fileFoto->getRandomName();
            //pindah gambar
            $fileFoto->move('admin/assets/img/profil', $namaImage);
            //hapus file lama
            //unlink('admin/assets/img/profil/' . $this->request->getVar('profil'));
        }
        // $this->authModel->save([
        //     'id'            => $id,
        //     'nama'     => $this->request->getVar('nama'),
        //     'image'  => $namaImage

        // ]);
        $email = $this->request->getVar('email');
        $nama = $this->request->getVar('nama');
        $this->db->query("UPDATE users set nama  = '$nama', image = '$namaImage' WHERE email= '$email'");
        $this->db->query("UPDATE pendaftar set nama ='$nama' WHERE email= '$email'");

        session()->setFlashdata('pesan', 'Profil berhasil di update!');
        return redirect()->to('/user/editprofil');
    }
    public function upload()
    {


        $data = [
            'title' => 'SiPMB | Upload Berkas',
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'informasi' => $this->informasiModel->getInformasi(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray(),
            'pendaftar' => $this->pendaftarModel->getPendaftar(),
            'validation' => \Config\Services::validation()

        ];
        return view('user/upload/index', $data);
    }

    public function changpassword()
    {
        $data = [
            'title' => 'SiPMB | Change Password',
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'informasi' => $this->informasiModel->getInformasi(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray(),
            'pendaftar' => $this->pendaftarModel->getPendaftar(),
            'validation' => \Config\Services::validation()
        ];


        return view('user/changpassword', $data);
    }
    public function changePassword()
    {
        $data = [

            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray()
        ];
        // dd($data);
        // die;
        if (!$this->validate([

            'current_password' => [
                'rules' => 'required|trim',
                'errors' => [
                    'required' => 'Current Password tidak boleh kosong!'

                ]
            ],
            'new_password1' => [
                'rules' => 'required|trim|min_length[5]|matches[new_password2]',
                'errors' => [
                    'required' => 'Tidak boleh kosong!',
                    'matches' => 'Password tidak sama!',
                    'min_length' => 'Password Minimal 5 karakter!'
                ]
            ],
            'new_password2' => [
                'rules' => 'required|trim|matches[new_password1]',
                'errors' => [
                    'required' => 'Tidak boleh kosong!',
                    'matches' => 'Password tidak sama!',
                ]
            ]
        ])) {
            return redirect()->to('/user/changpassword')->withInput();
        }
        $email = $data['user']['email'];
        $nama = $data['user']['nama'];
        $current_password = $this->request->getVar('current_password');
        $new_password = $this->request->getVar('new_password1');
        if (!password_verify($current_password, $data['user']['password'])) {
            session()->setFlashdata('pesan', '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script><script>Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Password lama yang anda masukkan salah!"
                })</script>');
            return redirect()->to('/user/changpassword');
        } else {
            if ($current_password == $new_password) {
                session()->setFlashdata('pesan', ' <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script><script>Swal.fire({
                      icon: "warning",
                      title: "Oops...",
                      text: "Password baru tidak boleh sama dengan password lama!"
                    })</script>');
                return redirect()->to('/user/changpassword');
            } else {
                //password oke
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $this->db->query("UPDATE users set password = '$password_hash' WHERE email= '$email'");
                // $this->db->set('password', $password_hash);
                // $this->db->WHERE('email', session()->userdata('email'));
                // $this->db->update('users');

                //konfirmasi ke email
                $message = "<h3>Account Information</h3><p>Dear user <b>" . $nama . "</b><br>
                Congratulations, your password has been successfully changed! : <br> username : " . $email . " <br>
                Password : " . $new_password . "<br>
                Please <strong><a href='https://pmb.stmiksznw.ac.id/auth'>Login</a></strong> . Please do not give this account to anyone! Thank you</p>";
                $this->sendEmail($email, 'Change Password', $message);

                session()->setFlashdata('pesan', ' <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script><script>Swal.fire({
                      icon: "success",
                      title: "Informasi.",
                      text: "Password anda berhasil diubah!, silahkan buka email anda untuk melihat informasi akun"
                    })</script>');
                return redirect()->to('/user/changpassword');
            }
        }
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
