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
        $r['tidak'] = 0;

        $this->db->select('poktan');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.kode_desa');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $r['daftar'] = $this->db->where(array('nama_desa' => $this->input->post('desa')))->group_by('poktan')->get('tb_petani')->num_rows();
        $r['belum'] = $r['all'] - ($r['daftar'] + $r['tidak']);
        $r['tidak'] = 0;
        echo json_encode($r);
    }

    public function PplKpR(){
        $poktan = $this->input->post('poktan');
        if ($poktan != null) {
            $this->db->join('tb_desa', 'tb_desa.kode_desa=tb_poktan.id_desa');
            $this->db->join('tb_user', 'tb_poktan.poktan=tb_user.username');
            $sql = $this->db->get_where('tb_poktan', array('poktan' => $poktan))->result();
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
            $this->db->delete('tb_poktan', array('poktan' => $this->input->post('poktan')));                
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

        $data1 = array(
                'username'          => $this->input->post('poktan'),
                'email'             => $this->input->post('email')
            );
        // $this->db->insert("tb_user", $data1);
        $this->db->update('tb_user', $data1, array('username' => $this->input->post('nama')));
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
                        $x['petani'] = $v['nama_petani'];
                    }
                    if ($v['status_ppl'] != null) {
                        $v['status_ppl'] = unserialize(base64_decode($v['status_ppl']));
                        $manager = new \Mesour\ArrayManager($v['status_ppl']);
                        $select = $manager->select();
                        $select->column('*')
                            ->where('tahun', date('Y'), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                            ->where('tahap', $v['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL);
                        $result[$k]['status_ppl'] = $select->fetch();

                        if ($result[$k]['status_ppl'] == 'false' ||$result[$k]['status_ppl'] == null ) {
                            $x['verifikasi'] = 'false';
                        } else {
                            $x['verifikasi'] = 'true';
                        }
                    } else {
                        $x['verifikasi'] = 'false';
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
                $idx = $this->db->get_where('tb_petani', array('nama_petani' => $key))->row('id_petani');
                $sql = $this->db->get_where('tb_usulan', array('id_petani' => $idx))->row('status_ppl');
                $q = $this->db->get_where('tb_petani', array('id_petani' => $idx))->row('tahap');
                $push = array('status' => 'true', 'tahap' => $q, 'tahun' => date("Y"));
                $ar = array();
                if ($sql != null) {
                    $ar = unserialize(base64_decode($sql));
                }
                array_push($ar, $push);
                $this->db->update('tb_usulan', array('status_ppl' => base64_encode(serialize($ar))), array('id_petani' => $idx));
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