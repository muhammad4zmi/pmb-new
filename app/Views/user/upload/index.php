<?= $this->extend('templates/template'); ?>
<?= $this->section('content'); ?>
<?php
$db = \Config\Database::connect();
$userid = session()->get('email');

$queryUser = $db->query("SELECT users.id, users.image, pendaftar.id, pendaftar.nama, pendaftar.created_at, pendaftar.no_pendaftaran
                                    FROM users 
                                    JOIN pendaftar ON users.id=pendaftar.users_id 
                                WHERE users.email= '$userid'");
$user = $queryUser->getRowArray();
$id_pendaftar = $user['id'];
$no_daftar = $user['no_pendaftaran'];

$queryDiri = $db->query("SELECT * FROM pendaftar WHERE id='$id_pendaftar'");
$data = $queryDiri->getRowArray();
$diri = $data['status_datadiri'];
$ortu = $data['status_dataortu'];

//query ambil status

$queryStatus = $db->query("SELECT * FROM berkas WHERE no_pendaftaran=$no_daftar");
$status = $queryStatus->getRowArray();
// dd($status);
// die;

?>

<style>
    .zoomeffect {
        width: 20%;
        height: 20%;
        text-align: center;
        overflow: hidden;
        position: relative;
        cursor: default;
    }

    .zoomeffect img {
        display: block;
        position: relative;
        cursor: pointer;
        -webkit-transition: all .4s linear;
        transition: all .4s linear;
        width: 100%;
    }

    .zoomeffect:hover img {
        -ms-transform: scale(1.2);
        -webkit-transform: scale(1.2);
        transform: scale(1.2);
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <p class="h6 mb-4 text-gray-700 text-left" style="font-size: 12px;">
        <i class="fas fa-home"></i>
        <?php foreach ($pengaturan as $k) : ?>
            <?= $k['nama_aplikasi']; ?> / <a href="/camaba" class="text-gray-700">User</a> / <a href="dasboard" class="text-gray-700"> Upload Berkas </a> </p>
<?php endforeach; ?>
<!-- <hr> -->

<div class="row">
    <div class="col-md-12">

    </div>
</div>
<?php if (($diri & $ortu) == 0) : ?>
    <div class="alert alert-danger" role="alert">
        <h4><i class="fas fa-exclamation-triangle"></i>
            Perhatian :</h4><br>
        <p style="font-size: 14px;">Anda Belum melengkapi Data Diri dan Data Orang Tua Anda!, Silahkan lengkapi terlebih dahulu sebelum melakukan Upload Berkas!</p>
        <div class="text-left">
            <a href="/user/identitas" class="btn btn-sm btn-success m-1">
                <i class="fas fa-user"></i>
                Isi Data Diri
            </a>
            <a href="/user/identitas/ortu" class="btn btn-sm btn-warning m-1">
                <i class="fas fa-user-friends"></i>
                Isi Data Orang Tua
            </a>
        </div>
    </div>
<?php else : ?>
    <!-- Content Row -->
    <div class="row">



        <!-- Kolom Dua -->
        <div class="col-md-12">

            <div class="card border-left-success mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success" style="font-size: 14px;">Upload Berkas Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <?php if ($status['status'] == 1) : ?>
                        <div class="alert alert-primary" role="alert">
                            Status Pembayaran Anda <strong>Sudah Lunas!</strong>
                        </div>
                        <?php if (session()->getFlashdata('pesan')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashdata('pesan'); ?>

                            </div>

                        <?php endif; ?>
                        <form action="/identitas/uploadbukti" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="asal" style="font-size: 12px;">No Pendaftaran
                                    *</label>
                                <input type="text" name="no_pendaftaran" id="asal" class="form-control <?= ($validation->hasError('no_pendaftaran')) ? 'is-invalid' : ''; ?>" style="font-size: 14px;" value="<?= $user['no_pendaftaran']; ?>" readonly>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('no_pendaftaran'); ?>

                                </div>

                            </div>



                            <div class="zoomeffect">
                                <a data-fancybox="gallery" rel=" ligthbox" href="<?= base_url('/img') . '/' . $status['scan']; ?>">
                                    <img src="<?= base_url('/img') . '/' . $status['scan']; ?>" class="img-thumbnail" alt="Preview Gambar" width: 100%;>
                                </a>
                            </div>




                            <br><br><br>

                            <div class="text-right">
                                <a href="/user/dasboard" class="btn btn-sm btn-danger" name="kembali">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali</a>
                                <button type="submit" name="btn_simpan" value="simpan_data" class="btn btn-sm btn-success" disabled>
                                    <i class="fas fa-upload"></i>
                                    Upload Bukti </button>

                            </div>

                        </form>

                    <?php else : ?>
                        <p>
                            <font color="red">*Scan Bukti Pembayaran dalam Format Gambar (.JPG/JPEG, PNG) ukuran maksimal 1 MB.</font>
                        </p>
                        <?php if (session()->getFlashdata('pesan')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashdata('pesan'); ?>

                            </div>

                        <?php endif; ?>
                        <form action="/identitas/uploadbukti" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="asal" style="font-size: 12px;">No Pendaftaran
                                    *</label>
                                <input type="text" name="no_pendaftaran" id="asal" class="form-control <?= ($validation->hasError('no_pendaftaran')) ? 'is-invalid' : ''; ?>" style="font-size: 14px;" value="<?= $user['no_pendaftaran']; ?>" readonly>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('no_pendaftaran'); ?>

                                </div>

                            </div>




                            <div class="custom-file">
                                <input type="file" class="custom-file-input <?= ($validation->hasError('bukti')) ? 'is-invalid' : ''; ?>" id="bukti" name="bukti" onchange="previewImg()">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('bukti'); ?>

                                </div>
                                <label class="custom-file-label" style="font-size: 14px;">Upload Scan Bukti Transfer Uang Pendaftaran</label>
                            </div>




                            <br><br><br>

                            <div class="text-right">
                                <a href="/user/dasboard" class="btn btn-sm btn-danger" name="kembali">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali</a>
                                <button type="submit" name="btn_simpan" value="simpan_data" class="btn btn-sm btn-success">
                                    <i class="fas fa-upload"></i>
                                    Upload Bukti </button>

                            </div>

                        </form>
                    <?php endif; ?>






                </div>
            </div>

        </div>


    </div>
<?php endif; ?>

<?= $this->endSection(); ?>