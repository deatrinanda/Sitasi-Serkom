<style>
    img {
        width: max-content;
        height: auto;
    }
</style>
<main id="main" class="main">

    <div class="pagetitle">
        <h1><?= $title; ?></h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-10">
                <!-- Top Selling -->
                <div class="col-12">
                    <div class="card top-selling overflow-auto">
                        <div class="card-body pb-0">
                            <h5 class="card-title">Detail Penarikan</h5>
                            <?= $this->session->flashdata('pesan'); ?>
                            <!-- Floating Labels Form -->
                            <div class="row">
                                <div class="col-md-6 g-1">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="floatingName" placeholder="ID Transaksi" value="<?= $transaksi['id_transaksi']; ?>" disabled>
                                        <label for="floatingName">ID Transaksi</label>
                                    </div>
                                </div>
                                <div class="col-md-6 g-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName" placeholder="Nama" value="<?= $siswa['nama']; ?>" disabled>
                                        <label for="floatingName">Nama</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6 g-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName" placeholder="No Telepon" value="<?= $siswa['no_telepon']; ?>" disabled>
                                        <label for="floatingName">No Telepon</label>
                                    </div>
                                </div>
                                <div class="col-md-6 g-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName" placeholder="Jenis Transaksi" value="<?= $transaksi['jenis_transaksi']; ?>" disabled>
                                        <label for="floatingName">Jenis Transaksi</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6 g-1">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="floatingName" placeholder="Nominal" value="<?= $transaksi['nominal']; ?>" disabled>
                                        <label for="floatingName">Nominal</label>
                                    </div>
                                </div>
                                <div class="col-md-6 g-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName" placeholder="Catatan" value="<?= $transaksi['catatan']; ?>" disabled>
                                        <label for="floatingName">Catatan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6 g-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName" placeholder="Metode Pembayaran" value="<?= $transaksi['metode_pembayaran']; ?>" disabled>
                                        <label for="floatingName">Metode Pembayaran</label>
                                    </div>
                                </div>
                                <div class="col-md-6 g-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingName" placeholder="Tanggal" value="<?= date('d/F/Y - G:i:s', $transaksi['tanggal']); ?>" disabled>
                                        <label for="floatingName">Tanggal</label>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" enctype="multipart/form-data" action="<?= base_url('admin/terimaPenarikan/' . $transaksi['id_transaksi']); ?>">
                                <input type="hidden" name="id_transaksi" value="<?= $transaksi['id_transaksi']; ?>">
                                <input type="hidden" name="id_user" value="<?= $transaksi['id_user']; ?>">
                                <input type="hidden" name="jenis_transaksi" value="<?= $transaksi['jenis_transaksi']; ?>">
                                <input type="hidden" name="nominal" value="<?= $transaksi['nominal']; ?>">
                                <input type="hidden" name="catatan" value="<?= $transaksi['catatan']; ?>">
                                <input type="hidden" name="metode_pembayaran" value="<?= $transaksi['metode_pembayaran']; ?>">
                                <input type="hidden" name="id_tabungan" value="<?= $transaksi['id_tabungan']; ?>">
                                <div class="row mt-2">
                                    <p class="text-dark"><span class="text-danger">*</span>Masukan bukti transfer ke <span class="text-primary"><?= $siswa['nama']; ?></span></p>
                                    <label class="col-sm-4 col-form-label">Bukti Transfer</label>
                                    <input class="col" type="file" name="bukti">
                                </div>
                                <input type="hidden" name="tanggal" value="<?= $transaksi['tanggal']; ?>">
                                <input type="hidden" name="nis" value="<?= $tabungan['nis']; ?>">
                                <input type="hidden" name="saldo" value="<?= $tabungan['saldo']; ?>">
                                <div class="text-center mb-1 mt-3">
                                    <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Terima</button>
                                </div>
                            </form>
                            <form method="POST" enctype="multipart/form-data" action="<?= base_url('admin/tolakPenarikan/' . $transaksi['id_transaksi']); ?>">
                                <input type="hidden" name="id_transaksi" value="<?= $transaksi['id_transaksi']; ?>">
                                <input type="hidden" name="id_user" value="<?= $transaksi['id_user']; ?>">
                                <input type="hidden" name="jenis_transaksi" value="<?= $transaksi['jenis_transaksi']; ?>">
                                <input type="hidden" name="nominal" value="<?= $transaksi['nominal']; ?>">
                                <input type="hidden" name="catatan" value="<?= $transaksi['catatan']; ?>">
                                <input type="hidden" name="metode_pembayaran" value="<?= $transaksi['metode_pembayaran']; ?>">
                                <input type="hidden" name="id_tabungan" value="<?= $transaksi['id_tabungan']; ?>">
                                <input type="hidden" name="bukti" value="<?= $transaksi['bukti']; ?>">
                                <input type="hidden" name="tanggal" value="<?= $transaksi['tanggal']; ?>">
                                <div class="text-center mb-4 mt-1">
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-x-lg me-1"></i>Tolak</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div><!-- End Top Selling -->
            </div><!-- End Left side columns -->
        </div>
    </section>

</main><!-- End #main -->