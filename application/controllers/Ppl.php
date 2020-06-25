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
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.kode_desa');
        $this->db->where(Array('nama_desa' => $this->input->post('desa')));
        $this->db->group_by('poktan');
        $r['all'] = $this->db->get()->num_rows();
        $r['daftar'] = 0;
        $r['belum'] = 0;
        $r['tidak'] = 0;

        $this->db->select('*')->from('tb_petani');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.kode_desa');
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
        $this->db->select('*');
        $this->db->from('tb_petani');
        $this->db->join('tb_usulan', 'tb_petani.id_petani = tb_usulan.id_petani');
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join('tb_desa', 'tb_desa.kode_desa = tb_poktan.id_desa');
        $this->db->where(Array('nama_desa' => $this->input->post('poktan')));
        $sql = $this->db->get()->result_array();
        for ($i=0; $i < count($sql); $i++) {
            if ($sql[$i]['m1'] != null && $sql[$i]['m1'] != 'false') $sql[$i]['m1'] = unserialize(base64_decode($sql[$i]['m1']));
            if ($sql[$i]['m2'] != null && $sql[$i]['m2'] != 'false') $sql[$i]['m2'] = unserialize(base64_decode($sql[$i]['m2']));
            if ($sql[$i]['m3'] != null && $sql[$i]['m3'] != 'false') $sql[$i]['m3'] = unserialize(base64_decode($sql[$i]['m3']));
            
            if ($sql[$i]['status_poktan'] != null) {
                $sql[$i]['status_poktan'] = unserialize(base64_decode($sql[$i]['status_poktan']));
            }
            if ($sql[$i]['status_ppl'] != null) {
                $sql[$i]['status_ppl'] = unserialize(base64_decode($sql[$i]['status_ppl']));
            }

        }
        echo json_encode($sql);
    }

}