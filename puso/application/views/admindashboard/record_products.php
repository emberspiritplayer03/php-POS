<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include_once('header.php'); ?>

<div class="container">
	<br>
	<div class="panel panel-default panel-product" style="border-radius: 0px!important; width: 100%; padding-bottom: 50px;">
		<!-- Default panel contents -->
		<div class="panel-heading">List of Products</div>
		
		<div class="panel-body">
			<div class="row body-panel">
				<div class="col-md-6 add-area">
					<a id="addProdBtn" class="btn btn-success" href="#" data-toggle="modal" data-target="#addProductModal"><i class="fa fa-product-hunt fa-2x" aria-hidden="true"></i> ADD PRODUCT</a>
					<br>
					<span style="font-size: 15px;">Search Product:</span>
					<input type="text" id="txtSearchProd" placeholder="Enter search keyword here" class="form-control"/>
				</div>
			</div>
		</div>
		<!-- Table -->
		<table class="table table-bordered" id="productTable" style="width: 96%; margin-left: 15px;">
			<thead>
				<tr>
					<th>#</th>
					<th>Product Code</th>
					<th>Product Name</th>
					<th>Price</th>
					<th>In Stock</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products as $prod): ?>
					<tr>
					<td><?php echo $prod['prod_id']; ?></td>
					<td><?php echo $prod['product_code']; ?></td>
					<td><?php echo $prod['prod_name']; ?></td>
					<td style="font-size: 16px;"><?php echo number_format($prod['price'], 2); ?></td>
					<td style="font-size: 16px;"><?php echo $prod['stock']; ?></td>
					<td>
						<a href="#" class='btnEdit' data-id="<?php echo $prod['prod_id']; ?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" style="color:#000000"></i></a>&nbsp;
						<a href="#" class='btnDelete' data-id="<?php echo $prod['prod_id']; ?>"><i class="fa fa-trash fa-2x" aria-hidden="true" style="color: #000000;"></i> </a>
					</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<!-- Add Modal -->
	<div id="addProductModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Product</h4>
				</div>
				<div class="modal-body" style="padding-left: 30px;">
					<div class="row">
						<div class="col-md-5">
							<span>Product Code:*</span>
							<input name="prod_code" type="text" placeholder="ex. SMPL001" class="form-control add-name-labels" id="txtProdCode"/>
						</div>
						<div class="col-md-7" style="margin-top: 6%;">
							<span style="color:red; margin-left: -20%;" class="code-validation hide">Product code already exist!</span>
						</div>
					</div>
					<span>Product Name:* </span>
					<input type="text" style="width: 70%" placeholder="ex. Sample Product"class="form-control add-name-labels" id="txtProdName" />
					<span>Product Amount:* </span>
					<input type="text" style="width: 25%" class="form-control add-name-labels" id="txtPrice"/>
					<span>Stock:* </span>
					<input type="text" style="width: 25%" class="form-control add-name-labels" id="txtStock"/>
					<span style="color:red;" class="hide" id="requiredAlert">Please enter values to required fields *</span>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" class="btn btn-success">Add Product</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Discard</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div id="editProductModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Product</h4>
				</div>
				<div class="modal-body" style="padding-left: 30px;">
					<div class="row">
						<div class="col-md-5">
							<span>Product Code:*</span>
							<input type="text" class="form-control add-name-labels" id="editProdCode"/>
						</div>
						<div class="col-md-7" style="margin-top: 6%;">
							<span style="color:red; margin-left: -20%;" class="code-validation hide">Product code already exist!</span>
						</div>
					</div>
					<span>Product Name:* </span>
					<input type="text" style="width: 70%" class="form-control add-name-labels" id="editProdName"/> 
					<span>Product Amount:* </span>
					<input type="text" style="width: 25%" class="form-control add-name-labels" id="editPrice"/>
					<span>Stock:* </span>
					<input type="text" style="width: 25%" class="form-control add-name-labels" id="editStock"/>
					<span style="color:red;" class="hide" id="requiredAlert">Please enter values to required fields *</span>
					<input type="hidden" id="editProdId"/>

				</div>
				<div class="modal-footer">
					<button type="button" id="btnSaveEdit" class="btn btn-success">Save Changes</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Discard Changes</button>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript" src="<?php echo base_url('assets/js/products.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>	


</div>
