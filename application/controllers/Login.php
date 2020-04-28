<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function index()
	{
		$email = $this->input->post('email');
		$pass = $this->input->post('password');
		if(isset($email) && isset($pass)){
			$sql = $this->db->get_where('tb_user', array('email' => $email, 'password' => $pass))->row();
			if(isset($sql)) {
				$response["value"] = 1;
				$response["message"] = "login berhasil";
				$response["username"] = $sql->username;
				$response["level"] = $sql->level;
				echo json_encode($response);
			} else {
				$response["value"] = 0;
				$response["message"] = "login gagal";
				echo json_encode($response);
			}
		} else {
			$response["value"] = 2;
			if(!isset($email)) $em = "email";
			if(!isset($pass)) $ps = "password";
			$response["message"] = "data kosong";
			echo json_encode($response);

		}
	}
}
