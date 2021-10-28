<?php
require_once('header.php');
require_once('sidebar.php');
date_default_timezone_set("Asia/Kolkata");
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class=" app-content">
	<div class="side-app">
		<!--Page Header-->
		<div class="page-header">
			<h3 class="page-title"><i class="fe fe-home mr-1"></i> Purchase Invoice Details</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Purchase Invoice Details</li>
			</ol>
		</div>
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
                <div class="card-header">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                        <a href="#" target="_blank" onclick="printDiv('printableArea')"><button class="btn btn-primary"><i class="fas fa-print"></i> Print Invoice</button></a>
                        <a href="<?=base_url('inventory/edit_purchase_list/'.$this->uri->segment(3))?>"><button class="btn btn-warning"><i class="fas fa-edit"></i> Edit Invoice</button></a>
                    </div>
                </div>
				<div class="card-body printableArea" id="printableArea">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center"><h4>Purchase Invoice</h4></div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:-20px;"><hr></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                        <p>Invoice No : <?=$invoice_details[0]['invoice_no']?></p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                        <p>Invoice Date : <?=$invoice_details[0]['created_at']?></p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                        <p>Supplier Name : <?=$invoice_details[0]['company_name']?></p>
                    </div>
					<div class="table-responsive mt-4 table-single-orders">
						<table class="table table-bordered">
							<thead >
								<tr>
									<th>Sr No.</th>
									<th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Amount</th>
								</tr>
							</thead>
							<tbody class="tbody-order-list">
								<?php
								$i=1;
                                $sub_total=0;
								foreach ($invoice_details as $item) {
								?>
								<tr>
									<td><?=$i++?></td>
									<td><?=$item['product_name'];?></td>
                                    <td><?=$item['qty'];?></td>
                                    <td><?=$item['price'];?></td>
                                    <td><?=$item['qty']*$item['price'];?></td>
                                </tr>
								<?php
                                $sub_total= $sub_total+($item['qty']*$item['price']);
								}
								?>
							</tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total</td>
                                <td><?=$sub_total?></td>
                            </tr>
                            <tr>
                                <td>Total in words</td>
                                <td colspan="4"><?=ucfirst(convert_number_to_words($sub_total))?></td>
                            </tr>
                            </tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
    </script>
    <?php 
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}?>
	<script>
	setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/set_authority_exist",
                    type:'POST',
                    dataType: 'json',
                    data: {name:'Inventory Management'},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>restaurant/dashboard";
                        }
                   	}
                });
            },5000);
</script>

<?php
        if ($this->session->flashdata('success')) {
            echo "<script>swal('success','" . $this->session->flashdata('success') . "','success')</script>";
        }
        if ($this->session->flashdata('danger')) {
            echo "<script>swal('danger','" . $this->session->flashdata('danger') . "','error')</script>";
        }
        ?>
<?php
require_once('footer.php');
?>

<script>
    var report_title='Purchase List';
    Common.datatablewithButtons(report_title,'Purchase List');
</script>