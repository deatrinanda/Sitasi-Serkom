<main id="main" class="main">

    <div class="pagetitle">
        <h1><?= $title; ?></h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Saldo Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Saldo Anda</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $tabungan['saldo']; ?></h6>
                                        <span class="text-primary small pt-1 fw-bold">Rupiah</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Saldo Card -->
                    <!-- Saldo Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Transaksi</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bxs-hourglass-top"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $jml_ptransaksi; ?></h6>
                                        <span class="text-primary small pt-1 fw-bold">Sedang Diproses</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Saldo Card -->
                    <!-- User -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Transaksi Diproses</h5>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Jenis Transaksi</th>
                                            <th scope="col">Metode Pembayaran</th>
                                            <th scope="col">Nominal</th>
                                            <th scope="col">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($transaksi as $t) : ?>
                                            <tr>
                                                <th scope="row"><?= $i++; ?></a></th>
                                                <td><?= $t['jenis_transaksi']; ?></td>
                                                <td><?= $t['metode_pembayaran']; ?></td>
                                                <td><?= $t['nominal']; ?></td>
                                                <td><?= date('d/m/Y - G:i', $t['tanggal']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End User -->
                </div>
            </div><!-- End Left side columns -->
            <div class="col-lg-4">
                <!-- Alur Setoran -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Alur Setoran</h5>

                        <div class="activity">

                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 1</div>
                                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                <div class="activity-content">
                                    Menuju <a href="<?= base_url('user/setoran/' . $sidebar['id']); ?>" class="fw-bold text-dark">Form Setoran</a> pada menu sidebar.
                                </div>
                            </div><!-- End langkah2 -->

                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 2</div>
                                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                <div class="activity-content">
                                    Mentransfer nominal setoran ke nomor akun Dana admin <span class="fw-bold text-secondary">ATAU</span> menemui admin langsung.
                                </div>
                            </div><!-- End langkah2 -->

                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 3</div>
                                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                <div class="activity-content">
                                    Mengisi form setoran sesuai yang anda lakukan. Kemudian upload bukti transfer.
                                </div>
                            </div><!-- End langkah2 -->

                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 4</div>
                                <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                <div class="activity-content">
                                    Klik submit. Kemudian menunggu dikonfirmasi oleh admin dan saldo akan bertambah. <a href="<?= base_url('user/riwayat/' . $sidebar['id']); ?>" class="fw-bold text-dark">Klik</a> untuk melihat transaksi anda.
                                </div>
                            </div><!-- End langkah2 -->
                        </div>
                    </div>
                </div><!-- End Alur Setoran -->
                <!-- Alur Penarikan -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Alur Penarikan</h5>

                        <div class="activity">

                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 1</div>
                                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                <div class="activity-content">
                                    Menuju <a href="<?= base_url('user/penarikan/' . $sidebar['id']); ?>" class="fw-bold text-dark">Form Penarikan</a> pada menu sidebar.
                                </div>
                            </div><!-- End langkah2 -->

                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 2</div>
                                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                <div class="activity-content">
                                    Mengisi nominal yang akan ditarik <span class="fw-bold text-secondary">DAN</span> metode pembayarannya.
                                </div>
                            </div><!-- End langkah2 -->

                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 3</div>
                                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                <div class="activity-content">
                                    Kemudian klik submit. Kemudian menunggu admin mengkonfirmasi.
                                </div>
                            </div><!-- End langkah2 -->

                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 4</div>
                                <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                <div class="activity-content">
                                    Admin akan mentransfer ke akun Dana anda <span class="fw-bold text-secondary">ATAU</span> anda bisa menemui admin. Lalu admin akan memberikan bukti transfernya ke anda.
                                </div>
                            </div><!-- End langkah2 -->
                            <div class="activity-item d-flex">
                                <div class="activite-label">langkah 5</div>
                                <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                                <div class="activity-content">
                                    Kemudian saldo akan berkurang. <a href="<?= base_url('user/riwayat/' . $sidebar['id']); ?>" class="fw-bold text-dark">Klik</a> untuk melihat transaksi anda.
                                </div>
                            </div><!-- End langkah2 -->
                        </div>
                    </div>
                </div><!-- End Alur Penarikan -->
            </div>

        </div>
    </section>

</main><!-- End #main -->