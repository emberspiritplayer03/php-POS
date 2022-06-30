<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class MyLoans extends CI_Controller {

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

		$user_id = $this->session->userdata('logged_in')['user_id'];
		
		$loans_report = $this->loans_model->getLoanByUserId($user_id);

		if (!empty($loans_report)) {

			$loan_id = $loans_report[0]['loan_id'];
			$loan_date = $loans_report[0]['loan_date'];

			$payment_history = $this->loans_model->selectPaymentHistory($loan_id, $user_id, $loan_date);

			
			$data['amount_to_pay'] = $loans_report[0]['balance'];
			$data['loan_data'] = $loans_report[0];	
			$data['payment_history'] = $payment_history;
		}

		$data['page'] = 'myloans';
		$data['session_array'] = $this->session->userdata('logged_in');


		$this->load->view('membersite/my_loans', $data);
	}

	private function computeAmountToPay(array $loanData)
	{
		$amountToPay = 0;
		//var_export($loanData['is_expired']); exit;

		if ($loanData['is_expired'] != true) {
			// 1.2 percent if the loan is not expired
			$profit_percent = 1.2 / 100;
			$profit = $profit_percent * $loanData['original_loan_amount'];
			// now add the interest to the original loan amount
			$amountToPay = $loanData['original_loan_amount'] + $profit;
		} else {
			// 3 percent if the loan is expired
			$profit_percent = 3 / 100;
			$profit = $profit_percent * $loanData['balance'];
			// add
			$amountToPay = $loanData['balance'] + $profit;
		}

		return $amountToPay;
		
	}


}