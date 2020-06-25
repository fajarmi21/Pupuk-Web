<?php
defined('BASEPATH') or exit('No direct script access allowed');
define('VENDOR', substr(FCPATH, 0, strpos(APPPATH, 'application/')) . "vendor/");
require VENDOR . 'autoload.php';


class Petani extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function index()
    {
        // $this->db->join("tb_usulan", "tb_petani.id_petani = tb_usulan.id_petani");
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join("tb_desa", "tb_poktan.id_desa = tb_desa.kode_desa");
        $this->db->where(array('nama_petani' => $this->input->post('nama_petani')));
        $sql = $this->db->get("tb_petani")->row_array();
        $q = $this->db->get_where('tb_usulan', array('id_petani' => $sql['id_petani']))->row_array();
        if ($q != null) {
            $sql = array_merge($sql, $q);
            if ($sql != null) {
                if ($sql['m1'] != null && $sql['m1'] != 'false') $sql['m1'] = unserialize(base64_decode($sql['m1']));
                if ($sql['m2'] != null && $sql['m2'] != 'false') $sql['m2'] = unserialize(base64_decode($sql['m2']));
                if ($sql['m3'] != null && $sql['m3'] != 'false') $sql['m3'] = unserialize(base64_decode($sql['m3']));
                if ($sql['status_poktan'] != null && $sql['status_poktan'] != 'false') {
                    $sql['status_poktan'] = unserialize(base64_decode($sql['status_poktan']));
                }
            }
        }
        echo json_encode($sql);
    }

    public function usulan()
    {
        $this->db->trans_begin();
        $id = $this->db->get_where("tb_petani", array('nama_petani' => $this->input->post('petani')))->row();
        $usul = $this->db->get_where("tb_usulan", array('id_petani' => $id->id_petani))->row();
        $ar = array(
            'sektor' => $this->input->post('sektor'),
            'luas' => $this->input->post('luas'),
            'urea' => $this->input->post('urea'),
            'sp36' => $this->input->post('sp36'),
            'za' => $this->input->post('za'),
            'npk' => $this->input->post('npk'),
            'organik' => $this->input->post('organik'),
            'date' => $this->input->post('date'),
        );
        if ($usul != null) {
            $tahap = array();
            $thp = $this->input->post('tahap');
            if ($usul->$thp != null) {
                // if ($usul->$thp == 'false') {
                //     array_push($tahap, 'false');
                //     array_push($tahap, $ar);
                // } else {
                //     array_push($tahap, unserialize(base64_decode($usul->$thp)));
                //     array_push($tahap, $ar);
                // }
                $tahap = unserialize(base64_decode($usul->$thp));
                array_push($tahap, $ar);
            } else {
                array_push($tahap, $ar);
            }
            $input =  array(
                $this->input->post('tahap') => base64_encode(serialize($tahap)),
                'status_poktan' => null,
                'status_ppl' => null,
                'status_admin' => null,
            );
            $this->db->update('tb_usulan', $input, array('id_petani' => $id->id_petani));
        } else {
            $last = $this->db->select('SUBSTRING(id_usulan, 2) as id', FALSE)
                ->order_by('id_usulan', "desc")
                ->limit(1)
                ->get('tb_usulan')
                ->row('id');
            switch (true) {
                case ($last < 9):
                    $e = 'U00' . ($last + 1);
                    break;
                case ($last < 99):
                    $e = 'U0' . ($last + 1);
                    break;
                default:
                    $e = 'U' . ($last + 1);
                    break;
            }

            $array = array(
                'id_usulan' => $e,
                'id_petani' => $id->id_petani,
                $this->input->post('tahap') => base64_encode(serialize(array($ar)))
            );
            $this->db->insert('tb_usulan', $array);
        }
        $this->db->update('tb_petani', array('tahap' => $this->input->post('tahap')), array('nama_petani' => $this->input->post('petani')));
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

    public function usulanR()
    {
        $id = $this->db->get_where("tb_petani", array('nama_petani' => $this->input->post('petani')))->row();
        $usul = $this->db->get_where("tb_usulan", array('id_petani' => $id->id_petani))->row();
        $tahap = array();
        $thp = $id->tahap;
        $tahap = unserialize(base64_decode($usul->$thp));
        $tahap = end($tahap);
        // $tx = array("luas_lahan" => $id->luas_lahan);
        $tahap["luas_lahan"] = $id->luas_lahan;
        echo json_encode($tahap);
    }

    public function usulanU()
    {
        $this->db->trans_begin();
        $id = $this->db->get_where("tb_petani", array('nama_petani' => $this->input->post('petani')))->row();
        $usul = $this->db->get_where("tb_usulan", array('id_petani' => $id->id_petani))->row();
        $arF = array(
            'sektor' => $this->input->post('sektor'),
            'luas' => $this->input->post('luas'),
            'urea' => $this->input->post('urea'),
            'sp36' => $this->input->post('sp36'),
            'za' => $this->input->post('za'),
            'npk' => $this->input->post('npk'),
            'organik' => $this->input->post('organik'),
            'date' => $this->input->post('date'),
        );
        $tahap = array();
        $thp = $id->tahap;
        $tahap = unserialize(base64_decode($usul->$thp));
        $x = array_search($this->input->post('dateF'), array_column($tahap, 'date'));
        $tahap[$x] = $arF;
        $this->db->update('tb_usulan', array($thp => base64_encode(serialize($tahap))), array('id_petani' => $id->id_petani));
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

    public function sektor()
    {
        echo json_encode($this->db->select('nama_tanaman')->get('tb_sektor')->result());
    }

    public function rekap()
    {
        $this->db->join("tb_usulan", "tb_petani.id_petani = tb_usulan.id_petani");
        $this->db->join("tb_desa", "tb_petani.id_desa = tb_desa.kode_desa");
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->where(array('nama_petani' => $this->input->post('nama_petani')));
        $sql = $this->db->get("tb_petani")->row();
        if ($sql->m1 != null && $sql->m1 != 'false') $sql->m1 = unserialize(base64_decode($sql->m1));
        if ($sql->m2 != null && $sql->m2 != 'false') $sql->m2 = unserialize(base64_decode($sql->m2));
        if ($sql->m3 != null && $sql->m3 != 'false') $sql->m3 = unserialize(base64_decode($sql->m3));
        // $x = array();
        // array_push($sql->m1, 'false');
        // array_push($x, $sql->m1);
        // $sql->m1 = $x;
        echo json_encode($sql);
    }

    public function uji()
    {
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->join("tb_desa", "tb_poktan.id_desa = tb_desa.kode_desa");
        $this->db->where(array('nama_petani' => $this->input->post('nama_petani')));
        $sql = $this->db->get("tb_petani")->row_array();
        $q = $this->db->get_where('tb_usulan', array('id_petani' => $sql['id_petani']))->row_array();
        if ($q != null) {
            $sql = array_merge($sql, $q);
            if ($sql != null) {
                if ($sql['m1'] != null && $sql['m1'] != 'false') $sql['m1'] = unserialize(base64_decode($sql['m1']));
                if ($sql['m2'] != null && $sql['m2'] != 'false') $sql['m2'] = unserialize(base64_decode($sql['m2']));
                if ($sql['m3'] != null && $sql['m3'] != 'false') $sql['m3'] = unserialize(base64_decode($sql['m3']));
                if ($sql['status_poktan'] != null && $sql['status_poktan'] != 'false') {
                    $sql['status_poktan'] = unserialize(base64_decode($sql['status_poktan']));
                }
            }
        }

        $manager = new \Mesour\ArrayManager($sql['status_poktan']);
        $select = $manager->select();

        //set keys sensitive to TRUE (default is FALSE)
        \Mesour\ArrayManage\Searcher\Condition::setKeysSensitive();

        $select->column('*')->where('1', '2020', \Mesour\ArrayManage\Searcher\Condition::EQUAL)->limit(4);

        print_r($select->fetch());
    }
}
