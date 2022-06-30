<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Loans extends CI_Controller {


	public function __construct()
    {
        parent::__construct();
        $this->load->model('loans_model');
	}

	public function index() 
	{	
		if ($this->session->userdata('logged_in') == NULL)
		{
			redirect('login');
		}

		if ($this->session->userdata('logged_in')['is_admin'] == 0)
		{
			redirect('login');
		}
		
		$loan_records = $this->loans_model->getAllLoans();	

		foreach ($loan_records as $loans)
		{
			$this->loans_model->updateLoanExpired($loans['loan_deadline'], $loans['loan_id']);
		
		}

		$newloan_records = $this->loans_model->getAllLoans();

		$data['page'] = 'loans';
		$data['session_array'] = $this->session->userdata('logged_in');
		$data['loan_records'] = $newloan_records;

		$this->load->view('admindashboard/record_loan', $data);
	}

	public function addLoan()
	{
		$userId = $this->input->post('userId');
		$loanAmount = $this->input->post('loanAmount');

		if (!$this->checkIfMemberExist($userId)) {
			echo "Member not found";
		}
		elseif ($this->loans_model->hasExistingLoan($userId)) {
			echo "Member has existing loan";
		}
 		else {
 			$loanData = array (
				'user_id' => $userId,
				'original_loan_amount' => $loanAmount,
				'last_payment' => 0.00,
				'balance' => $this->computeBalance($loanAmount),
				'status' => 'NOT PAID'
			);

			$result = $this->loans_model->addLoan($loanData);

			echo json_encode($result);
 		}
		
	}

	public function selectSingleLoan($loanId)
	{
		$result = $this->loans_model->getSingleLoan($loanId);

		echo json_encode($result[0]);

	}

	public function editLoan()
	{
		$loanId = $this->input->post('loanId');
		$userId = $this->input->post('user_id');
		$lastPayment = $this->input->post('lastPayment');
		$loanDate = $this->input->post('loanDate');

		$loanAmount = $this->input->post('loanAmount');
		$balance = $this->input->post('balance');
		

		$status = "NOT PAID";

		// deduct lastPayment from balance
		$newbalance = $balance - $lastPayment;

		if ($newbalance == 0) {
			$status = "PAID";
		}
		
		$loanData = array (
			'last_payment' => $lastPayment,
			'balance' => $newbalance,
			'status' => $status
		);

		$profitData = array (
			'loan_id' => $loanId,
			'user_id' => $userId,
			'loan_payment' => $lastPayment,
			'loan_date' => $loanDate
		);

		$result = $this->loans_model->updateLoan($loanId, $loanData);

		$profit_result = $this->loans_model->updateProfitTable($profitData);

		echo json_encode($profit_result);

	}

	/**
	 *	Updates the balance for an expired loan
	 * 	The interest becomes 3% for the remaining balance
	 */
	public function updateExpiredBalance()
	{
		$loanId = $this->input->post('loanId');
		$current_balance = $this->input->post('balance');

		$interest_percent = 3 / 100;

		$profit = $interest_percent * $current_balance;

		$newBalance = $current_balance + $profit;

		$newBalance = round($newBalance);


		$result = $this->loans_model->updateExpiredBalance($newBalance, $loanId);

		if ($result == true) {
			$balance = $this->loans_model->fetchBalance($loanId);
		}

		echo json_encode($balance[0]);
	}

	/**
	 * Adds 1.2% to the balance of a loaned amount
	 * Used for initial loans only
	 * @param double $original_loan_amount
	 * @return double $balance
	 */

	private function computeBalance($loanAmount)
	{	
		// 1.2 percent if the loan is not expired
		$profit_percent = 1.2 / 100;

		$profit = $profit_percent * $loanAmount;

		// now add the "TUBO" to the original loan amount
		$balance = $loanAmount + $profit;

		return $balance;
	}

	public function viewPayment()
	{
		$userId = $this->input->post('userId');
		$loanId = $this->input->post('loanId');

		$result = $this->loans_model->selectPaymentHistory($loanId, $userId);
		
		echo json_encode($result);
	}

	public function checkIfMemberExist($userId)
	{
		return $this->loans_model->checkIfMemberExist($userId);
	
	}

	public function searchLoan()
	{
		$search = $this->input->post('search');

		$result = $this->loans_model->searchLoan($search);

		echo json_encode($result);
	}
	

}