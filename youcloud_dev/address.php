<?php include 'header.php'; ?>
<?php 

$login_id = $_SESSION['user_id'];

/*for delete the data*/

if(isset($_GET['id']) && $_GET!==''){

 	$delete_id = $_GET['id'];

 	$sql="DELETE FROM customer_address WHERE customer_id = '$login_id'";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo "Deleted Successfully";
        echo "<BR>";
        echo "<a href='delete.php'>Back to main page</a>";
    }else {
        echo "ERROR";
    }


}



 ?>



<main>
	<div class="page_header element_to_stick">
	    <div class="container">
	    	<div class="row">
	    		<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
	        		<h1>Top Restaurant Nearest You</h1>
	        		<a href="addnewaddress.php">Change address</a>
	    		</div>
	    		<div class="col-xl-4 col-lg-5 col-md-5">
	    			<div class="search_bar_list">
						<input type="text" class="form-control" placeholder="Dishes, restaurants or cuisines">
						<button type="submit"><i class="icon_search"></i></button>
					</div>
	    		</div>
	    	</div>
	    	<!-- /row -->		       
	    </div>
	</div>
	<!-- /page_header -->

	<div class="container margin_30_20">			
		<div class="row">

			<?php include 'ac_sidebar.php'; ?>

			<div class="col-lg-9">

                <P>
                    
                    <?php
             if(isset($error)){
                echo $error;
                $error="";
             }

             ?>
                </P>
                <div class="account_table myaddress mt-4">

                	<div style="background-color: floralwhite;text-align: center;margin-bottom: 10px;">
                        <?php if(isset($_GET['msg']) && $_GET['msg']=='scs'){ ?>

                            <span style="color:green;"><b>
                                Address Added successfully.</b>
                            </span>

                        <?php } ?>

                        <?php if(isset($_GET['msg']) && $_GET['msg']=='failed'){ ?>

                            <span style="color:red;"><b>
                                Oops! Something went wrong...</b>
                            </span>

                        <?php } ?>

                        <?php if(isset($_GET['msg']) && $_GET['msg']=='updated'){ ?>

                            <span style="color:green;"><b>
                               Address Updated Successfully...</b>
                            </span>

                        <?php } ?>

                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="accounttable_heading mb-4"><i class="icon_pin_alt"></i> My Address</h4>
                        </div>
                        <div class="col-lg-6">
                            <a href="addnewaddress.php" class="goldenbtns float-right">Add new address</a>
                        </div>
                    </div>
                    <table class="table myaddress_table">
                        <thead>
                            <th class="mt-2">Mark as default<th>
                            <th class="mt-2">Address Detail<th>
                        </thead>
                        <tbody>
                        <?php 

                        $customer_id=$_SESSION['user_id'];

		               $sql = "SELECT * FROM customer_address Where 
		               customer_id='$customer_id'";

		               $result = mysqli_query($conn, $sql);

		                if (mysqli_num_rows($result) > 0) {
		                          // output data of each filepro_rowcount()
		                  while($row = mysqli_fetch_array($result)) {
		                            ?>
		                          <tr>
		                            <td><input type="radio" <?php echo $row['marked_as_default']." "; if($row['marked_as_default']==1){ echo "checked"; } ?>  class="marked_as_default" name="test" value="<?php echo $row['id']; ?>"></td>
		                            <td><?php echo $row['name']; ?></td>
		                            <td><?php echo $row['complete_address']; ?></td>
		                            <td><?php echo $row['contact_number']; ?></td>
		                            <td><a href="editaddress.php?id=<?php echo $row['id']; ?>">
		                                <i class="icon_pencil"></i>
		                            </a><a href="address.php?id=<?php echo $row['id']; ?>">
		                                <i class="icon_trash_alt"></i>
		                            </a></td>
		                          </tr>
		                      <?php 
		                  }}
		                       ?>
                        </tbody>
                      </table>
                </div>
				
				<!-- /row -->
				<!-- <div class="pagination_fg greenpagination">
				  <a href="#" class="angleactive"><i class="arrow_carrot-left"></i></a>
				  <a href="#" class="active">1</a>
				  <a href="#">2</a>
				  <a href="#">3</a>
				  <a href="#">4</a>
				  <a href="#">5</a>
				  <a href="#"><i class="arrow_carrot-right"></i></a>
				</div> -->
			</div>
			<!-- /col -->
		</div>		
	</div>
	<!-- /container -->
	
</main>


<?php include 'footer.php'; ?>


<script>
$('.marked_as_default').on('change', function() {
//   alert("Are you sure you have chosen the correct entry level?"); 
   
//   alert($(this).val());
   
   var updateId = $(this).val();
   
   if(updateId!==''){
       
          $.ajax({

             url:'ajaxActions.php',
             method:'POST',
             dataType:'json',
             data:{
                updateId:updateId,
                action:"markedAddressAsDefault",
             },
             success:function(res){

                console.log(res);
                return;


            /*if Success*/    
            if(res.responseData==false){

                $('#rgstrForm_id').submit();
                // setTimeout(function(){ window.location.reload(); }, 3000);

            }  

            /*if already exist*/                  
            if(res.responseData==true){

                $('.respMsg').html('<p class="alert alert-danger">Already EXIST!<br> Account already exist please try using another details!!</p>');
                return;

            } 

            /*if illegle access*/                  
            if(res.responseData=='NON_POST'){
 
                $('.respMsg').html('<p class="alert alert-danger"><b>Failed</b>! Something Went wrong please try again!!</p>');

                return;

            } 

   
            }
          });
       
       
       
       
   }
   
   
   
   
   
});
</script>
