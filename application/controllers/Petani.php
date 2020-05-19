<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petani extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function index()
	{
        $this->db->join("tb_usulan", "tb_petani.id_petani = tb_usulan.id_petani");
        $this->db->join("tb_desa", "tb_petani.id_desa = tb_desa.kode_desa");
        $this->db->join('tb_poktan', 'tb_petani.id_kelompok = tb_poktan.id_poktan');
        $this->db->where(array('nama_petani' => $this->input->post('nama_petani')));
        $sql = $this->db->get("tb_petani")->row();
        if ($sql->m1 != null && $sql->m1 != 'false') $sql->m1= unserialize(base64_decode($sql->m1));
        if ($sql->m2 != null && $sql->m2 != 'false') $sql->m2= unserialize(base64_decode($sql->m2));
        if ($sql->m3 != null && $sql->m3 != 'false') $sql->m3= unserialize(base64_decode($sql->m3));
        echo json_encode($sql);
    }
}