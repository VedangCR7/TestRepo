
<?php include 'header.php'; ?>

    <!-- SPECIFIC CSS -->
    <link href="<?= $root_url; ?>/website_assets/webAssets/css/blog.css" rel="stylesheet">
	<main>
		<div class="page_header blog element_to_stick">
		    <div class="container">
		    	<div class="row">
		    		<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
		    			<h1>Blog and Articles</h1>
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

		<div class="container margin_60_20">			
			<div class="row">
				<div class="col-lg-9">
					<div class="row">
						<!-- blog looping start here -->
						<?php 
                     if(isset($_GET['category'])){
                      
                       $category_id=$_GET['category'];

                        $sql = "SELECT * FROM blog WHERE status =1 AND cat_id = 
                        '$category_id'";
                     }else{
                       $sql = "SELECT * FROM blog WHERE status =1 ";
                     }
                     
                     $result = mysqli_query($conn, $sql);

						if (mysqli_num_rows($result) > 0) {
						  // output data of each row
						  while($row = mysqli_fetch_assoc($result)) {
						  	?>


						<div class="col-md-6">

							<article class="blog">
								<figure>
									<a href="blog-post.php"><img src="<?= $root_url; ?>/website_assets/webAssets/img/blog-1.jpg" alt="">
										<div class="preview"><span>Read more</span></div>
									</a>
								</figure>
								<div class="post_info">
									<small>Category - 20 Nov. 2017</small>

					<h2><a href="blog-post.php?id=<?= $row['id']; ?>"><?php echo $row['title'] ?></a></h2>
									<p><?php echo substr($row['description'],'0','100') ?>...</p>
									<ul>
										<li>
											<div class="thumb"><img src="<?= $root_url; ?>/website_assets/webAssets/img/avatar.jpg" alt=""></div> Admin
										</li>
										<li><i class="icon_comment_alt"></i>20</li>
									</ul>
								</div>
							</article>
							<!-- /article -->
						</div>
                       <!--  blog looping ends here -->
                        
                        	<?php  
						    
						  }	
						} 


						?>

					</div>
					<!-- /row -->

					<div class="pagination_fg">
					  <a href="#">&laquo;</a>
					  <a href="#" class="active">1</a>
					  <a href="#">2</a>
					  <a href="#">3</a>
					  <a href="#">4</a>
					  <a href="#">5</a>
					  <a href="#">&raquo;</a>
					</div>

				</div>
				<!-- /col -->

				<aside class="col-lg-3">
					<div class="widget">
						<div class="widget-title first">
							<h4>Latest Post</h4>
						</div>
						<ul class="comments-list">
							 
							 <?php 

                     $sql = "SELECT * FROM blog  WHERE status =1 limit 3 ";
                     $result = mysqli_query($conn, $sql);

						if (mysqli_num_rows($result) > 0) {
						  // output data of each row
						  while($row = mysqli_fetch_assoc($result)) {
						  	?>
                            
							<li>
								<div class="alignleft">
									<a href="blog-post.php"><img src="<?= $root_url; ?>/website_assets/webAssets/img/blog-5.jpg" alt=""></a>
								</div>
								<small>Category - 11.08.2016</small>
								<h3><a href="" title="" ><?php echo substr($row['title'],'0','30') ?>..</a></h3>
							</li>

						<?php } } ?>
							
						</ul>
					</div>
					<!-- /widget -->
					<div class="widget">
						<div class="widget-title">
							<h4>Categories</h4>
						</div>
						<ul class="cats">
							 <?php 

		                     $sql = "SELECT * FROM blog_category  WHERE status =1  ";
		                     $result = mysqli_query($conn, $sql);

								if (mysqli_num_rows($result) > 0) {
								  // output data of each row
						  while($row = mysqli_fetch_assoc($result)) {
						  	?>
                             
							<li><a href="<?php echo "blog.php?category=" ?><?php echo $row['id'] ?>">><?php echo $row['title'] ?> <span></span></a></li>

						<?php }}  ?> 
							
						</ul>
					</div>
					<!-- /widget -->
					<!-- <div class="widget">
						<div class="widget-title">
							<h4>Popular Tags</h4>
						</div>
						<div class="tags">
							<a href="#">Food</a>
							<a href="#">Bars</a>
							<a href="#">Cooktails</a>
							<a href="#">Shops</a>
							<a href="#">Best Offers</a>
							<a href="#">Transports</a>
							<a href="#">Restaurants</a>
						</div>
					</div> -->
					<!-- /widget -->
				</aside>
				<!-- /aside -->
			</div>
			<!-- /row -->	
		</div>
		<!-- /container -->
		
	</main>

<?php include 'footer.php'; ?>
