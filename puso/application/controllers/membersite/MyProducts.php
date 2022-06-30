<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class MyProducts extends CI_Controller {

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

		$data['page'] = 'myproducts';
		$data['session_array'] = $this->session->userdata('logged_in');
		$data['products'] = $this->products_model->getAllProducts();

		$this->load->view('membersite/my_products', $data);
	}
}