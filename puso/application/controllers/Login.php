<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
	}

	public function index()
	{
		if ($this->session->has_userdata('logged_in')) {
			if ($this->session->userdata('logged_in')['is_admin'] == 1) {
				redirect('welcome');
			} else {
				redirect('UserHome');
			}
		}

		$this->load->view('login');
	}

	public function checkLogin()
	{
		$username = $this->input->post('userName');
		$password = $this->input->post('password');

		$result = $this->user_model->checkLogin($username, $password);

		if (count($result) == 1)
		{
			$this->session->set_userdata('logged_in', $result[0]);
			if ($result[0]['is_admin'] == 1) {
				echo 'admin';
			} else {
				echo 'user';
			}
		} 
		else {
			echo "0";
		}

	}
}