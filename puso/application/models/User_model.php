<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class User_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
	}

	public function getAllUsers()
	{
		$this->db->select('user_id, last_name, middle_name, first_name, address, gender, username');
		$this->db->where('is_admin', 0);

		$query = $this->db->get('users'); 

		return $query->result_array();
	}

	public function getSingleUser($userId)
	{
		$this->db->select('user_id, last_name, middle_name, first_name, address, gender, username');
		$this->db->where('user_id', $userId);

		$query = $this->db->get('users');

		return $query->result_array();

	}

	public function addUser($memberData)
	{
		$this->db->set('date_created', 'NOW()', false);
		
		return $this->db->insert('users', $memberData);

	}

	public function editUser($memberData, $userId)
	{
		$this->db->where('user_id', $userId);
		return $this->db->update('users', $memberData);
	}

	public function deleteUser($userId)
	{
		$this->db->where('user_id', $userId);
		return $this->db->delete('users'); 
	}

	public function getLastId()
	{
		$last_row = $this->db->select('user_id')->order_by('user_id',"desc")->limit(1)->get('users')->row();

		$array = json_decode(json_encode($last_row), true);
		
		return $array['user_id'];
	}

	public function searchMember($search)
	{
		$this->db->select('*');
		$where = "(last_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR first_name LIKE '%$search%' OR address LIKE '%$search%' OR username LIKE '%$search%')";
		$this->db->where($where);
		$this->db->where('is_admin', false);
		$query = $this->db->get('users');

		return $query->result_array();

	}

	/**
	 *	function used in registration of existing members in the database
	 *	compares the entries to the records
	 * 	@param string lastName
	 *	@param string middleName
	 * 	@param string firstName
	 * 	@return array memberData
	 */
	public function fetchMember($lastName, $middleName, $firstName)
	{
		$this->db->select('user_id, last_name, middle_name, first_name, username, password');
		$this->db->where('last_name', $lastName);
		$this->db->where('middle_name', $middleName);
		$this->db->where('first_name', $firstName);

		$query = $this->db->get('users');

		return $query->result_array();
	}

	public function checkLogin($username, $password)
	{
		$this->db->select('*');
		$this->db->where("BINARY username = '$username'", null, false);
		$this->db->where("BINARY password = '$password'", null, false);
		$query = $this->db->get('users');

		return $query->result_array();

	}


	/** 
	 * Admin codes *
	**/

	public function showAdmins()
	{
		$this->db->select('user_id, last_name, middle_name, first_name, address, gender, username');
		$this->db->where('is_admin', 1);

		$query = $this->db->get('users'); 

		return $query->result_array();
	}

	public function addAdmin(array $adminData)
	{
		$this->db->set('date_created', 'NOW()', false);
		$this->db->set('is_admin', 1);
		$this->db->set('address', "Philippine Urban Solidarity Organization");

		return $this->db->insert('users', $adminData);

	}

	public function checkIfUsernameExist($userName)
	{
		$user_data = $this->db->from('users')->where('username', $userName)->get();

		return $user_data->num_rows();
	}

	public function fetchSingleAdmin($userId)
	{
		$this->db->select('user_id, last_name, middle_name, first_name, address, gender, username, password');
		$this->db->where('user_id', $userId);
		$this->db->where('is_admin', true);

		$query = $this->db->get('users');

		return $query->result_array();
	}


	public function editAdmin(array $adminData, $user_id)
	{
		$this->db->where('user_id', $user_id);

		return $this->db->update('users', $adminData);
	}

	
}