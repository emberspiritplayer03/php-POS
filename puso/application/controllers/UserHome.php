<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class UserHome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
	} 	

	public function index()
	{
		if ($this->session->userdata('logged_in') == NULL)
		{
			redirect('login');
		}

		$data['session_array'] = $this->session->userdata('logged_in');
		$data['page'] = "userhome";

		$this->load->view('membersite/user_home', $data);
	}


}