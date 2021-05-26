<?= $this->extend('templates/template'); ?>
<?= $this->section('content'); ?>
<?php
$db = \Config\Database::connect();
$userid = session()->get('email');

$queryUser = $db->query("SELECT users.id, users.image, pendaftar.id, pendaftar.nama, 
                                pendaftar.created_at, pendaftar.no_pendaftaran,pendaftar.email,date_format(pendaftar.created_at, '%d %b %Y') as tgl, time(created_at) as jam
                                    FROM users 
                                    JOIN pendaftar ON users.id=pendaftar.users_id 
                                WHERE users.email= '$userid'");
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
            <?= $k['nama_aplikasi']; ?> / <a href="/user/dasboard" class="text-gray-700">User</a> / <a href="/" class="text-gray-700"> Change Password</a> </p>
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
                    <h6 class="m-0 font-weight-bold text-primary" style="font-size: 12px;">CHANGE PASSWORD</h6>
                </div>


                <div class="card-body">

                    <?php if (session()->getFlashdata('pesan')) : ?>

                        <?= session()->getFlashdata('pesan'); ?>



                    <?php endif; ?>
                    <form action="/user/changePassword" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Current Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control <?= ($validation->hasError('current_password')) ? 'is-invalid' : ''; ?>"" id=" email" name="current_password" placeholder="Masukkan Password lama">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('current_password'); ?>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control <?= ($validation->hasError('new_password1')) ? 'is-invalid' : ''; ?>" id="nama" name="new_password1" placeholder="Masukkan Password Baru">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('new_password1'); ?>

                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Repeat Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control <?= ($validation->hasError('new_password2')) ? 'is-invalid' : ''; ?>" id="nama" name="new_password2" placeholder="Ulangi Password Baru">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('new_password2'); ?>

                                </div>
                            </div>

                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="col-sm-10">
                                <a href="/user/dasboard" class="btn btn-sm btn-danger"> <i class="fas fa-arrow-left"></i>
                                    Kembali</a></button>
                                <button type="submit" name="btn_simpan" value="simpan_data" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i>
                                    Change Passsword </button>
                            </div>
                        </div>

                    </form>



                </div>


            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>