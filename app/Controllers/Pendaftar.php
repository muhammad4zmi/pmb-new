<?php

namespace App\Controllers;

use App\Models\PendaftarModel;
use App\Models\PengaturanModel;
use App\Models\BerkasModel;
use chillerlan\QRCode\QRCode;
use PhpOffice;
use PHPExcel;
use PHPExcel_IOFactory;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Pendaftar extends BaseController
{
    protected $pendaftarModel;
    public function __construct()
    {
        $this->pendaftarModel = new PendaftarModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->berkasModel = new BerkasModel();
        $this->db = \Config\Database::connect();
        
        helper('pmb');
        is_logged_in();
    }
    public function index()
    {
        //$komik = $this->komikModel->findAll();
        $data = [
            'title' => 'Data Pendaftar',
            'pendaftar' => $this->pendaftarModel->getPendaftar(),
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray()
        ];
        return view('admin/pendaftar/index', $data);
    }
    public function detail($id_pendaftar)
    {
        $data = [
            'title' => 'Detail Data Pendaftar',
            'pendaftar' => $this->pendaftarModel->getDetail($id_pendaftar),
            'detail_ortu' => $this->pendaftarModel->getDetailortu($id_pendaftar),
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'user' => $this->db->table('users')->getWhere(['email' => session('email')])->getRowArray()
        ];
        return view('admin/pendaftar/detail', $data);
    }

    //cetak formulir
    public function cetakformulir($id_pendaftar)
    {
        $data = [
            'title' => 'SiPMB | Formulir Pendaftaran',
            'pengaturan' => $this->pengaturanModel->getPengaturan(),
            'prodi' => $this->db->table('prodi')->get()->getResultArray(),
            'pekerjaan' => $this->db->table('pekerjaan')->get()->getResultArray(),
            'validation' => \Config\Services::validation(),
            'pendaftar' => $this->pendaftarModel->getDetail($id_pendaftar),
            'detail_ortu' => $this->pendaftarModel->getDetailortu($id_pendaftar),
            'berkas' => $this->berkasModel->getBerkas()
            // 'pendaftar' = $this->db->table('pendaftar')->getWhere('')
        ];

        return view('admin/pendaftar/cetakformulir', $data);
    }
    //export excel
    public function export()
    {

       

        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);        
        $kolom= ['No Pendaftaran','Nama','Tempat Lahir','Tanggal Lahir','Jenis Kelamin','No Hp','Alamat','Prodi Pilihan','Sekolah Asal','Penerima KIP/PKH/KKS','Kode KIP/PKH/KKS','Tanggal Daftar'];     
        $column = 0;
        foreach($kolom as $field)
        {           
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        // $db = \Config\Database::connect();
        // $builder = $db->table('pegawai'); 
        //$query = $builder->get();  
         $dataPendaftar = $this->pendaftarModel->getPendaftarExport();
        $excel_row = 2;
        foreach ($dataPendaftar as $row){
            $hasil = array_values($row);
            $kolom = sizeof($row);
            for($i=0;$i<$kolom;$i++){               
                $object->getActiveSheet()->setCellValueByColumnAndRow($i, $excel_row, $hasil[$i]);  
            }   
            $excel_row++;           
        }
                     
        $writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=Data-Calon-Mahasiswa.xls');
    header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
