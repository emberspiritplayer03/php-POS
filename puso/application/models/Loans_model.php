<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Loans_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
	}

	public function getAllLoans()
	{
		$this->db->select('u.user_id, u.last_name, u.middle_name, u.first_name, u.username, l.loan_id, l.original_loan_amount, l.loan_date, l.loan_deadline, l.is_expired, l.balance, l.last_payment, l.last_payment_date, l.status', false);
		$this->db->order_by('l.loan_id', 'asc');
		$this->db->from('users as u');
		$this->db->join('loans as l', 'u.user_id = l.user_id');
		$query = $this->db->get(); 

		return $query->result_array();
	}

	public function searchLoan($search)
	{
		$this->db->select('u.user_id, u.last_name, u.middle_name, u.first_name, u.username, l.loan_id, l.original_loan_amount, l.loan_date, l.loan_deadline, l.is_expired, l.balance, l.last_payment, l.last_payment_date, l.status', false);
		
		$this->db->from('users as u');
		$this->db->join('loans as l', 'u.user_id = l.user_id');

		if ($search != '') {
			$this->db->or_like('u.last_name', $search);
			$this->db->or_like('u.middle_name', $search);
			$this->db->or_like('u.first_name', $search);
			$this->db->or_like('u.user_id', $search);
			$this->db->or_like('l.original_loan_amount', $search);
		}
	
		$query = $this->db->get();

		return $query->result_array();
	}

	public function addLoan($loanData)
	{
		$this->db->set('loan_date', 'NOW()', false);
		$this->db->set('loan_deadline', 'NOW() + INTERVAL 1 MONTH', false);
		return $this->db->insert('loans', $loanData);
	}

	public function getSingleLoan($loanId)
	{
		$this->db->select('u.user_id, u.last_name, u.middle_name, u.first_name, u.username, l.loan_id,l.original_loan_amount, l.loan_date, l.loan_deadline, l.is_expired, l.balance, l.last_payment, l.last_payment_date, l.status', false);
		$this->db->from('users as u');
		$this->db->join('loans as l', 'u.user_id = l.user_id');
		$this->db->where('loan_id', $loanId);
		$query = $this->db->get(); 

		return $query->result_array();
	}

	public function updateLoan($loanId, $loanData)
	{	
		$this->db->set('last_payment_date', 'NOW()', false);
		$this->db->where('loan_id', $loanId);
		return $this->db->update('loans', $loanData);
	}

	public function updateLoanExpired($loan_deadline, $loanId)
	{
		$dateToday = new DateTime();
		$loan_deadline = new DateTime($loan_deadline);
		$interval = $dateToday->diff($loan_deadline);

		if ($interval->days == 0) {

			$data = array('is_expired' => true);
			$this->db->where('loan_id', $loanId);
			$this->db->update('loans', $data);
		}
	}

	/**
	 *	Recomputes the balance for expired loans
	 * 	The interest becomes 3% instead of 1.2$
	 * 	@param double $balance
	 *	@return double $newBalance
	 */

	public function updateExpiredBalance($balance, $loanId)
	{
		$data = array (
			'balance' => $balance,
			'is_expired' => false
		); // update data

		//$where_array = array ('loan_id' => $loanId); // condition if loan is expired
		$this->db->set('loan_deadline', 'NOW() + INTERVAL 1 MONTH', false);

		$this->db->where('loan_id', $loanId);

		return $this->db->update('loans', $data);
		
	}

	public function fetchBalance($loanId)
	{
		$this->db->select('balance', 'loan_deadline');
		$this->db->from('loans');
		$this->db->where('loan_id', $loanId);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function updateProfitTable($profitData)
	{
		$this->db->set('date_received', 'NOW()', false);
		
		return $this->db->insert('profits', $profitData);
		
	}

	public function selectPaymentHistory($loanId, $userId, $loanDate)
	{
		$this->db->select('loan_payment, date_received');
		$this->db->from('profits');
		$this->db->where('loan_id', $loanId);
		$this->db->where('user_id', $userId);
		$this->db->where('loan_date', $loanDate);
		$query = $this->db->get(); 
		
		return $query->result_array();
	}

	public function checkIfMemberExist($userId)
	{
		$user_data = $this->db->from('users')->where('user_id', $userId)->get();

		return $user_data->num_rows();
	}

	public function getLoanByUserId($userId)
	{
		$this->db->select('*');
		$this->db->where('user_id', $userId);

		$query = $this->db->get('loans');

		return $query->result_array();
	}

	public function hasExistingLoan($userId)
	{
		$this->db->where('user_id', $userId);
		$this->db->where('status', "NOT PAID");
		$query = $this->db->get('loans');

		if( $query->num_rows() > 0) {
			return true;
		}

		return false;
	}

	//query for getting total profit
	//	select sum(l.original_loan_amount) as total_loans, SUM(p.loan_payment) as total_profits from loans l join profits p where l.loan_id = p.id;


}