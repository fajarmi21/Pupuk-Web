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
        $r['luas'] = 0;
        $r['urea'] = 0;
        $r['sp36'] = 0;
        $r['za'] = 0;
        $r['npk'] = 0;
        $r['organik'] = 0;
        $this->db->select('*')->from('tb_petani');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $result = $this->db->where(array('id_kelompok' => $poktan))->get()->result();
        foreach ($result as $res) {
            $thp = $res->tahap;
            if ($res->$thp != null) {
                $tahap = unserialize(base64_decode($res->$thp));
                if (end($tahap) == 'false') {
                    $r['daftar'] += 0;
                    $r['tidak'] += 1;
                } else {
                    $r['daftar'] += 1;
                    $r['tidak'] += 0;
                    $r['luas'] += end($tahap)['luas'];
                    $r['urea'] += end($tahap)['urea'];
                    $r['sp36'] += end($tahap)['sp36'];
                    $r['za'] += end($tahap)['za'];
                    $r['npk'] += end($tahap)['npk'];
                    $r['organik'] += end($tahap)['organik'];
                }
            }
            if ($res->status_admin != null) {
                $status = unserialize(base64_decode($res->status_admin));
                $r['status'] = 'true';
            } else {
                $r['status'] = 'false';
            }
            $r['belum'] = $r['all'] - ($r['daftar'] + $r['tidak']);

            if ($res->status_poktan != null) {
                $sp = unserialize(base64_decode($res->status_poktan));
                $search = $this->search($sp, array('m3','2020'));
            }
        }
        echo json_encode($r);
    }

    public function petani()
    {
        switch ($this->input->post('kode')) {
            case 'c':
                $this->db->trans_begin();
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
                    $this->db->insert('tb_petani');
                    $array = array(
                        'username' => $this->input->post('petani'),
                        'email' => $this->input->post('email'),
                        'password' => $this->input->post('password'),
                        'level' => 'PETANI'
                    );
                    $this->db->set($array);
                    $this->db->insert('tb_user');
                $this->db->trans_complete();
                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    $r['status'] = '1';
                    $r['message'] = 'insert successfully';
                } else {
                    $this->db->trans_rollback();
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
            
            if ($sql[$i]['status_poktan'] != null) {
                $sql[$i]['status_poktan'] = unserialize(base64_decode($sql[$i]['status_poktan']));
            }
        }
        echo json_encode($sql);
    }

    public function usulanU()
    {
        $this->db->trans_begin();
            $id[] = $this->input->post('id');
            foreach ($this->input->post('id') as $key) {
                $sql = $this->db->get_where('tb_usulan', array('id_petani' => $key))->row('status_poktan');
                $q = $this->db->get_where('tb_petani', array('id_petani' => $key))->row('tahap');
                $push = array('true', $q, date("Y"));
                $ar = array();
                if ($sql != null) {
                    $ar = unserialize(base64_decode($sql));
                }
                array_push($ar, $push);
                $this->db->update('tb_usulan', array('status_poktan' => base64_encode(serialize($ar))), array('id_petani' => $key));
            }
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
        echo json_encode($r);
    }

    public function rekap()
    {
        $this->db->join("tb_usulan", "tb_petani.id_petani = tb_usulan.id_petani");
        $this->db->join("tb_desa", "tb_petani.id_desa = tb_desa.kode_desa");
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->where(array('poktan' => $this->input->post('poktan')));
        $sql = $this->db->get("tb_petani")->result();
        foreach ($sql as $s)
        {
            if ($s->m1 != null && $s->m1 != 'false') $s->m1 = unserialize(base64_decode($s->m1));
            if ($s->m2 != null && $s->m2 != 'false') $s->m2 = unserialize(base64_decode($s->m2));
            if ($s->m3 != null && $s->m3 != 'false') $s->m3 = unserialize(base64_decode($s->m3));

            if ($s->status_poktan != null && $s->status_poktan != 'false') $s->status_poktan = unserialize(base64_decode($s->status_poktan));
            if ($s->status_ppl != null && $s->status_ppl != 'false') $s->status_ppl = unserialize(base64_decode($s->status_ppl));
            if ($s->status_admin != null && $s->status_admin != 'false') $s->status_admin = unserialize(base64_decode($s->status_admin));
        }
        // $x = array();
        // array_push($sql->m1, 'false');
        // array_push($x, $sql->m1);
        // $sql->m1 = $x;
        echo json_encode($sql);
    }

    function search($array, $search_list) { 
  
        // Create the result array 
        $result = array(); 
      
        // Iterate over each search condition 
        foreach ($search_list as $v) { 
            $result[] = array_search($v, array_column($array));
        }

        // array_unique($result);
      
        // Return result  
        return $result; 
    } 
}
