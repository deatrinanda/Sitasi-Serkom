<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    function index()
    {
        if ($this->session->userdata('nis')) {
            redirect('user');
        }

        $this->form_validation->set_rules('nis', 'NIS', 'required|trim', [
            'required' => 'Masukan NIS!',
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Masukan Password!'
        ]);

        if ($this->form_validation->run() == false) {
            $data = [
                'title' => "SITASI - Login"
            ];
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $nis = htmlspecialchars($this->input->post('nis', true));
        $password = $this->input->post('password', true);
        $user = $this->ModelUser->cekLogin(['nis' => $nis])->row_array();

        // jika usernya ada
        if ($user) {
            // jika user active
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'nis' => $user['nis'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata(
                        'pesan',
                        '<div class="alert alert-danger alert-message" role="alert">
                            Password salah!
                        </div>'
                    );
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="alert alert-danger alert-message" role="alert">
                        Akun belum diaktivasi!
                    </div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata(
                'pesan',
                '<div class="alert alert-danger alert-message" role="alert">
                    NIS belum terdaftar!
                </div>'
            );
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('nis');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success" role="alert">
                Kamu telah log out!
            </div>'
        );
        redirect('auth');
    }
}
