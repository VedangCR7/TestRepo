<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<style type="text/css"/>
.watermark{
	background-image:url('watermark-image.jpg');
	background-repeat:repeat-y;
	background-position:right top;
	background-size:17px 220px;
}
.addremovetoprintclass{
	bottom:-20px;left:4px;position:fixed; -webkit-transform:rotate(-90deg);vertical-align:bottom;
}
</style>
<div id="rotate-div" width=58mm>
	<div style="position:fixed;top:5px;left:0px;font-size:14px;padding:0px;width:58mm;border:0px solid gray;font-family:Tahoma,Geneva,sans-serif;text-align:center">
		<b style="margin-top: 10px;font-size:19px;"><?=$invoice['rest_name'];?></b><br>
		<span style="font-size:11px;">Veg Restaurant</span><br>
		<span style="font-size: 9px;"><?=$invoice['address'];?><br> <?=$invoice['city'];?>, <?=$invoice['postcode'];?></span>
		<table width=100% cellspacing=4 cellpadding=0 style="font-size:13px;padding-top: 10px;">
			<tr style="font-size:11px;padding-bottom: 10px;">
				<td align=left><b>Cust. :</b> <?=$invoice['customer_name'];?>
				<td align=right><b>T.No. :</b> <?=$invoice['table_no'];?>
			</tr>
			<tr style="font-size:11px;">
				<td align=left><b>Date :</b><?=$invoice['invoic_date'];?>
				<td align=right><b>Bill No:</b> <?=$invoice['invoice_no'];?>
			</tr>
			<tr style="font-size:11px;">
				<?php 
				if($invoice['no_of_person']>0)
				{
				?>
				<td align=left><b>No Of Person : </b><?=$invoice['no_of_person'];?>
				<?php 
				}
				else
				{
				?>
				<td align=left><b>No Of Person : </b>
				<?php 
				}
				?>
			</tr>
			<tr style="font-size:12px;">
				<td colspan=2>------------------------------------------------</td>
			</tr>
		</table>
		<table width=100% cellspacing=0 cellpadding=0 style="font-size:13px;">
			<tr style="font-size:12px;font-weight:bold">
				<td align=center>Sn
				<td align=center>Particulars
				<td align=right>Qty
				<td align=right>Rate
				<td align=right width="60px">Amt
			</tr>
			<tr style="font-size:12px;"><td colspan=5 >--------------------------------------------------</tr>
			<?php
			$i=1;
				foreach ($invoice['items'] as $item) {
			?>
				<tr style='font-size:12px;' height=15px>
					<td align=left><?=$i;?>
					<td align=left><?=$item['recipe_name'];?>
					<td align=center><?=round($item['qty'],2);?>
					<td align=right><?=$item['price'];?>
					<td align=right><?=$item['total'];?>
				</tr>
			<?php
				$i++;
				}
			?>
			<tr style="font-size:12px;"><td colspan=5 >--------------------------------------------------</tr>
			<tr style="font-size:11px;font-weight:bold" height=22px>
				<td colspan=4 align=right><label id="sub-total">Sub Total :</label>
				<td align=right><?=$currency_symbol[0]['currency_symbol']?> <?=$invoice['sub_total'];?>
			</tr>
			<tr style="font-size:11px;font-weight:bold" height=22px>
				<td colspan=4 align=right><label id="disc-total">Disc. Total :</label>
				<td align=right><?=$currency_symbol[0]['currency_symbol']?> <?=$invoice['disc_total'];?>
			</tr>
			
			<?php
				if ($invoice['supply_option'] == "Delivery") {
					?>
					<tr style="font-size:11px;font-weight:bold" height=22px>
						<td colspan=4 align=right><label id="sub-total">Delivery Fee :</label>
						<td align=right><?=$currency_symbol[0]['currency_symbol']?> <?=$currency_symbol[0]["delivery_fee"];?>
					</tr>
					<?php
				}
			?>
			
			<tr style="font-size:11px;font-weight:bold" height=22px>
				<td colspan=4 align=right><label id="disc-percentage">Disc(%) :</label>
				<td align=right><?=$invoice['dis_total_percentage'];?>
			</tr>
			<?php
				$cgst_per=$invoice['cgst_total'];
				$sgst_per=$invoice['sgst_total'];
				
				$disc_percentage_total =($invoice['sub_total']*$invoice['dis_total_percentage'])/100;
				$sub_total=$invoice['sub_total']-$invoice['disc_total']-$disc_percentage_total;
				$cgst=($invoice['sub_total']*$cgst_per)/100;
				$sgst=($invoice['sub_total']*$sgst_per)/100;
				$net_total=($invoice['sub_total']-$invoice['disc_total'])+$cgst+$sgst;
				// added by victor
				if ($invoice['supply_option'] == "Delivery") {
					$net_total+=$currency_symbol[0]["delivery_fee"];
				}
				/* $net_total=$invoice['net_total']; */
			?>
			
			<tr style="font-size:11px;font-weight:bold" height=22px>
				<td colspan=4 align=right><label id="sub-total">C.G.S.T :</label>
				<td align=right><?=$currency_symbol[0]['currency_symbol']?> <?=number_format(round($cgst,2),2);?>
			</tr>
			<tr style="font-size:11px;font-weight:bold" height=22px>
				<td colspan=4 align=right><label id="sub-total">S.G.S.T :</label>
				<td align=right><?=$currency_symbol[0]['currency_symbol']?> <?=number_format(round($sgst,2),2);?>
			</tr>
			<tr style="font-size:12px;"><td colspan=5 >-------------------------------------------------</tr>
			<tr style="font-size:11px;font-weight:bold" height=22px>
				<td colspan=4 align=right><label id="total-bill">Total Amount :</label>
				<td align=right><?=$currency_symbol[0]['currency_symbol']?> <?=number_format(round($net_total,2),2);?>
			</tr>
			<tr style="font-size:12px;"><td colspan=5 >-------------------------------------------------</tr>
			<tr style="font-size:12px;font-weight:bold" height=22px><td colspan=5 align=right><label id="bvg-total"></label></tr>
		</table>
		<label align='right' width=100% style='font-size:16px;'>THANK YOU, VISIT AGAIN<label>
	</div>
	<!-- <div id="show-hide-buttons" style="width:250px;position:fixed;bottom:50px;">
		<a href="javascript:" onclick="printbillreport();" style="float:left">Print Report</a>
		<a href="javascript:" onclick="window.close();" style="float:right">Go to Home</a>
	</div> -->
	<!-- <div id="watermark" style='display:none;position:fixed;left:120px;top:157px;float:left;-webkit-transform:rotate(90deg);transform:rotate(90deg);font-size:10px;font-family:tahoma;color:black;width:325px' width=800px>Technoplanet Softwares,Ahmednagar. Contact:+91 83-789-93-505</div> -->
</div>
<body>
<!--<input type=button Value="Print Bill" onclick="printbillfunction(this);">-->
</body>
 <script src="<?=base_url();?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script>
$(document).ready( function() {
    setTimeout( function() {
        //alert("hi");
		printbillreport();
    }, 100);
});
function printbillreport()
{
	$('#watermark').show();
	$('#show-hide-buttons').hide();
	window.print();
	$('#show-hide-buttons').show();
	$('#watermark').hide();
}
</script>