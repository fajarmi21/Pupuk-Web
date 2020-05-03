<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poktan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $sql = $this->db->get_where("tb_poktan", array('poktan' => $this->input->post('poktan')))->row();
        $poktan = $sql->id_poktan;
        $r['all'] = $this->db->get_where("tb_petani", array('id_kelompok' => $poktan))->num_rows();
        $r['daftar'] = 0;
        $r['belum'] = 0;
        $r['tidak'] = 0;
        $this->db->select('*')->from('tb_petani');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $result = $this->db->where(array('id_kelompok' => $poktan))->get()->result();
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

        // $r['all'] = $this->input->post('poktan');
        // $r['daftar'] = 0;
        // $r['belum'] = 0;
        // $r['tidak'] = 0;
        echo json_encode($r);
    }

    public function petani()
    {
        switch ($this->input->post('kode')) {
            case 'c':
                $sql = $this->db->get_where("tb_poktan", array('poktan' => $this->input->post('poktan')))->row();
                $poktan = $sql->id_poktan;
                $array = array(
                    'id_desa' => $this->input->post('desa'),
                    'id_kelompok' => $poktan,
                    'nik' => $this->input->post('nik'),
                    'nama_petani' => $this->input->post('petani'),
                    'alamat' => $this->input->post('alamat'),
                    'sektor' => $this->input->post('sektor'),
                    'luas_lahan' => $this->input->post('luas')
                );
                $this->db->set($array);
                $p = $this->db->insert('tb_petani');
                $array = array(
                    'username' => $this->input->post('petani'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'level' => '5'
                );
                $this->db->set($array);
                $u = $this->db->insert('tb_user');
                if ($p && $u) {
                    $r['status'] = '1';
                    $r['message'] = 'insert successfully';
                } else {
                    $r['status'] = '0';
                    $r['message'] = 'insert unsuccessfully';
                }
                break;

            case 'r':
                $namePT = $this->input->post('poktan');
                if (isset($namePT)) {
                    $userPT = $this->input->post('petani');
                    if (isset($userPT)) {
                        $rr = $this->db->select("*")->from("tb_petani")->join("tb_user", "tb_user.username = tb_petani.nama_petani")->where(array("nama_petani" => $userPT))->get()->row();
                        if (isset($rr)) $r[] = $rr;
                        // $r[] = $this->db->get()->row();
                    } else {
                        $sql = $this->db->get_where("tb_poktan", array('poktan' => $namePT))->row();
                        $poktan = $sql->id_poktan;
                        echo json_encode($this->db->where(array('id_kelompok' => $poktan))->order_by('id_petani', 'DESC')->get('tb_petani')->result());
                        // foreach ($result as $rr) {
                        //     $r[] = $rr;
                        // }
                    }
                } else {
                    $r['status'] = '0';
                    $r['message'] = 'id_poktan not found';
                }
                break;

            case 'u':
                if (isset($_POST['nik'])) $data1['nik'] = $this->input->post('nik');
                if (isset($_POST['nama_petani'])) $data1['nama_petani'] = $this->input->post('nama_petani');
                if (isset($_POST['alamat'])) $data1['alamat'] = $this->input->post('alamat');
                if (isset($_POST['sektor'])) $data1['sektor'] = $this->input->post('sektor');
                if (isset($_POST['luas_lahan'])) $data1['luas_lahan'] = $this->input->post('luas_lahan');
                if (isset($_POST['username'])) $data2['username'] = $this->input->post('username');
                if (isset($_POST['email'])) $data2['email'] = $this->input->post('email');

                $this->db->trans_begin();
                # Updating data petani
                $this->db->update('tb_petani', $data1, array('nama_petani' => $this->input->post('nama')));

                # Updating data user
                $this->db->update('tb_user', $data2, array('username' => $this->input->post('nama')));
                $this->db->trans_complete();

                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    $r['status'] = '1';
                    $r['message'] = 'update successfully';
                } else {
                    $this->db->trans_rollback();
                    $r['status'] = '0';
                    $r['message'] = 'update unsuccessfully';
                }
                break;

            case 'd':
                $r['petani'] = $this->input->post('petani');
                $d = $this->db->delete('tb_petani', array('nama_petani' => $this->input->post('petani')));
                $e = $this->db->delete('tb_user', array('username' => $this->input->post('petani')));
                if ($d && $e) {
                    $r['status'] = '1';
                    $r['message'] = 'delete successfully';
                } else {
                    $r['status'] = '0';
                    $r['message'] = 'delete unsuccessfully';
                }
                break;

            default:
                $r['status'] = '0';
                $r['message'] = 'kode not found';
                break;
        }
        if (isset($r)) echo json_encode($r);
    }

    public function usulan()
    {
        $this->db->select('*');
        $this->db->from('tb_petani');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->where(Array('poktan' => $this->input->post('poktan')));
        $sql = $this->db->get()->result_array();
        for ($i=0; $i < count($sql); $i++) {
            if ($sql[$i]['m1'] != null && $sql[$i]['m1'] != 'false') $sql[$i]['m1'] = unserialize(base64_decode($sql[$i]['m1']));
            if ($sql[$i]['m2'] != null && $sql[$i]['m2'] != 'false') $sql[$i]['m2'] = unserialize(base64_decode($sql[$i]['m2']));
            if ($sql[$i]['m3'] != null && $sql[$i]['m3'] != 'false') $sql[$i]['m3'] = unserialize(base64_decode($sql[$i]['m3']));
        }
        echo json_encode($sql);
    }
}
