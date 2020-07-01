<?php
defined('BASEPATH') or exit('No direct script access allowed');
define('VENDOR', substr(FCPATH, 0, strpos(APPPATH, 'application/')) . "vendor/");
require VENDOR . 'autoload.php';

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function index()
    {
        $this->db->trans_begin();
            $this->db->join("tb_usulan", "tb_petani.id_petani = tb_usulan.id_petani");
            $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
            $this->db->join("tb_desa", "tb_poktan.id_desa = tb_desa.kode_desa");
            $this->db->where(array('status_ppl !=' => null));
            $sql = $this->db->get("tb_petani")->result_array();
            $s['luas'] = 0;

            if ($sql != null) {
                foreach ($sql as $k => $v) {
                    if ($v[$v['tahap']] != null) {
                        $v[$v['tahap']] = unserialize(base64_decode($v[$v['tahap']]));
                        $v['status_ppl'] = unserialize(base64_decode($v['status_ppl']));

                        $manager = new \Mesour\ArrayManager($v[$v['tahap']]);
                        $select = $manager->select();
                        $select->column('*', 'date')->orderBy('date', 'DESC');
                        $sql[$k][$v['tahap']] = $select->fetchAll();

                        $manager = new \Mesour\ArrayManager($v['status_ppl']);
                        $select = $manager->select();
                        $select->column('*')
                            ->where('tahun', date('Y'), \Mesour\ArrayManage\Searcher\Condition::EQUAL, 'and')
                            ->where('tahap', $v['tahap'], \Mesour\ArrayManage\Searcher\Condition::EQUAL);
                        $sql[$k]['status_ppl'] = $select->fetch();

                        if ($sql[$k]['status_ppl'] != false) {
                            $s['luas'] += $sql[$k][$v['tahap']][0]['luas'];
                            $x['tahap'] = $v['tahap'];
                            $x['luas'] = $sql[$k][$v['tahap']][0]['luas'];
                            $x['id_petani'] = $v['id_petani'];
                            $s['usul'][] = $x;
                        }
                    }
                }
                if ($sql[$k]['status_ppl'] != false) {
                    $s['hektar']['urea'] = $this->input->post('urea') / ($s['luas'] / 0.01);
                    $s['hektar']['sp36'] = $this->input->post('sp36') / ($s['luas'] / 0.01);
                    $s['hektar']['za'] = $this->input->post('za') / ($s['luas'] / 0.01);
                    $s['hektar']['npk'] = $this->input->post('npk') / ($s['luas'] / 0.01);
                    $s['hektar']['organik'] = $this->input->post('organik') / ($s['luas'] / 0.01);
                }

                foreach ($s['usul'] as $k) {
                    $ar = array();
                    $push = array(
                        'status' => 'true',
                        'tahap' => $k['tahap'],
                        'tahun' => date("Y"),
                        'verifikasi' => array(
                            'urea' => $k['luas'] * $s['hektar']['urea'],
                            'sp36' => $k['luas'] * $s['hektar']['sp36'],
                            'za' => $k['luas'] * $s['hektar']['za'],
                            'npk' => $k['luas'] * $s['hektar']['npk'],
                            'organik' => $k['luas'] * $s['hektar']['organik']
                        )
                    );
                    $sql = $this->db->get_where('tb_usulan', array('id_petani' => $k['id_petani']))->row('status_admin');
                    if ($sql != null) {
                        $ar = unserialize(base64_decode($sql));
                    }
                    array_push($ar, $push);
                    // print_r($ar);
                    $this->db->update('tb_usulan', array('status_admin' => base64_encode(serialize($ar))), array('id_petani' => $k['id_petani']));
                }
            }
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $r['status'] = 'sukses';
        } else {
            $this->db->trans_rollback();
            $r['status'] = 'error';
        }

        echo json_encode($r);
    }
}