
<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
</head>
<body>
<table class="table table-striped table-hover" width="100%">
    <!-- <thead>
        <tr>
            <th>#</th>
            <th>Book Name</th>
            <th>Author</th>
        </tr>
    </thead> -->
    <tbody>
        <tr>
            <td colspan="4" style="text-align:right;"><img src="<?=base_url('assets/images/brand/FoodNAILoginLogo.png')?>" height="50px" weight="100px;"></td>
        </tr>
	
	<tr>
		<td colspan="4"><p>Thank You for choosing Youcloud , <?=$invoice_details['customer_name']?> ! Here are your order details : </p></td>
	</tr>

	<tr>
		<td colspan="2"><p>Invoice No. : <b><span style="font-weight:bold"><?=$invoice_details['invoice_no']?></span></b></p></td>
		<td colspan="2"><p>Delivery To : </p></td>
	</tr>

	<tr>
		<td colspan="2"><p>Order Placed at. : <b><span style="font-weight:bold"><?=$invoice_details['created_at']?></span></b></p></td>
		<td colspan="2"><b class="custname" style="font-weight:bold"><?=$invoice_details['customer_name']?></b></td>
	</tr>

	<tr>
		<td colspan="2"><p>Status : <b><span id="invoicestatus" style="font-weight:bold"><?=$invoice_details['status']?></span></b></p></td>
		<td colspan="2"><p>Customer Contact : <b><span id="custcontact" style="font-weight:bold"><?=$invoice_details['contact_no']?></span></b></p></td>
	</tr>

	<tr>
		<td colspan="2"><p>Ordered from :</p>
		<p style="font-weight:bold"><?=$_SESSION['business_name']?></p></td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4">
			<table width="100%" border="1" cellpadding="5" cellspacing="0">
				<thead>
					<tr>
						<th>Menu Name</th>
						<th>Qty</th>
						<th>Price</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($invoice_details['items'] as $key=>$value){ ?>
					<tr>
						<td><?=$value['recipe_name']?></td>
						<td><?=$value['qty']?></td>
						<td><?=$value['price']?></td>
						<td><?=$value['total']?></td>
					</tr><?php } ?>
					<tr>
						<td colspan="3" style="text-align: right;">Sub Total</td>
        					<td id="sub_total" style="text-align: right;"><?=$invoice_details['sub_total']?></td>
					</tr>

					<tr>
						<td colspan="3" style="text-align: right;">Discount Total</td>
        					<td id="dis_total" style="text-align: right;"><?=$invoice_details['disc_total']?></td>
					</tr>
					
					<tr>
						<td colspan="3" style="text-align: right;">CGST Total</td>
        					<td id="dis_total" style="text-align: right;"><?=$invoice_details['cgst_total']?></td>
					</tr>
					
					<tr>
						<td colspan="3" style="text-align: right;">SGST Total</td>
        					<td id="dis_total" style="text-align: right;"><?=$invoice_details['sgst_total']?></td>
					</tr>

					<tr>
						<td colspan="3" style="text-align: right;">Net Total</td>
        					<td id="net_total" style="text-align: right;"><?=$invoice_details['net_total']?></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
        
    <tbody>
</table>
</body>
</html>