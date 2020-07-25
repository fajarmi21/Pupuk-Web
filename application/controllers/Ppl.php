<?php
defined('BASEPATH') or exit('No direct script access allowed');
define('VENDOR', substr(FCPATH, 0, strpos(APPPATH, 'application/')) . "vendor/");
require VENDOR . 'autoload.php';

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
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.kode_desa');
        $this->db->where(Array('nama_desa' => $this->input->post('desa')));
        $this->db->group_by('poktan');
        $r['all'] = $this->db->get()->num_rows();

        $this->db->select('poktan');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.kode_desa');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $r['daftar'] = $this->db->where(array('nama_desa' => $this->input->post('desa')))->group_by('poktan')->get('tb_petani')->num_rows();
        $r['belum'] = $r['all'] - $r['daftar'];
        $r['tidak'] = $r['all'] - ($r['daftar'] + $r['belum']);
        $r['luas'] = 0;
        $r['urea'] = 0;
        $r['sp36'] = 0;
        $r['za'] = 0;
        $r['npk'] = 0;
        $r['organik'] = 0;
        $r['tpupuk'] = 0;
        $r['durea'] = 0;
        $r['dsp36'] = 0;
        $r['dza'] = 0;
        $r['dnpk'] = 0;
        $r['dorganik'] = 0;
        $r['tdpupuk'] = 0;
        
        $this->db->select('*');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.kode_desa');
        $result = $this->db->where(array('nama_desa' => $this->input->post('desa')))->get('tb_petani')->result_array();
        foreach ($result as $res) {
            if ($res['tahap'] != null) {
                if ($res[$res['tahap']] != null) {
                    $tahap = unserialize(base64_decode($res[$res['tahap']]));
                    if (end($tahap) != 'false') {
                        $r['luas'] += end($tahap)['luas'];
                        $r['urea'] += end($tahap)['urea'];
                        $r['sp36'] += end($tahap)['sp36'];
                        $r['za'] += end($tahap)['za'];
                        $r['npk'] += end($tahap)['npk'];
                        $r['organik'] += end($tahap)['organik'];
                        $r['tpupuk'] += (
                            $r['urea'] +
                            $r['sp36'] +
                            $r['za'] +
                            $r['npk'] +
                            $r['organik']
                        );
                    }

                    if ($res['status_admin'] != null) {
                        $admin = unserialize(base64_decode($res['status_admin']));
                        $manager = new \Mesour\ArrayManager($admin);
                        $select = $manager->select();
                        $select->column('*')
                            ->where('tahun', date("Y"), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                            ->where('tahap', $res['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and');
                        $admin = $select->fetch();
                        $r['durea'] += $admin['verifikasi']['urea'];
                        $r['dsp36'] += $admin['verifikasi']['sp36'];
                        $r['dza'] += $admin['verifikasi']['za'];
                        $r['dnpk'] += $admin['verifikasi']['npk'];
                        $r['dorganik'] += $admin['verifikasi']['organik'];
                        $r['tdpupuk'] += (
                            $r['durea'] +
                            $r['dsp36'] +
                            $r['dza'] +
                            $r['dnpk'] +
                            $r['dorganik']
                        );
                    }
                }
            }
        }
        echo json_encode($r);
    }

    public function PplKpR(){
        $poktan = $this->input->post('poktan');
        if ($poktan != null) {
            $this->db->join('tb_desa', 'tb_desa.kode_desa=tb_poktan.id_desa');
            // $this->db->join('tb_user', 'tb_poktan.poktan=tb_user.username');
            $sql = $this->db->get_where('tb_poktan', array('poktan' => $poktan))->row();

            $email = $this->db->get_where("tb_user",array("username" => $poktan))->row("email");
            if(isset($email)) $sql->email = $email;
            $sql = array($sql);
            echo json_encode($sql);
        } else {            
            $this->db->join('tb_desa', 'tb_desa.kode_desa=tb_poktan.id_desa');
            $sql = $this->db->get('tb_poktan')->result();
            echo json_encode($sql);
        }
        // echo "asasa";
    }

    public function PplKpD(){
        $this->db->trans_begin();
            // $this->db->delete('tb_poktan', array('poktan' => $this->input->post('poktan')));                
            $this->db->delete('tb_user', array('username' => $this->input->post('poktan')));
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $r['status'] = '1';
            $r['message'] = 'delete successfully';
        } else {
            $this->db->trans_rollback();
            $r['status'] = '0';
            $r['message'] = 'delete unsuccessfully';
        }
        echo json_encode($r);
    }

    public function PplKpC(){
        $this->db->trans_begin();
        $id = $this->input->post('id');         
        $id_desa = $this->db->get_where("tb_desa",array('nama_desa' => $this->input->post('nama_desa')))->row("kode_desa");        
        $data = array(
                'id_poktan'         => $this->idpoktan(),
                'id_desa'           => $id_desa,
                'poktan'            => $this->input->post('poktan')
              );
        $this->db->insert("tb_poktan", $data);

        $data1 = array(
                'username'          => $this->input->post('poktan'),
                'email'             => $this->input->post('email'),
                'password'          => 'poktan',
                'level'             => 'POKTAN'
              );
        $this->db->insert("tb_user", $data1);
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
        echo json_encode($r);
    }

    public function PplKpU(){
        $this->db->trans_begin();       
        $data = array(
                'poktan'            => $this->input->post('poktan')
            );
        // $this->db->insert("tb_poktan", $data);
        $this->db->update('tb_poktan', $data, array('poktan' => $this->input->post('nama')));

        $email = $this->input->post('email');
        if ($email != null) {
            $data1 = array(
                    'username'          => $this->input->post('poktan'),
                    'email'             => $this->input->post('email'),
                    'password'             => 'poktan',
                    'level'             => 'POKTAN'
                );
            // $this->db->insert("tb_user", $data1);
            $em = $this->db->get_where("tb_user",array("username" => $this->input->post('nama')))->row("email");
            if(isset($em)){
                $this->db->update('tb_user', $data1, array('username' => $this->input->post('nama')));
            } else {
                $this->db->insert('tb_user', $data1);
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
        echo json_encode($r);
    }

    public function idpoktan()
    {
        $sql = $this->db->select("id_poktan")->limit(1)->order_by('id_poktan',"DESC")->get("tb_poktan")->row('id_poktan');
        $id = str_replace("K", "", $sql);
        if($id + 1 < 10) $id = "K00".($id+1);
        elseif($id + 1 < 100) $id = "K0".($id+1);
        else $id = "K".($id + 1);
        return $id;
    }

    public function verifikasi(){
        $this->db->select('poktan');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.kode_desa');
        $this->db->where(Array('nama_desa' => $this->input->post('desa'), 'status_poktan !=' => null));
        $this->db->group_by('poktan');
        $sql = $this->db->get('tb_petani')->result_array();

        foreach ($sql as $key => $val) {
            $sql[$key]['luas'] = 0;
            $this->db->select('*')->from('tb_petani');
            $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
            $this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.kode_desa');
            $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
            $result = $this->db->where(array('nama_desa' => $this->input->post('desa'), 'poktan' => $val['poktan'], 'status_poktan !=' => null))->get()->result_array();

            if ($result != null) {
                foreach ($result as $k => $v) {
                    if ($v[$v['tahap']] != null) {
                        $v[$v['tahap']] = unserialize(base64_decode($v[$v['tahap']]));
    
                        $manager = new \Mesour\ArrayManager($v[$v['tahap']]);
                        $select = $manager->select();
                        $select->column('*', 'date')->orderBy('date', 'DESC');
                        $result[$k][$v['tahap']] = $select->fetchAll();
                        $sql[$key]['luas'] += $result[$k][$v['tahap']][0]['luas'];
                        $x['id'] = $v['id_petani'];
                        $x['petani'] = $v['nama_petani'];
                    }

                    if ($v['status_poktan'] != null) {
                        $v['status_poktan'] = unserialize(base64_decode($v['status_poktan']));
                        $manager = new \Mesour\ArrayManager($v['status_poktan']);
                        $select = $manager->select();
                        $select->column('status')
                            ->where('tahun', date('Y'), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                            ->where('tahap', $v['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL);
                        $result[$k]['status_poktan'] = $select->fetch();
                        $x['status_poktan'] = $result[$k]['status_poktan']['status'];
                    }

                    if ($v['status_ppl'] != null) {
                        $v['status_ppl'] = unserialize(base64_decode($v['status_ppl']));
                        $manager = new \Mesour\ArrayManager($v['status_ppl']);
                        $select = $manager->select();
                        $select->column('*')
                            ->where('tahun', date('Y'), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                            ->where('tahap', $v['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL);
                        $result[$k]['status_ppl'] = $select->fetch();

                        if ($result[$k]['status_ppl'] == 'false' || $result[$k]['status_ppl'] == null ) {
                            $x['verifikasi'] = 'false';
                        } else {
                            $x['verifikasi'] = 'true';
                        }
                    } else {
                        $x['verifikasi'] = 'false';
                    }

                    if ($v['status_admin'] != null) {
                        $v['status_admin'] = unserialize(base64_decode($v['status_admin']));
                        $manager = new \Mesour\ArrayManager($v['status_admin']);
                        $select = $manager->select();
                        $select->column('*')
                            ->where('tahun', date('Y'), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                            ->where('tahap', $v['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL);
                        $result[$k]['status_admin'] = $select->fetch();

                        if ($result[$k]['status_admin'] == 'false' || $result[$k]['status_admin'] == null ) {
                            $x['admin'] = 'false';
                        } else {
                            $x['admin'] = 'true';
                        }
                    } else {
                        $x['admin'] = 'false';
                    }
                    $sql[$key]['data'][] = $x;
                }
            }
        }
        echo json_encode($sql);
    }

    public function verifikasiU()
    {
        $this->db->trans_begin();
            $id[] = $this->input->post('id');
            foreach ($this->input->post('id') as $key) {
                // $idx = $key;
                $sql = $this->db->get_where('tb_usulan', array('id_petani' => $key))->row('status_ppl');
                $q = $this->db->get_where('tb_petani', array('id_petani' => $key))->row('tahap');
                $push = array('status' => 'true', 'tahap' => $q, 'tahun' => date("Y"));
                $ar = array();
                if ($sql != null) {
                    $ar = unserialize(base64_decode($sql));
                }
                array_push($ar, $push);
                $this->db->update('tb_usulan', array('status_ppl' => base64_encode(serialize($ar))), array('id_petani' => $key));
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

    public function verifikasiT()
    {
        $this->db->trans_begin();
            foreach ($this->input->post('id') as $key) {
                // $idx = $key;
                $sql = $this->db->get_where('tb_usulan', array('id_petani' => $key))->row('status_ppl');
                $q = $this->db->get_where('tb_petani', array('id_petani' => $key))->row('tahap');
                $push = array('status' => 'false', 'alasan' => $this->input->post('alasan'), 'tahap' => $q, 'tahun' => date("Y"));
                $ar = array();
                if ($sql != null) {
                    $ar = unserialize(base64_decode($sql));
                }
                array_push($ar, $push);
                $this->db->update('tb_usulan', array('status_ppl' => base64_encode(serialize($ar))), array('id_petani' => $key));
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
}