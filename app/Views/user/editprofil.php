<?= $this->extend('templates/template'); ?>
<?= $this->section('content'); ?>
<?php
$db = \Config\Database::connect();
$userid = session()->get('email');

$queryUser = $db->query("SELECT * FROM users WHERE email= '$userid'");
$user = $queryUser->getRowArray();
$id_pendaftar = $user['id'];

// $queryDiri = $db->query("SELECT * FROM pendaftar WHERE id='$id_pendaftar'");
// $data = $queryDiri->getRowArray();
// $diri = $data['status_datadiri'];
// $ortu = $data['status_dataortu'];

?>
<style type="text/css">
    .foto-thumbnail {
        padding: .07rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        width: 3.3rem;
        height: auto;
    }

    .foto-preview {
        padding: .25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        width: 10rem;
        height: 14rem;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <p class="h6 mb-4 text-gray-700 text-left" style="font-size: 12px;">
        <i class="fas fa-home"></i>
        <?php foreach ($pengaturan as $k) : ?>
            <?= $k['nama_aplikasi']; ?> / <a href="/user/dasboard" class="text-gray-700">User</a> / <a href="/" class="text-gray-700"> Edit Profil</a> </p>
<?php endforeach; ?>
<!-- <hr> -->

<div class="row">
    <div class="col-md-12">

    </div>
</div>

<!-- Content Row -->
<div class="col-md-12">
    <div class="row">
        <!-- Data Nilai -->
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" style="font-size: 12px;">EDIT PROFIL</h6>
                </div>


                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        <p><strong>Perhatian</strong><br> Wajib Mengupload <strong>Pas Photo FORMAL</strong> ukuran 3x4 hitam putih/warna!</p>
                    </div>
                    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>">
                    </div>
                    <?php if (session()->getFlashdata('pesan')) : ?>

                    <?php endif; ?>
                    <form action="/user/edit_profil/<?= $user['email']; ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_user" value="<?= $user['id']; ?>">
                        <input type="hidden" name="profil" value="<?= $user['image']; ?>">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= $user['nama']; ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama'); ?>

                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">Photo</div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src=" <?= base_url('/admin/assets/img/profil') . '/' . $user['image']; ?>"" class=" img-thumbnail img-preview">
                                    </div>
                                    <div class="col-sm-9">

                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>" id="image" name="image" onchange="previewProfil()">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('image'); ?>

                                            </div>
                                            <label class="custom-file-label" style="font-size: 14px;"><?= $user['image']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <a href="" class="btn btn-sm btn-danger"> <i class="fas fa-arrow-left"></i>
                                    Kembali</a></button>
                                <button type="submit" name="btn_simpan" value="simpan_data" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i>
                                    Edit Profil </button>
                            </div>
                        </div>

                    </form>



                </div>


            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>