<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$this->load->view('register');
	}

	public function compareMember()
	{
		$lastName = $this->input->post('lastName');
		$middleName = $this->input->post('middleName');
		$firstName = $this->input->post('firstName');

		$result = $this->user_model->fetchMember($lastName, $middleName, $firstName);

		echo json_encode($result);
	}
}