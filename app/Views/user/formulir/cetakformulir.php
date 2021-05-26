<?php

use chillerlan\QRCode\QRCode;

function DateToIndo($date)
{ // fungsi atau method untuk mengubah tanggal ke format indonesia
    // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
    $BulanIndo = array(
        "Januari", "Februari", "Maret",
        "April", "Mei", "Juni",
        "Juli", "Agustus", "September",
        "Oktober", "November", "Desember"
    );
    $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
    $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
    $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
    $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun;
    return ($result);
}
// $this->load->library('qrlib');
// include "../phpqrcode/qrlib.php";
// $lib = new \QRrs\Libraries\BlogLib();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0055)http://krs.amikom.ac.id/index.php/cetak/khs/1/2016/2017 -->
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <title>Formulir Pendaftaran </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="anonymous" />
    <!--style bootstrap-->
    <link rel="shortcut icon" href="../../style/ico/tutwuri.png">

    <!-- <script type="text/javascript" src="../admin/js/sweetalert/sweet-alert.min.js"></script> -->
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .krs_box {
            border: 1px solid #000;
        }

        .krs_box * {
            text-align: center;
            padding: 0 1px;
        }

        .krs_box td,
        .krs_box th {
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .krs_box th {
            font-size: 12px;
        }

        .tl {
            text-align: left;
            padding-left: 10px
        }

        .tc {
            text-align: center;
        }

        .tr {
            text-align: right;
        }

        .tj {
            text-align: justify;
        }

        .fb {
            font-weight: bold;
        }

        .line {
            border-bottom: 1px dashed #000;
            clear: both;
        }
    </style>
</head>

<body cz-shortcut-listen="true">
    <div style="margin:0 auto;width:800px;">
        <br><br>
        <table align="center" width="800" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td><img src="<?= base_url(); ?>/admin/assets/img/logo.png" width="100"></td>
                    <td width="800" style="font-weight:bold;text-align:center;">
                        <!--<div style="font-size:11px;">SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER</div>-->
                        <div style="font-size:16px;font-family:Times New Roman,Times,serif">SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER</div>
    </div>
    <div style="font-size:25px;font-family:Times New Roman,Times,serif">( STMIK ) SYAIKH ZAINUDDIN NW</div>
    <div style="font-size:16px;font-family:Times New Roman,Times,serif">ANJANI LOMBOK TIMUR - NTB</div>
    <!-- <div style="font-size:12px;font-family:Times New Roman,Times,serif">SK. Menteri Pendidikan Nasional RI Nomor : 80/D/O/2006</div> -->
    <p>
        <div>Jln Raya Mataram- Lb. Lombok KM 49 Desa Anjani, Kec. Suralaga, Kab. Lombok Timur-NTB
        </div>
    </p>
    </td>

    </tr>
    </tbody>
    </table>
    <hr>


    </div>
    </div>

    <u>
        <p style="font-size: 15px; font-weight: bolder; text-align: center">FORMULIR PENDAFTARAN MAHASISWA BARU<br /></p>
    </u>
    <?php foreach ($pendaftar as $k) : ?>
        <table width="800" align="center" border="0" cellpadding="0" cellspacing="0" class="krs_box">
            <tbody>
                <th colspan="2" class="tl">DATA PRIBADI</th>
                <tr>

                    <th width="30%" class="tl">NOMOR PENDAFTARAN</th>

                    <th width="80%" class="tl">
                        <p style="font-size: 15px; font-weight: bolder; text-align: left"><strong><?= $k['no_pendaftaran']; ?></strong></p>
                    </th>

                    <th width="10" rowspan="11">
                        <br>
                        <img align="center" src="<?= base_url('/admin/assets/img/profil') . '/' . $k['image']; ?>" alt="Foto Siswa" style="width: 110px; height: 150px;">
                        <?php echo '<img src= "' . (new QRCode())->render($k['no_pendaftaran']) . '" alt="QR Code">' ?>



                    </th>
                </tr>
                <tr>
                    <td class="tl" tyle="font-size: 12px; font-weight: bolder; text-align: left">NIK<br><em></em></td>

                    <td class="tl">
                        <?= $k['nik']; ?></td>
                </tr>
                <tr>

                    <td class="tl">NAMA LENGKAP<br><em></em></td>

                    <td class="tl"><?= $k['nama']; ?></td>
                </tr>
                <tr>

                    <td class="tl">TEMPAT/TANGGAL LAHIR<br><em> </em></td>

                    <td class="tl"><?= $k['tmpt_lahir'] ?>, <?= (DateToIndo("$k[tgl_lahir]")); ?></td>
                </tr>
                <tr>

                    <td class="tl">ALAMAT<br><em> </em></td>

                    <td class="tl"><?= $k['alamat']; ?></td>
                </tr>
                <tr>

                    <td class="tl">JENIS KELAMIN<br><em> </em></td>

                    <td class="tl"><?= $k['jenis_kelamin']; ?></td>
                </tr>
                <tr>

                    <td class="tl">ASAL SEKOLAH<br><em> </em></td>

                    <td class="tl"><?= $k['asal_madrasah']; ?></td>
                </tr>
                <tr>

                    <td class="tl">No HP<br><em> </em></td>

                    <td class="tl"><?= $k['no_hp']; ?></td>
                </tr>
                <tr>

                    <td class="tl">PROGRAM STUDI PILIHAN<br><em> </em></td>

                    <td class="tl"><?= $k['prodi']; ?></td>
                </tr>
                <tr>

                    <td class="tl">TANGGAL DAFTAR<br><em> </em></td>

                    <td class="tl"><?= (DateToIndo("$k[created_at]")); ?></td>
                </tr>
                <tr>

                    <td class="tl">TNGGAL & JAM UJIAN<br><em> </em></td>

                    <td class="tl">3 September 2020</td>
                </tr>
                <?php foreach ($detail_ortu as $j) : ?>
                    <th colspan="2" class="tl">DATA ORANG TUA<em> </em></th>
                    <tr>
                        <td class="tl">NAMA AYAH<br>
                            <em> </em>
                        </td>
                        <td class="tl"><?= $j['nama_ayah']; ?></td>

                    </tr>
                    <tr>
                        <td class="tl">NAMA IBU</td>
                        <td class="tl"><?= $j['nama_ibu']; ?><br><em> </em></td>

                    </tr>
                <?php endforeach; ?>




            </tbody>
        </table>
        <div>
            <br />

            <?php
            $db = \Config\Database::connect();
            $userid = session()->get('email');
            $queryUser = $db->query("SELECT users.id, users.image, pendaftar.id, pendaftar.nama, 
            date_format(pendaftar.created_at, '%d %b %Y') as tgl, time(pendaftar.created_at) as jam, pendaftar.no_pendaftaran, berkas.nama_berkas,berkas.no_pendaftaran,berkas.status, date_format(berkas.updated_at, '%d %b %Y') as tgl_bayar, time(berkas.updated_at) as jam_bayar
    FROM users,pendaftar, berkas 
            WHERE users.id=pendaftar.users_id 
    AND pendaftar.no_pendaftaran=berkas.no_pendaftaran AND users.email='$userid'");
            $user = $queryUser->getRowArray();

            ?>


            <table width="800" align="center" border="0" cellpadding="0" cellspacing="0" class="krs_box">
                <tbody>


                    <tr>
                        <th class="tl"></th>
                        <th width="80%"></th>
                        <th width="20%"></th>

                    </tr>
                    <tr>
                        <th class="tr" colspan="2">
                            <p style="font-size: 15px; font-weight: bolder; text-align: left">Persyaratan Pendaftaran</p>
                        </th>

                        <td>(Halaman diisi oleh Petugas Verifikasi Berkas)<br><em> </em></td>

                    </tr>
                    <tr>
                        <td>1</td>
                        <td class="tl">Potocopy Ijazah terakhir yang dilegalisir sebanayak 5 lembar</td>
                        <td>[ &nbsp&nbsp&nbsp ]<br><em> </em></td>

                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="tl">Paspoto hitam putih ukuran 2x3, 3x4, 4x6 masing- masing 5 lembar</td>
                        <td>[ &nbsp&nbsp&nbsp ]<br><em> </em></td>

                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="tl">Potocopy KTP 5 lembar</td>
                        <td>[ &nbsp&nbsp&nbsp ]<br><em> </em></td>

                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="tl">Potocopy Kartu Keluarga 5 Lembar</td>
                        <td>[ &nbsp&nbsp&nbsp ]<br><em> </em></td>

                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="tl">Administrasi pendaftaran sebesar Rp. 200.000,-</td>
                        <td>
                            <?php if ($user['status'] == 0) : ?>
                                [ &nbsp&nbsp&nbsp ]<br><em> </em></td>
                    <?php else : ?>
                        [ &#10004; ]<br><em> </em></td>
                    <?php endif; ?>


                    </tr>
                    <th colspan="3" class="tl">Keterangan</th>

                    <tr align="left">

                        <td colspan="3" class="tl">
                            <p style="font-weight:normal;text-align:left;">
                                1. Calon Mahasiswa wajib menyerahkan semua persyaratan dalam checklist untuk di verifikasi oleh panitia<br>
                                2. Calon Mahasiswa baru wajib mengikuti ujian seleksi masuk perguruan tinggi sesuai dengan waktu yang telah ditentukan.
                        </td>
                        </em></td>

                    </tr>



                </tbody>
            </table>

            <br><br>
            <table border="0" width="800" cellspacing="0" cellpadding="0" align="center">


                <tr>

                    <td align="right">Anjani, <?php echo (DateToIndo(date('Y m d'))); ?></td>

                </tr>

            </table>
            <table width="100%" border="0">
                <tbody>
                    <tr>
                        <td>
                            <div align="center">
                                Calon Mahasiswa Baru,<br>
                                <br><br><br><br><br>
                                <br> <u><strong>( <?= $k['nama']; ?> )</strong></u>
                            </div>
                        </td>
                        <td align="center">
                        </td>
                        <td align="right">

                            <br><br>
                            <div align="center">
                                Petugas Pendaftaran,<br>
                                <br><br><br><br><br>
                                <br> (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                                <br><br>
                        </td>
                    </tr>
                </tbody>
            </table>





            <div style="text-align:center;" class="tc">[<a href="javascript:void()" onclick="print()">CETAK</a>]</div>


        </div>
        </div>
        </div>

        </div>
        </section>
        </aside>
    <?php endforeach; ?>