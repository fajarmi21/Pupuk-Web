<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petani extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function index()
	{
        $sql = $this->db->get_where("tb_petani", array('nama_petani' => $this->input->post('nama_petani')))->row();
        // $sql = $this->db->get('petani')->result();
        // $record = Array();
        // foreach ($sql as $row) {
        //     $r = Array();
        //     $r['name'] = $row->nama_petani;
        //     $r['sektor'] = $row->sektor;
        //     $record[] = $r;
        // }
        // echo json_encode($record);
        // if(isset($sql)) {
        //     $response["value"] = 1;
        //     $response["message"] = "login berhasil";
        //     $response["level"] = $sql->level;
        //     echo json_encode($response);
        // } else {
        //     $response["value"] = 0;
        //     $response["message"] = "login gagal";
            echo json_encode($sql);
        // }
    }
}