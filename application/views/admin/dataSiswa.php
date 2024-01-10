<main id="main" class="main">

    <div class="pagetitle">
        <h1><?= $title; ?></h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-11">
                <a href="<?= base_url('admin/tambahSiswa'); ?>" class="btn btn-primary fw-bold text-light mb-2"><i class="bi bi-plus-circle me-1"></i>Tambah</a>
                <?= $this->session->flashdata('pesan'); ?>
                <div class="row">
                    <!-- data siswa -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Siswa</h5>
                                <div class="row">
                                    <div class="col d-flex flex-row gap-2 mb-2">
                                        <a href="<?= base_url('admin/print_data_siswa'); ?>" target="_blank" type="button" class="btn btn-sm btn-outline-primary"><i class="fs-5 bi bi-printer"></i> PRINT</a>
                                        <a href="<?= base_url('admin/pdf_data_siswa'); ?>" target="_blank" type="button" class="btn btn-sm btn-outline-danger"><i class="fs-5 bi bi-file-earmark-pdf"></i> PDF</a>
                                        <a href="<?= base_url('admin/excel_data_siswa'); ?>" target="_blink" type="button" class="btn btn-sm btn-outline-success"><i class="fs-5 bi bi-file-earmark-excel"></i> EXCEL</a>
                                    </div>

                                </div>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">NIS</th>
                                            <th scope="col" class="text-center">Nama</th>
                                            <th scope="col" class="text-center">Kelas</th>
                                            <th scope="col" class="text-center">Jenis Kelamin</th>
                                            <th scope="col" class="text-center">No Telepon</th>
                                            <th scope="col" class="text-center">Tahun Masuk</th>
                                            <!-- <th scope="col" class="text-center">Aksi</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($siswa as $s) : ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $i++; ?></a></th>
                                                <td class="text-center"><?= $s['nis']; ?></td>
                                                <td class="text-center"><?= $s['nama']; ?></td>
                                                <td class="text-center"><?= $s['kelas']; ?></td>
                                                <td class="text-center"><?= $s['jenis_kelamin']; ?></td>
                                                <td class="text-center"><?= $s['no_telepon']; ?></td>
                                                <td class="text-center"><?= $s['tahun_masuk']; ?></td>
                                                <!-- <td class="text-center">
                                                    <button class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                                </td> -->
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End User -->
                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>

</main><!-- End #main -->