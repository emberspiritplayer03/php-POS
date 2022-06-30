<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include('member_header.php'); ?>

<div class="container">
	<h3>List of Products</h3>
	<div class="row body-panel">
		<div class="col-md-6 search-area">
			<span>Search Product:</span>
			<input type="text" id="txtMySearch" placeholder="Enter keyword here" class="form-control" style="height: 42px;margin-top: 0px;" />
		</div>
	</div>
	<!-- Table -->
	<table class="table table-bordered" id="productTable" style="width: 70%;">
		<thead>
			<tr>
				<th>PRODUCT CODE</th>
				<th>PRODUCT NAME</th>
				<th>PRICE</th>
				<th>STOCK</th>
			</tr>
		</thead>
		<tbody>	
			<?php foreach($products as $prod): ?>
				<tr>
					<td><?php echo $prod['product_code']; ?></td>
					<td><?php echo $prod['prod_name']; ?></td>
					<td><?php echo number_format($prod['price'], 2); ?></td>
					<td class="<?php echo ($prod['stock'] == '0') ? 'lblstock' : ''?>"><?php echo $prod['stock']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<script type="text/javascript" src="<?php echo base_url('assets/js/products.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>	
</div>