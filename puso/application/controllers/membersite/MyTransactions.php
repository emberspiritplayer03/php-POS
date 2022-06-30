<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class MyTransactions extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('transactions_model');
	}

	public function index()
	{
		if ($this->session->userdata('logged_in') == NULL)
		{
			redirect('login');
		}

		$data['session_array'] = $this->session->userdata('logged_in');

		$user_id = $this->session->userdata('logged_in')['user_id'];

		$transaction_codes = $this->transactions_model->getConfirmationCodeById($user_id);

		$credit_transaction_codes = $this->transactions_model->getCreditConfirmationCodeById($user_id);

		$data['page'] = 'mytrans';
		$data['transaction_codes'] = $transaction_codes;
		$data['credit_transaction_codes'] = $credit_transaction_codes;


		$this->load->view('membersite/my_transactions', $data);
	}

	public function getTransactionsByCode()
	{
		$confirmation_code = $this->input->post('code');

		$result = $this->transactions_model->getTransactionsByCode($confirmation_code);

		echo json_encode($result);
	}

	public function getTotalAmountbyCode()
	{
		$confirmation_code = $this->input->post('code');

		$result = $this->transactions_model->getTotalAmountbyCode($confirmation_code);
		
		echo json_encode($result);
	}
}