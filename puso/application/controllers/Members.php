<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Members extends CI_Controller {

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
		$data['test'] = $this->user_model->getAllUsers();
		$data['page'] = 'members';
		
		$this->load->view('admindashboard/record_member', $data);
	}

	public function add()
	{
		$lastName = $this->input->post('lastName');
		$middleName = $this->input->post('middleName');
		$firstName = $this->input->post('firstName');
		$address = $this->input->post('address');
		$gender = $this->input->post('gender');

		
		$last_id = $this->user_model->getLastId();

		$member_code = $this->generateMemberCode($last_id, $firstName, $lastName);

		$memberData = array(

			'last_name' => $lastName,
			'middle_name' => $middleName,
			'first_name' => $firstName,
			'address' => $address,
			'gender' => $gender,
			'username' => $member_code,
			'password' => $lastName,
			'is_admin' => false
		);

		$result = $this->user_model->addUser($memberData);

		echo json_encode($result);

	}

	public function editMember() 
	{
		$lastName = $this->input->post('lastName');
		$middleName = $this->input->post('middleName');
		$firstName = $this->input->post('firstName');
		$address = $this->input->post('address');
		$gender = $this->input->post('gender');
		$userId = $this->input->post('user_id');

		$memberData = array(
			'last_name' => $lastName,
			'middle_name' => $middleName,
			'first_name' => $firstName,
			'address' => $address,
			'gender' => $gender
		);

		$result = $this->user_model->editUser($memberData, $userId);

		echo json_encode($result);

	}

	public function selectSingle($userId)
	{
		$result = $this->user_model->getSingleUser($userId);
		echo json_encode($result[0]);
	}

	public function deleteMember($userId)
	{
		$result = $this->user_model->deleteUser($userId);
		echo json_encode($result);
	}

	private function generateMemberCode($last_user_id, $fName, $lName)
	{
		$id_no = $last_user_id + 1;
		$company_code = 'PUSO';
		$firstChar = $fName[0];
		$secondChar = $lName[0];

		return strtoupper($company_code.'-'.$firstChar.$secondChar.'-'.$id_no);

	}

	public function searchMember()
	{
		$search = $this->input->post('search');
	
		$result = $this->user_model->searchMember($search);

		echo json_encode($result);
	}

}