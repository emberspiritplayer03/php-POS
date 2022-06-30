<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Transactions extends CI_Controller {

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
		$data['page'] = 'transactions';

		$this->load->view('admindashboard/record_transactions', $data);
	}

	public function getProductDetailsByName()
	{
		$product = $this->input->post('product');

		$result = $this->transactions_model->getProductDetailsByName($product);

		if (empty($result)) {
			echo "0";
		} else {
			echo json_encode($result[0]);
		}

	}

	/**
	 *	Insert an item to temporary transaction table
	 * 
	 */
	public function insertProduct()
	{
		$prod_id = $this->input->post('prod_id');	
		$prod_code = $this->input->post('prod_code');	
		$quantity = $this->input->post('quantity');	
		$user_id = $this->input->post('user_id');	
		$price = $this->input->post('price');

		$checkTemp = $this->transactions_model->getTemporaryTable();

		$confirmation_code = $this->transactions_model->generateConfirmationCode();

		$amount = $quantity * $price;

		$product_stock = $this->transactions_model->getStockbyProdId($prod_id);

		$productData = array (
			'prod_id' => $prod_id,
			'product_code' => $prod_code,
			'price' => $price,
			'quantity' => $quantity,
			'amount' => $amount,
			'user_id' => $user_id,
			'confirmation_code'=> (empty($checkTemp) ? $confirmation_code : $this->transactions_model->fetchExistingCode())
		);

		if ($this->hasEnoughStock($product_stock[0]['stock'], $quantity)) {
			$result = $this->transactions_model->addToTemporaryTable($productData);
		}
		else {
			$result = "not enough stock";
		}

		echo json_encode($result);
	}

	private function hasEnoughStock($stock, $quantity)
	{
		if ($quantity > $stock) {
			return false;
		}

		return true;
	}

	public function getTemporaryTable()
	{
		$result = $this->transactions_model->getTemporaryTable();

		echo json_encode($result);
	}

	public function removeItem($id)
	{
		$result = $this->transactions_model->deleteItem($id);

		if ($result == true)
		{
			self::getTemporaryTable();
		}
	}

	public function getTotalAmount()
	{
		$result = $this->transactions_model->totalTempAmount();

		echo json_encode($result);
	}

	public function saveTransaction()
	{
		$is_credit = $this->input->post('is_credit');
		$credit_value = false;		

		if ($is_credit == "Yes") {
			$credit_value = true;
		}

		$result = $this->transactions_model->saveTransaction();
		$delete = false;
		
		if ($result == true)
		{
			$temp_transData = $this->transactions_model->getTemporaryTable();

			if ($credit_value) {
				$this->transactions_model->saveCreditTransaction($credit_value, $temp_transData[0]['confirmation_code']);
			}

			$update = $this->updateStock($temp_transData);

			$delete = $this->transactions_model->deleteTempTrans();

			echo json_encode($delete);

		}
	}

	public function checkIfHasCredit()
	{
		$user_id = $this->input->post('user_id');

		$result = $this->transactions_model->checkIfHasCredit($user_id);

		//var_export($result); exit;

		echo json_encode($result);
	}

	public function deleteTempTrans()
	{
		echo json_encode($this->transactions_model->deleteTempTrans());
	}

	private function updateStock(array $temp_transData)
	{
		foreach($temp_transData as $trans) 
		{
			$this->transactions_model->updateStock($trans['prod_id'], $trans['quantity']);
		}

	}

	public function getMemberbyCode()
	{
		$code = $this->input->post('code');

		$result = $this->transactions_model->getMemberbyCode($code);

		if ($result)
			echo json_encode($result[0]);
		else 
			echo "false";
	}

	public function payCredit()
	{
		$user_id = $this->input->post('user_id');
		$payment = $this->input->post('payment');
		$amountToPay = $this->input->post('amountToPay');
		$transDate = $this->input->post('transDate');

		if ($payment == $amountToPay) {

			$result = $this->transactions_model->payCreditById($user_id, $transDate);

			echo json_encode($result);
		}

		
	}

	public function selectCreditDetails()
	{
		$user_id = $this->input->post('user_id');

		$result = $this->transactions_model->selectCreditDetails($user_id);

		if ($result[0]['total_amount'] == null && $result[0]['transaction_date'] == null && $result[0]['confirmation_code'] == null) {
			echo "0";
		}
		else {
			echo json_encode($result[0]);
		}

	}



}