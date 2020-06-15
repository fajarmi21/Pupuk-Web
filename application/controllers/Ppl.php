<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ppl extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $this->db->select('poktan')->from('tb_petani');
        $this->db->join('tb_desa', 'tb_petani.id_desa = tb_desa.kode_desa');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->where(Array('nama_desa' => $this->input->post('desa')));
        $this->db->group_by('poktan');
        $r['all'] = $this->db->get()->num_rows();
        $r['daftar'] = 0;
        $r['belum'] = 0;
        $r['tidak'] = 0;

        $this->db->select('*')->from('tb_petani');
        $this->db->join('tb_desa', 'tb_petani.id_desa = tb_desa.kode_desa');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $result = $this->db->where(array('nama_desa' => $this->input->post('desa')))->get()->result();
        foreach ($result as $res) {
            switch ($res->tahap) {
                case 'm1':
                    if ($res->m1 == 'false') {
                        $r['daftar'] += 0;
                        $r['tidak'] += 1;
                    } else {
                        $r['daftar'] += 1;
                        $r['tidak'] += 0;
                    }
                    break;

                case 'm2':
                    if ($res->m2 == 'false') {
                        $r['daftar'] += 0;
                        $r['tidak'] += 1;
                    } else {
                        $r['daftar'] += 1;
                        $r['tidak'] += 0;
                    }
                    break;

                case 'm3':
                    if ($res->m3 == 'false') {
                        $r['daftar'] += 0;
                        $r['tidak'] += 1;
                    } else {
                        $r['daftar'] += 1;
                        $r['tidak'] += 0;
                    }
                    break;
            }
            $r['belum'] = $r['all'] - ($r['daftar'] + $r['tidak']);
        }
        echo json_encode($r);
    }
}