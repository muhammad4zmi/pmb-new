<?= $this->extend('templates/template'); ?>

<?= $this->section('content'); ?>
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
    width: 12rem;
    height: 16rem;
  }
</style>
<div class="container-fluid">
  <!-- Page Heading -->
  <p class="h6 mb-4 text-gray-700 text-left" style="font-size: 12px;">
    <i class="fas fa-home"></i>
    <?php foreach ($pengaturan as $k) : ?>
      <?= $k['nama_aplikasi']; ?> / <a href="/admin/dasboard" class="text-gray-700">Admin</a> / <a href="dasboard" class="text-gray-700"><?= $title; ?> </a> </p>
<?php endforeach; ?>
<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase" style="font-size: 14px;">Data Calon Mahasiswa</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <div class="col-md-12 mb-3" align="right">
            
              <button class="btn btn-sm btn-success export"><i class="far fa-file-excel"></i> Export File Excel</button>
          </div>

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr align="center" style="font-size: 14px;">
                <!-- <th width="1%"><input type="checkbox" id="pilih_semua"></th> -->
                <th width="1%">No</th>
                <th width="2%">Photo</th>
                <th width="10%">No Pendaftaran</th>
                <th width="15%">Nama</th>
                <!-- <th width="10%">Email</th> -->
                <th width="10%">Prodi Pilihan 1</th>
                <th width="10%">Penerima KIP/PKH/KKS</th>
                <th width="5%">Tanggal Daftar</th>
                <th width="10%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($pendaftar as $k) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td class="center"><img class="foto-thumbnail" src="<?= base_url('/admin/assets/img/profil') . '/' . $k['image']; ?>" alt="Foto Siswa"></td>
                  <td><?= $k['no_pendaftaran']; ?></td>
                  <td><?= $k['nama']; ?></td>
                  <!-- <td><?= $k['email']; ?></td> -->
                  <td><?= $k['prodi']; ?></td>
                  <td><?php if($k['kip'] == 'Ya') : ?>
                  <span class="badge badge-primary">Status : <?= $k['kip']; ?> |  Nomor : <?= $k['kode_kip']; ?></span>
                  <?php else : ?>
                  <span class="badge badge-danger">Bukan Penerima KIP/PKH/KKS</span>
                  <?php endif; ?>
                  </td>
                  <td><?= $k['tgl']; ?></td>
                  <td align="center">
                    <a href="/admin/pendaftar/detail/<?= $k['id_pendaftar']; ?>" class="btn btn-primary m-1 btn-sm btn-circle data-placement=" top" title="" data-toggle="tooltip" data-original-title="Data Detail <?= $k['nama']; ?>"">
                      <i class=" fas fa-eye"></i></a>
                    <a href="/admin/pendaftar/cetakformulir/<?= $k['id_pendaftar']; ?>" class="btn btn-warning btn-sm m-1 btn-circle data-placement=" top" title="" data-toggle="tooltip" data-original-title="Download Formulir <?= $k['nama']; ?>"" target=" _blank">
                      <i class=" fas fa-print"></i></a>
                    <a href="#" class="btn btn-danger btn-sm m-1 btn-circle" data-placement="top" title="" data-toggle="tooltip" data-original-title="Hapus Data <?= $k['nama']; ?>">
                      <i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection(); ?>