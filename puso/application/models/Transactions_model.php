<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Transactions_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
	}

	public function addToTemporaryTable(array $productData)
	{
		return $this->db->insert('temp_transaction', $productData);
	}

	public function getStockbyProdId($prodId)
	{
		$this->db->select('stock');
		$this->db->where('prod_id', $prodId);
		$query = $this->db->get('products');

		return $query->result_array();
	}

	public function getProductDetailsByName($productName)
	{
		if ($productName == "") {
			return array();
		}

		$this->db->select('*');
		$where = "(product_code LIKE '%$productName%' OR prod_name LIKE '%$productName%')";
		$this->db->where($where);
		$this->db->where('is_deleted', false);
		$query = $this->db->get('products');

		return $query->result_array();
	}

	private function getProductById($prod_id)
	{
		$this->db->select('*');
		$this->db->where('is_deleted', false);
		$this->db->where('prod_id', $prod_id);
		$query = $this->db->get('products');

		return $query->result_array();
	}

	public function getTemporaryTable()
	{
		$this->db->select('*');
		$query = $this->db->get('temp_transaction');

		return $query->result_array();
	}

	public function deleteItem($id)
	{
		$this->db->where('temp_id', $id);
		return $this->db->delete('temp_transaction'); 

	}

	public function totalTempAmount()
	{
		$this->db->select('SUM(amount) as total_amount');
		$query = $this->db->get('temp_transaction');
		$row = $query->row();
		$total_amount = $row->total_amount;

		return $total_amount;
	}

	public function saveTransaction()
	{
		return $this->db->query('INSERT INTO transactions (prod_id, product_code, price, quantity, amount, user_id, confirmation_code) SELECT prod_id, product_code, price, quantity, amount, user_id, confirmation_code FROM temp_transaction');
	}

	public function saveCreditTransaction($credit_value, $confirmation_code) 
	{

		$transData = array (
			'is_credit' => true
		);

		if ($credit_value == true) {

			$this->db->set('credit_due_date', 'NOW() + INTERVAL 1 MONTH', false);
			$this->db->where('confirmation_code', $confirmation_code);

			return $this->db->update('transactions', $transData);
		}

	}

	public function deleteTempTrans()
	{
		return $this->db->truncate('temp_transaction');
	}

	public function generateConfirmationCode()
	{

		$last_id = self::getLastId() + 1;

		//var_export(self::getLastId()); exit;

		$length = 5;
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }

	    return $randomString."-".$last_id;

	}

	private function getLastId()
	{
		$last_row = $this->db->select('confirmation_code')->order_by('trans_id',"desc")->limit(1)->get('transactions')->row();

		$array = json_decode(json_encode($last_row), true);

		$array = explode('-', $array['confirmation_code']);
		
		$last_id = end($array);

		if ($last_id == '') {
			return "0";
		} else {
			return $last_id;
		}
				
	}

	public function fetchExistingCode()
	{
		$last_row = $this->db->select('confirmation_code')->limit(1)->get('temp_transaction')->row();
		$array = json_decode(json_encode($last_row), true);

		return $array['confirmation_code'];
	}

	public function updateStock($prod_id, $quantity)
	{
		$proucts = $this->getProductById($prod_id);
		$productArray = array ();

		foreach ($proucts as $prod) {

			if ($quantity > $prod['stock']) {
				echo "not enough stock"; exit;
			} else {
				$productArray[] = array (
					'prod_id' => $prod_id,
					'stock' => $prod['stock'] - $quantity
				);
			}
			
		}

		return $this->db->update_batch('products', $productArray, 'prod_id'); 
	}

	public function getMemberbyCode($code)
	{
		if ($code == "") {

			return false;
		} else {

			$this->db->select('user_id, first_name, middle_name, last_name');
			$this->db->where('username', $code);
			$query = $this->db->get('users');

			return $query->result_array();
		}
	}

	public function getConfirmationCodeById($user_id)
	{
		$this->db->distinct();
		$this->db->select('confirmation_code, transaction_date');
		$this->db->where('user_id', $user_id);	
		$this->db->where('is_credit', null);
		$this->db->group_by('confirmation_code');
		$query = $this->db->get('transactions');

		return $query->result_array();
	}

	public function getCreditConfirmationCodeById($user_id)
	{
		$this->db->distinct();
		$this->db->select('confirmation_code, transaction_date');
		$this->db->where('user_id', $user_id);	
		$this->db->where('is_credit', true);	
		$this->db->group_by('confirmation_code');
		$query = $this->db->get('transactions');

		return $query->result_array();
	}


	public function getTransactionsByCode($confirmation_code)
	{
		$this->db->select('t.product_code, p.prod_name, t.price, t.quantity, t.amount', false);
		$this->db->where('t.confirmation_code', $confirmation_code);	
		$this->db->from('transactions as t');
		$this->db->join('products as p', 'p.prod_id = t.prod_id');
		$query = $this->db->get(); 

		return $query->result_array();

	}

	public function getTotalAmountbyCode($confirmation_code)
	{
		$this->db->where('confirmation_code', $confirmation_code);	
		$query = $this->db->select_sum('amount');
	    $query = $this->db->get('transactions');
	    $result = $query->result();

	   	return $result[0]->amount;
	}

	public function checkIfHasCredit($user_id)
	{
		if ($user_id == "") {
			return false;
		} else {

			$this->db->select('*');
			$this->db->where('user_id', $user_id);
			$this->db->where('is_credit', true);
			$query = $this->db->get('transactions');

			return $query->num_rows();
		}

	}

	public function payCreditById($user_id, $transDate)
	{
		$updateData = array (
			'is_credit' => null,
			'credit_due_date' => null
		);

		$this->db->where('user_id', $user_id);
		$this->db->where('transaction_date', $transDate);

		return $this->db->update('transactions', $updateData);
	}

	public function selectCreditDetails($user_id)
	{
		$this->db->select('SUM(amount) as total_amount, transaction_date, confirmation_code', false);
		$this->db->where('user_id', $user_id);
		$this->db->where('is_credit', true);
		$this->db->from('transactions');
		$query = $this->db->get();

		return $query->result_array();

	}

}