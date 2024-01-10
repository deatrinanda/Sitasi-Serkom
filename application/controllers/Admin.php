<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

	
    function index()
    {
		// Mendapatkan nomor induk siswa (NIS) dari sesi
        $nis = $this->session->userdata('nis');
		
		 // Menyiapkan data yang akan digunakan dalam tampilan
        $data = [
            'title' => "Dashboard",
            'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
            'siswa' => $this->ModelSiswa->getSiswa()->result_array(),
            'jmlSiswa' => $this->ModelSiswa->getSiswa()->num_rows(),
            'jmlProses' => $this->ModelTransaksi->cekTransaksi([
                'status' => 'Diproses'
            ])->num_rows(),
        ];
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    function dataSiswa()
    {
        $nis = $this->session->userdata('nis');
        $data = [
            'title' => "Data Siswa",
            'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
            'siswa' => $this->ModelSiswa->getSiswa()->result_array(),
        ];
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/dataSiswa', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    public function tambahSiswa()
    {
        $this->form_validation->set_rules('nis', 'NIS', 'required|trim|is_unique[user.nis]', [
            'required' => 'Masukan NIS.',
            'is_unique' => 'NIS sudah ada.'
        ]);

        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required' => 'Masukan Nama.'
        ]);
        $this->form_validation->set_rules('no_telepon', 'No Telepon', 'required', [
            'required' => 'Masukan No Telepon.'
        ]);

        if ($this->form_validation->run() == false) {
            $nis = $this->session->userdata('nis');
            $data = [
                'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
                'title' => 'Tambah Siswa'
            ];

            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/topbar', $data);
            $this->load->view('admin/sidebar', $data);
            $this->load->view('admin/tambahSiswa', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $nis = $this->input->post('nis', true);
            $dataSiswa = [
                'nis' => htmlspecialchars($nis),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'no_telepon' => htmlspecialchars($this->input->post('no_telepon', true)),
                'kelas' => $this->input->post('kelas'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tahun_masuk' => $this->input->post('tahun_masuk'),
            ];
            $this->ModelSiswa->tambahSiswa($dataSiswa);
            $dataUser = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'nis' => htmlspecialchars($nis),
                'image' => 'default.jpg',
                'password' => password_hash(
                    'sitasi2023',
                    PASSWORD_DEFAULT
                ),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];
            $this->ModelUser->simpanData($dataUser);

            $dataTabungan = [
                'nis' => htmlspecialchars($nis),
            ];
            $this->ModelTabungan->tambahTabungan($dataTabungan);

            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                <b>Sukses!</b> Siswa baru telah ditambahkan.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('admin/dataSiswa');
        }
    }

	// Fungsi untuk menampilkan data transaksi
    function dataTransaksi()
    {
		 // Mendapatkan NIS dari sesi
        $nis = $this->session->userdata('nis');
		 // Mengambil data untuk top bar
        $data = [
            'title' => "Data Transaksi",
            'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
			// Mengambil data transaksi setoran yang sedang diproses
            'setoran_proses' => $this->ModelTransaksi->cekTransaksi([
                'jenis_transaksi' => 'Setoran',
                'status' => 'Diproses'
            ])->result_array(),
			// Mengambil data transaksi penarikan yang sedang diproses
            'penarikan_proses' => $this->ModelTransaksi->cekTransaksi([
                'jenis_transaksi' => 'Penarikan',
                'status' => 'Diproses'
            ])->result_array(),

        ];
		// Memuat tampilan untuk menampilkan halaman
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/dataTransaksi', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    function detailSetoran($id_transaksi)
    {
        $nis = $this->session->userdata('nis');

        $data = [
            'title' => "Detail Setoran",
            'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
            'transaksi' => $this->ModelTransaksi->cekTransaksi([
                'id_transaksi' => $id_transaksi
            ])->row_array(),
            'tabungan' => $this->db->query(
                "SELECT tabungan.id_tabungan, tabungan.nis, tabungan.saldo
                FROM tabungan
                INNER JOIN transaksi ON tabungan.id_tabungan = transaksi.id_tabungan
                WHERE transaksi.id_transaksi= " . $id_transaksi
            )->row_array(),
            'siswa' => $this->db->query(
                "SELECT siswa.nis, siswa.no_telepon, user.nama
                FROM siswa
                JOIN user ON siswa.nis = user.nis
                JOIN transaksi ON user.id = transaksi.id_user
                WHERE transaksi.id_transaksi= " . $id_transaksi
            )->row_array(),

        ];
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/detail_setoran', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    function terimaSetoran($id_transaksi)
    {
        $id_user = $this->input->post('id_user');
        $id_tabungan = $this->input->post('id_tabungan');
        $jenis_transaksi = $this->input->post('jenis_transaksi');
        $nominal = $this->input->post('nominal', true);
        $catatan = $this->input->post('catatan', true);
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $status = 'Diterima';
        $bukti = $this->input->post('bukti');
        $tanggal = $this->input->post('tanggal');
        $dataTransaksi = array(
            'id_user' => $id_user,
            'jenis_transaksi' => $jenis_transaksi,
            'nominal' => $nominal,
            'catatan' => $catatan,
            'metode_pembayaran' => $metode_pembayaran,
            'bukti' => $bukti,
            'status' => $status,
            'id_tabungan' => $id_tabungan,
            'tanggal' => $tanggal
        );
        $this->ModelTransaksi->updateTransaksi($dataTransaksi);
        $nis = $this->input->post('nis');
        $old_saldo = $this->input->post('saldo');
        $saldo = $old_saldo + $nominal;
        $dataTabungan = array(
            'nis' => $nis,
            'saldo' => $saldo,
        );
        $this->ModelTabungan->updateTabungan($dataTabungan);
        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    <b>Sukses!</b> Transaksi telah diproses.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
        );
        redirect('admin/dataTransaksi');
    }

    function tolakSetoran($id_transaksi)
    {
        $id_user = $this->input->post('id_user');
        $id_tabungan = $this->input->post('id_tabungan');
        $jenis_transaksi = $this->input->post('jenis_transaksi');
        $nominal = $this->input->post('nominal', true);
        $catatan = $this->input->post('catatan', true);
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $status = 'Ditolak';
        $bukti = $this->input->post('bukti');
        $tanggal = $this->input->post('tanggal');
        $dataTransaksi = array(
            'id_user' => $id_user,
            'jenis_transaksi' => $jenis_transaksi,
            'nominal' => $nominal,
            'catatan' => $catatan,
            'metode_pembayaran' => $metode_pembayaran,
            'bukti' => $bukti,
            'status' => $status,
            'id_tabungan' => $id_tabungan,
            'tanggal' => $tanggal
        );
        $this->ModelTransaksi->updateTransaksi($dataTransaksi);

        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    <b>Sukses!</b> Transaksi telah ditolak.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
        );
        redirect('admin/dataTransaksi');
    }
    function detailPenarikan($id_transaksi)
    {
        $nis = $this->session->userdata('nis');

        $data = [
            'title' => "Detail Penarikan",
            'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
            'transaksi' => $this->ModelTransaksi->cekTransaksi([
                'id_transaksi' => $id_transaksi
            ])->row_array(),
            'tabungan' => $this->db->query(
                "SELECT tabungan.id_tabungan, tabungan.nis, tabungan.saldo
                FROM tabungan
                INNER JOIN transaksi ON tabungan.id_tabungan = transaksi.id_tabungan
                WHERE transaksi.id_transaksi= " . $id_transaksi
            )->row_array(),
            'siswa' => $this->db->query(
                "SELECT siswa.nis, siswa.no_telepon, user.nama
                FROM siswa
                JOIN user ON siswa.nis = user.nis
                JOIN transaksi ON user.id = transaksi.id_user
                WHERE transaksi.id_transaksi= " . $id_transaksi
            )->row_array(),

        ];
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/detail_penarikan', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    function terimaPenarikan($id_transaksi)
    {
        $id_user = $this->input->post('id_user');
        $id_tabungan = $this->input->post('id_tabungan');
        $jenis_transaksi = $this->input->post('jenis_transaksi');
        $nominal = $this->input->post('nominal', true);
        $catatan = $this->input->post('catatan', true);
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $status = 'Diterima';
        $tanggal = $this->input->post('tanggal');
        $file_name = str_replace('.', '', $id_user . $tanggal);
        $config['upload_path'] = FCPATH . './uploads/bukti/';
        $config['file_name'] = $file_name;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['overwrite'] = TRUE;
        $config['max_size'] = 2048;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('bukti')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                <i class="bi bi-cross-circle me-1"></i>' . $error
                    .
                    '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('admin/detailPenarikan/' . $id_transaksi);
        } else {
            $dataTransaksi = array(
                'id_user' => $id_user,
                'jenis_transaksi' => $jenis_transaksi,
                'nominal' => $nominal,
                'catatan' => $catatan,
                'metode_pembayaran' => $metode_pembayaran,
                'bukti' => $this->upload->data('file_name'),
                'status' => $status,
                'id_tabungan' => $id_tabungan,
                'tanggal' => $tanggal
            );
            $this->ModelTransaksi->updateTransaksi($dataTransaksi);
            $nis = $this->input->post('nis');
            $old_saldo = $this->input->post('saldo');
            $saldo = $old_saldo - $nominal;
            $dataTabungan = array(
                'nis' => $nis,
                'saldo' => $saldo,
            );
            $this->ModelTabungan->updateTabungan($dataTabungan);
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        <b>Sukses!</b> Transaksi telah diproses.
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
            );
            redirect('admin/dataTransaksi');
        }
    }

    function tolakPenarikan($id_transaksi)
    {
        $id_user = $this->input->post('id_user');
        $id_tabungan = $this->input->post('id_tabungan');
        $jenis_transaksi = $this->input->post('jenis_transaksi');
        $nominal = $this->input->post('nominal', true);
        $catatan = $this->input->post('catatan', true);
        $metode_pembayaran = $this->input->post('metode_pembayaran');
        $status = 'Ditolak';
        $bukti = $this->input->post('bukti');
        $tanggal = $this->input->post('tanggal');
        $dataTransaksi = array(
            'id_user' => $id_user,
            'jenis_transaksi' => $jenis_transaksi,
            'nominal' => $nominal,
            'catatan' => $catatan,
            'metode_pembayaran' => $metode_pembayaran,
            'bukti' => $bukti,
            'status' => $status,
            'id_tabungan' => $id_tabungan,
            'tanggal' => $tanggal
        );
        $this->ModelTransaksi->updateTransaksi($dataTransaksi);

        $this->session->set_flashdata(
            'pesan',
            '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    <b>Sukses!</b> Transaksi telah ditolak.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
        );
        redirect('admin/dataTransaksi');
    }

    function dataTabungan()
    {
        $nis = $this->session->userdata('nis');
        $query = "SELECT * FROM tabungan 
        JOIN user ON user.nis = tabungan.nis
        JOIN siswa ON siswa.nis = tabungan.nis";
        $sumSaldo = $this->db->query("SELECT SUM(saldo) AS saldo_diterima FROM tabungan");
        $data = [
            'title' => "Data Tabungan Siswa",
            'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
            'saldo' => $sumSaldo->row_array(),
            'tabungan' => $this->db->query($query)->result_array(),
            'saldo_masuk' => $this->db->query(
                "SELECT SUM(nominal) AS saldo_masuk FROM transaksi 
                WHERE jenis_transaksi = 'Setoran' AND status = 'Diterima'"
            )->row_array(),
            'saldo_keluar' => $this->db->query(
                "SELECT SUM(nominal) AS saldo_keluar FROM transaksi 
                WHERE jenis_transaksi = 'Penarikan' AND status = 'Diterima'"
            )->row_array(),
        ];
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/dataTabungan', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    function detailTabungan($id_tabungan)
    {
        $nis = $this->session->userdata('nis');

        $query = "SELECT * FROM tabungan 
        JOIN transaksi ON transaksi.id_tabungan = tabungan.id_tabungan
        JOIN siswa ON siswa.nis = tabungan.nis
        WHERE tabungan.id_tabungan = " . $id_tabungan;

        $user = "SELECT * FROM tabungan 
        JOIN user ON user.nis = tabungan.nis
        JOIN siswa ON siswa.nis = tabungan.nis
        WHERE tabungan.id_tabungan = " . $id_tabungan;

        $sumSaldo = $this->db->query("SELECT SUM(saldo) AS saldo_diterima FROM tabungan WHERE id_tabungan = " . $id_tabungan);
        $data = [
            'title' => "Detail Tabungan Siswa",
            'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
            'saldo' => $sumSaldo->row_array(),
            'tabungan' => $this->db->query($query)->result_array(),
            'user' => $this->db->query($user)->row_array(),
            'saldo_masuk' => $this->db->query(
                "SELECT SUM(nominal) AS saldo_masuk FROM transaksi 
                WHERE jenis_transaksi = 'Setoran' AND status = 'Diterima' AND id_tabungan = " . $id_tabungan
            )->row_array(),
            'saldo_keluar' => $this->db->query(
                "SELECT SUM(nominal) AS saldo_keluar FROM transaksi 
                WHERE jenis_transaksi = 'Penarikan' AND status = 'Diterima' AND id_tabungan = " . $id_tabungan
            )->row_array(),
        ];
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/topbar', $data);
        $this->load->view('admin/sidebar', $data);
        $this->load->view('admin/detailTabungan', $data);
        $this->load->view('templates/admin_footer', $data);
    }



    public function profile()
    {

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required', [
            'required' => 'Nama belum diisi!'
        ]);

        if ($this->form_validation->run() == false) {
            $nis = $this->session->userdata('nis');
            $data = [
                'title' => 'Profile',
                'topbar' => $this->ModelUser->cekUser(['nis' => $nis])->row_array(),
                'user' => $this->ModelUser->cekUser(['nis' => $nis])->row_array()
            ];

            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/topbar', $data);
            $this->load->view('admin/sidebar', $data);
            $this->load->view('admin/profile', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $data = [
                'id' => $this->input->post('id'),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'image' => $this->input->post('image'),
                'password' => $this->input->post('password'),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active'),
                'date_created' => $this->input->post('date_created')
            ];

            $this->ModelUser->editProfile_proses($data);
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    <b>Sukses!</b> Profil telah diperbarui.
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
            redirect('admin/profile');
        }
    }

    public function print_data_siswa()
    {
        $data = [
            'title' => "Cetak Data Siswa",
            'siswa' => $this->ModelSiswa->getSiswa()->result_array(),
        ];
        $this->load->view('admin/print_data_siswa', $data);
    }

    public function pdf_data_siswa()
    {
        $this->load->library('Dompdf_gen');

        $data = [
            'title' => "Cetak Data Siswa",
            'siswa' => $this->ModelSiswa->getSiswa()->result_array(),
        ];
        $this->load->view('admin/pdf_data_siswa', $data);

        $paper = 'A4';
        $orien = 'landscape';
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper, $orien);
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream('laporan_data_siswa.pdf');
    }

    public function excel_data_siswa()
    {
        $data = [
            'title' => "Cetak Data Siswa",
            'filename' => "Laporan Data Siswa",
            'siswa' => $this->ModelSiswa->getSiswa()->result_array(),
        ];
        $this->load->view('admin/excel_data_siswa', $data);
    }

    public function print_transaksi($status)
    {
        $transaksi = $this->db->query("SELECT * FROM transaksi
        JOIN user ON user.id = transaksi.id_user
        JOIN siswa ON user.nis = siswa.nis
        WHERE transaksi.status = '" . $status .
            "' ORDER BY transaksi.tanggal ASC")->result_array();
        $data = [
            'title' => "Cetak Transaksi",
            'transaksi' => $transaksi,
        ];
        $this->load->view('admin/print_transaksi', $data);
    }

    public function pdf_transaksi($status)
    {
        $this->load->library('Dompdf_gen');

        $transaksi = $this->db->query("SELECT * FROM transaksi
        JOIN user ON user.id = transaksi.id_user
        JOIN siswa ON user.nis = siswa.nis
        WHERE transaksi.status = '" . $status .
            "' ORDER BY transaksi.tanggal ASC")->result_array();
        $data = [
            'title' => "Cetak Transaksi",
            'transaksi' => $transaksi,
        ];
        $this->load->view('admin/pdf_transaksi', $data);

        $paper = 'A4';
        $orien = 'landscape';
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper, $orien);
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan_transaksi_" . $status . ".pdf");
    }

    public function excel_transaksi($status)
    {
        $transaksi = $this->db->query("SELECT * FROM transaksi
        JOIN user ON user.id = transaksi.id_user
        JOIN siswa ON user.nis = siswa.nis
        WHERE transaksi.status = '" . $status .
            "' ORDER BY transaksi.tanggal ASC")->result_array();
        $data = [
            'title' => "Cetak Data Transaksi",
            'filename' => "Laporan Data Transaksi " . $status,
            'transaksi' => $transaksi,
        ];
        $this->load->view('admin/excel_transaksi', $data);
    }

    public function print_data_tabungan()
    {
        $query = "SELECT * FROM tabungan 
        JOIN user ON user.nis = tabungan.nis
        JOIN siswa ON siswa.nis = tabungan.nis";
        $data = [
            'title' => "Cetak Data Tabungan Siswa",
            'tabungan' => $this->db->query($query)->result_array(),
        ];
        $this->load->view('admin/print_data_tabungan', $data);
    }

    public function pdf_data_tabungan()
    {
        $this->load->library('Dompdf_gen');

        $query = "SELECT * FROM tabungan 
        JOIN user ON user.nis = tabungan.nis
        JOIN siswa ON siswa.nis = tabungan.nis";
        $data = [
            'title' => "Cetak Data Tabungan Siswa",
            'tabungan' => $this->db->query($query)->result_array(),
        ];
        $this->load->view('admin/pdf_data_tabungan', $data);

        $paper = 'A4';
        $orien = 'landscape';
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper, $orien);
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream('laporan_data_tabungan.pdf');
    }

    public function excel_data_tabungan()
    {
        $query = "SELECT * FROM tabungan 
        JOIN user ON user.nis = tabungan.nis
        JOIN siswa ON siswa.nis = tabungan.nis";
        $data = [
            'title' => "Cetak Data Tabungan Siswa",
            'filename' => "Laporan Data Tabungan Siswa",
            'tabungan' => $this->db->query($query)->result_array(),
        ];
        $this->load->view('admin/excel_data_tabungan', $data);
    }
}
