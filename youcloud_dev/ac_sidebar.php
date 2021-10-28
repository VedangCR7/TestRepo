<aside class="col-lg-3 account-sidebarmain" id="sidebar_fixed">
                    <h6>Dashboard</h6>
                    <ul class="account-sidemenu mb-4"> 
                        <li class="<?php if($_SERVER['REQUEST_URI']=='/youcloud_dev/account.php'){ echo "active"; } ?>">
                            <a href="account.php">
                                <i class="icon_bag_alt"></i>
                                Orders
                                <span><?php                                 
                                $customer_id = $_SESSION['user_id'];
                               
                                $order_selectSQL = "SELECT * FROM orders WHERE customer_id='$customer_id'";
                                
                                $order_DataArr = mysqli_query($conn, $order_selectSQL);
                                
                                echo $order_DataArr->num_rows;
                                
                                ?></span>
                                
                            </a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI']=='/youcloud_dev/favourite.php'){ echo "active"; } ?>">
                            <a href="favourite.php">
                                <i class="icon_heart_alt"></i>
                                My Favourites
                                <span>4</span>
                                
                            </a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI']=='/youcloud_dev/support.php'){ echo "active"; } ?>">
                            <a href="support.php">
                                <i class="icon_headphones"></i>
                                Supports Tickets
                                <span>4</span>
                                
                            </a>
                        </li>
                    </ul>
                    <h6>Account Setting</h6>
                    <ul class="account-sidemenu"> 
                        <li class="<?php if($_SERVER['REQUEST_URI']=='/youcloud_dev/profile.php'){ echo "active"; } ?>">
                            <a href="profile.php">
                                <i class="icon_profile"></i>
                                Profile
                                <!-- <span>4</span> -->
                                
                            </a>
                        </li>
                        <li class="<?php if($_SERVER['REQUEST_URI']=='/youcloud_dev/address.php'){ echo "active"; } ?>">
                            <a href="address.php">
                                <i class="icon_pin_alt"></i>
                                Address
                               <!--  <span>4</span> -->
                                
                            </a>
                        </li>
                    </ul>
				</aside>