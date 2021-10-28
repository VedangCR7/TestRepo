<?php include 'header.php'; ?>

<!-- SPECIFIC CSS -->
<link href="<?= $root_url; ?>/website_assets/webAssets/css/detail-page.css" rel="stylesheet">
<link href="<?= $root_url; ?>/website_assets/webAssets/css/listing.css" rel="stylesheet">


<main class="order_successpage">
    <div class="row justify-content-center">
        <div class="col-lg-7" id="sidebar_fixed">
            <div class="box_order mobile_fixed">
                <!-- /head -->
                <div class="main">
                    <div class="">
                        <h4 class="mb-4">Write a review for “Pizzeria da Alfredo”</h4>
                        <h6 class="mb-4">Overall rating</h6> 
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group mb-0">
                                    <div class="slidecontainer" >                      
                                        <label class="distance">Food Quality <span></span></label>
                                        <div class="add_bottom_25"><input type="range" min="0" max="50" step="5" value="0" data-orientation="horizontal"></div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-0">
                                    <div class="slidecontainer" >                      
                                        <label class="distance">Service <span></span></label>
                                        <div class="add_bottom_25"><input type="range" min="0" max="50" step="5" value="0" data-orientation="horizontal"></div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-0">
                                    <div class="slidecontainer" >                      
                                        <label class="distance">Location <span></span></label>
                                        <div class="add_bottom_25"><input type="range" min="0" max="50" step="5" value="0" data-orientation="horizontal"></div>
                                    </div>
                                 </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-0">
                                    <div class="slidecontainer" >                      
                                        <label class="distance">Price <span></span></label>
                                        <div class="add_bottom_25"><input type="range" min="0" max="50" step="5" value="0" data-orientation="horizontal"></div>
                                    </div>
                                 </div>
                            </div>
                        </div>                        
                        <div class="form-group mb-4">
                            <label>Title of your review</label>
                            <input class="form-control" type="text" placeholder="If you could say in one sentence what would you say?">
                        </div>
                        <div class="form-group mb-4">
                            <label>Your Review</label>
                            <textarea class="form-control" style="height: 150px;" placeholder="Write your review to help others to learn about this online business"></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label>Add your photo (optional)</label>
                            <label class="filetext">
                                <span>Browse</span> <p>No File Selected</p>
                                <input class="form-control" type="file" placeholder="Browse.. No File Selected
                                ">
                            </label>
                        </div>
                        <label class="container_check">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="btn_1_mobile mt-4">
                        <button href="order.php" class="btn_1">Submit Review</button>
                    </div>
                </div>
            </div>
            <!-- /box_order -->
            <div class="btn_reserve_fixed"><a href="#0" class="btn_1 gradient full-width">View Basket</a></div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<!-- SPECIFIC SCRIPTS -->
<script src="<?= $root_url; ?>/website_assets/webAssets/js/sticky_sidebar.min.js"></script>
<script src="<?= $root_url; ?>/website_assets/webAssets/js/specific_listing.js"></script>
