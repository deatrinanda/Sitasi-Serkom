<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex flex-column justify-content-center py-2 logo">
                    <a href="<?= base_url('auth'); ?>" class="text-center">
                        <span>SITASI</span>
                    </a>
                    <span class="fs-6 text-center fw-normal mb-0">Sistem Informasi Tabungan Siswa</span>
                    <span class="fs-5 text-center fw-normal py-2">SDN 1 Brebes</span>
                </div><!-- End Logo -->

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                            <p class="text-center small">Masukan NIS dan Password Anda Untuk Login</p>
                        </div>
                        <?= $this->session->flashdata('pesan'); ?>

                        <form class="row g-3" action="<?= base_url('auth'); ?>" method="POST">

                            <div class="col-12">
                                <label for="yournis" class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control" id="yournis">
                                <?= form_error('nis', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="yourPassword">
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="credits">
                    Made With ❤️ By Group of 5
                </div>

            </div>
        </div>
    </div>

</section>
