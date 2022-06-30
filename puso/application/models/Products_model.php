<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Products_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
	}

	public function getAllProducts()
	{
		$this->db->where('is_deleted', false);
		$query = $this->db->get('products'); 
		return $query->result_array();
	}

	public function addProduct($productData)
	{
		return $this->db->insert('products', $productData);
	}

	public function editProduct($prodId, $productData)
	{
		$this->db->set('date_modified', 'NOW()', false);
		$this->db->where('prod_id', $prodId);
		return $this->db->update('products', $productData);
	}

	public function selectSingleProduct($prodId)
	{
		$this->db->where('prod_id', $prodId);
		$query = $this->db->get('products');

		return $query->result_array();
	}

	public function deleteProduct($prodId, $productData)
	{
		$this->db->where('prod_id', $prodId);
		return $this->db->update('products', $productData);

	}

	public function productCodeExist($productCode)
	{
		$this->db->where('product_code', $productCode);
		$query = $this->db->get('products');

		if( $query->num_rows() > 0) {
			return true;
		}

		return false;
	}

	public function searchProduct($search)
	{
		$this->db->select('*');
		$where = "(product_code LIKE '%$search%' OR prod_name LIKE '%$search%' OR price LIKE '%$search%' OR stock LIKE '%$search%')";
		$this->db->where($where);
		$this->db->where('is_deleted', false);
		$query = $this->db->get('products');

		return $query->result_array();

	}

}