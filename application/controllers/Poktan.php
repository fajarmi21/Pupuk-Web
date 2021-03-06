<?php
defined('BASEPATH') or exit('No direct script access allowed');
define('VENDOR', substr(FCPATH, 0, strpos(APPPATH, 'application/')) . "vendor/");
require VENDOR . 'autoload.php';

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
        $r['admin']['verifikasi']['urea'] = 0;
        $r['admin']['verifikasi']['sp36'] = 0;
        $r['admin']['verifikasi']['za'] = 0;
        $r['admin']['verifikasi']['npk'] = 0;
        $r['admin']['verifikasi']['organik'] = 0;
        $this->db->select('*')->from('tb_petani');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $this->db->join('tb_tahap', 'tb_petani.tahap = tb_tahap.tahap');
        $result = $this->db->where(array('id_kelompok' => $poktan))->get()->result_array();
        $bulan = $this->db->select("tahap")->get_where('tb_tahap', array('bulan <=' => date('m')))->last_row();
        foreach ($result as $res) {
            if ($res[$bulan->tahap] != null) {
                $tahap = unserialize(base64_decode($res[$bulan->tahap]));
                if (end($tahap) != 'false') {
                    $r['luas'] += end($tahap)['luas'];
                    $r['urea'] += end($tahap)['urea'];
                    $r['sp36'] += end($tahap)['sp36'];
                    $r['za'] += end($tahap)['za'];
                    $r['npk'] += end($tahap)['npk'];
                    $r['organik'] += end($tahap)['organik'];
                }

                if ($res['status_poktan'] != null) {
                    $poktan = unserialize(base64_decode($res['status_poktan']));
                    $manager = new \Mesour\ArrayManager($poktan);
                    $select = $manager->select();
                    $poktan = $select->column('*')
                        ->where('tahun', date("Y"), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                        ->where('tahap', $res['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                        ->fetch();
                    if ($poktan['status'] == 'true') {
                        $r['daftar'] += 1;
                    } else {
                        $r['tidak'] += 1;
                    }
                } else {
                    $r['belum'] += 1;
                }

                if ($res['status_admin'] != null) {
                    $admin = unserialize(base64_decode($res['status_admin']));
                    $manager = new \Mesour\ArrayManager($admin);
                    $select = $manager->select();
                    $select->column('*')
                        ->where('tahun', date("Y"), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                        ->where('tahap', $res['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and');
                    $admin = $select->fetch();
                    $r['admin']['verifikasi']['urea'] += $admin['verifikasi']['urea'];
                    $r['admin']['verifikasi']['sp36'] += $admin['verifikasi']['sp36'];
                    $r['admin']['verifikasi']['za'] += $admin['verifikasi']['za'];
                    $r['admin']['verifikasi']['npk'] += $admin['verifikasi']['npk'];
                    $r['admin']['verifikasi']['organik'] += $admin['verifikasi']['organik'];
                }
            }
            // $r['belum'] = $r['all'] - ($r['daftar'] + $r['tidak']);
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
                        $rr = $this->db->select("*")->from("tb_petani")
                            ->where(array("nama_petani" => $userPT))->get()->row_array();

                        $email = $this->db->get_where("tb_user",array("username" => $userPT))->row("email");
                        if(isset($email)) $rr['email'] = $email;
                        if (isset($rr)) $r[] = $rr;
                    } else {
                        $sql = $this->db->get_where("tb_poktan", array('poktan' => $namePT))->row();
                        $poktan = $sql->id_poktan;
                        echo json_encode($this->db
                            ->where(array('id_kelompok' => $poktan))
                            ->order_by('id_petani', 'DESC')
                            ->get('tb_petani')->result());
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
                if ($data2['email'] != "null") {
                    $email = $this->db->get_where("tb_user",array("username" => $this->input->post('nama')))->row("email");
                    if(isset($email)){
                        $this->db->update('tb_user', $data2, array('username' => $this->input->post('nama')));
                    } else {
                        $data2["password"] = "user";
                        $data2["level"] = "PETANI";
                        $this->db->set($data2);
                        $this->db->insert('tb_user');
                    }
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
                break;

            case 'd':
                $r['petani'] = $this->input->post('petani');
                // $d = $this->db->delete('tb_petani', array('nama_petani' => $this->input->post('petani')));
                $e = $this->db->delete('tb_user', array('username' => $this->input->post('petani')));
                if ($e) {
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
        $bulan = $this->db->select("tahap")->get_where('tb_tahap', array('bulan <=' => date('m')))->last_row();
        $this->db->select('*');
        $this->db->from('tb_petani');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_tahap', 'tb_petani.tahap = tb_tahap.tahap');
        $this->db->where(Array('poktan' => $this->input->post('poktan'), 'tb_petani.tahap' => $bulan->tahap));
        $sql = $this->db->get()->result_array();
        foreach ($sql as $s => $v) {
            if ($v[$bulan->tahap] != null) {
                if ($v['m1'] != null) $sql[$s]['m1'] = unserialize(base64_decode($v['m1']));
                if ($v['m2'] != null) $sql[$s]['m2'] = unserialize(base64_decode($v['m2']));
                if ($v['m3'] != null) $sql[$s]['m3'] = unserialize(base64_decode($v['m3']));
                
                if ($v['status_poktan'] != null) {
                    $v['status_poktan'] = unserialize(base64_decode($v['status_poktan']));
                    $manager = new \Mesour\ArrayManager($v['status_poktan']);
                    $select = $manager->select();
                    $select->column('*')
                    ->where('tahun', date('Y'), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                    ->where('tahap', $v['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL);
                    $sql[$s]['status_poktan'] = $select->fetch();
                }
                if ($v['status_ppl'] != null) {
                    $v['status_ppl'] = unserialize(base64_decode($v['status_ppl']));
                    $manager = new \Mesour\ArrayManager($v['status_ppl']);
                    $select = $manager->select();
                    $select->column('*')
                    ->where('tahun', date('Y'), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                    ->where('tahap', $v['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL);
                    $sql[$s]['status_ppl'] = $select->fetch();
                }
                if ($v['status_admin'] != null) {
                    $v['status_admin'] = unserialize(base64_decode($v['status_admin']));
                    $manager = new \Mesour\ArrayManager($v['status_admin']);
                    $select = $manager->select();
                    $select->column('*')
                    ->where('tahun', date('Y'), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                    ->where('tahap', $v['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL);
                    $sql[$s]['status_admin'] = $select->fetch();
                }
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
                $push = array('status' => 'true', 'tahap' => $q, 'tahun' => date("Y"));
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

    public function usulanT()
    {
        $this->db->trans_begin();
            $sql = $this->db->get_where('tb_usulan', array('id_petani' => $this->input->post('id')))->row('status_poktan');
            $q = $this->db->get_where('tb_petani', array('id_petani' => $this->input->post('id')))->row('tahap');
            $push = array('status' => 'false', 'alasan' => $this->input->post('alasan'), 'tahap' => $q, 'tahun' => date("Y"));
            $ar = array();
            if ($sql != null) {
                $ar = unserialize(base64_decode($sql));
            }
            array_push($ar, $push);
            $this->db->update('tb_usulan', array('status_poktan' => base64_encode(serialize($ar))), array('id_petani' => $this->input->post('id')));
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
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join("tb_desa", "tb_poktan.id_desa = tb_desa.kode_desa");
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
        echo json_encode($sql);
    }
}
