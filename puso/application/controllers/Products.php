<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Products extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('products_model');
	}

	public function index()
	{
		if ($this->session->userdata('logged_in') == NULL)
		{
			redirect('login');
		}

		$products = $this->products_model->getAllProducts();

		$data['session_array'] = $this->session->userdata('logged_in');
		$data['products'] = $products;
		$data['page'] = 'products';
		
		$this->load->view('admindashboard/record_products', $data);
	}

	public function addProduct()
	{
		$prod_code = $this->input->post('prod_code');
		$prod_name = $this->input->post('prod_name');
		$price = $this->input->post('price');
		$stock = $this->input->post('stock');

		if ($this->products_model->productCodeExist($prod_code)) {
			echo "0"; 
		} 

		else {

			$productData = array (
				'product_code' => $prod_code,
				'prod_name' => $prod_name,
				'price'		=> $price,
				'stock'		=> $stock
			);

			$result = $this->products_model->addProduct($productData);

			echo json_encode($result);
		}
		
	}

	public function selectSingleProduct($prodId)
	{
		$result = $this->products_model->selectSingleProduct($prodId);

		echo json_encode($result[0]);
	}

	public function editProduct()
	{
		$prod_code = $this->input->post('prod_code');
		$prod_name = $this->input->post('prod_name');
		$price = $this->input->post('price');
		$stock = $this->input->post('stock');
		$prod_id = $this->input->post('prod_id');

		
		// if ($this->products_model->productCodeExist($prod_code)) {
		// 	echo "0"; 
		// } else {
			$productData = array (
				'product_code' => $prod_code,
				'prod_name' => $prod_name,
				'price'		=> $price,
				'stock'		=> $stock
			);

			$result = $this->products_model->editProduct($prod_id, $productData);

			echo json_encode($result);				
		//}


	}

	public function deleteProduct($prodId)
	{
		$productData = array ('is_deleted' => true);

		$result = $this->products_model->deleteProduct($prodId, $productData);

		echo json_encode($result);
	}

	public function searchProduct()
	{
		$search = $this->input->post('search');

		$result = $this->products_model->searchProduct($search);

		echo json_encode($result);
	}
}