<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function index()
	{
		$email = $this->input->post('email');
		$pass = $this->input->post('password');
		if(isset($email) && isset($pass)){
			$sql = $this->db->get_where('user', array('email' => $email, 'password' => $pass))->row();
			if(isset($sql)) {
				$response["value"] = 1;
				$response["message"] = "login berhasil";
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
			$response["message"] = "data $em $ps kosong";
			echo json_encode($response);

		}
	}
}
