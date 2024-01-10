<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelSiswa extends CI_Model
{
    public function getSiswa()
    {
        return $this->db->get('siswa');
    }
    public function tambahSiswa($data = null)
    {
        return $this->db->insert('siswa', $data);
    }
}
