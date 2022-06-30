<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Admins extends CI_Controller {

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

		
		$data['admins'] = $this->user_model->showAdmins();

		$data['session_array'] = $this->session->userdata('logged_in');
		$data['page'] = 'admins';


		$this->load->view('admindashboard/admin_page.php', $data);
	}

	public function addAdmin()
	{
		$userName = $this->input->post('userName');
		$password = $this->input->post('password');
		$lastName = $this->input->post('lastName');
		$middleName = $this->input->post('middleName');
		$firstName = $this->input->post('firstName');		
		$gender = $this->input->post('gender');

			$adminData = array(
				'last_name' => $lastName,
				'middle_name' => $middleName,
				'first_name' => $firstName,
				'gender' => $gender,
				'username' => $userName,
				'password' => $password
			);

			$result = $this->user_model->addAdmin($adminData);

			echo json_encode($result);
	}

	public function checkIfUsernameExist()
	{
		$userName = $this->input->post('username');

		echo $this->user_model->checkIfUsernameExist($userName);
	}

	public function fetchSingleAdmin($user_id)
	{
		$result = $this->user_model->fetchSingleAdmin($user_id);

		echo json_encode($result[0]);
	}


	public function editAdmin()
	{
		$userName = $this->input->post('userName');
		$password = $this->input->post('password');
		$lastName = $this->input->post('lastName');
		$middleName = $this->input->post('middleName');
		$firstName = $this->input->post('firstName');		
		$gender = $this->input->post('gender');
		$user_id = $this->input->post('user_id');

		$adminData = array(
			'last_name' => $lastName,
			'middle_name' => $middleName,
			'first_name' => $firstName,
			'gender' => $gender,
			'username' => $userName,
			'password' => $password
		);

		$result = $this->user_model->editAdmin($adminData, $user_id);

		echo json_encode($result);
	}
}