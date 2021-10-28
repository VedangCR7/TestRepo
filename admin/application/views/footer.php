
                    <!--footer-->
                    <footer class="footer">
                        <div class="container">
                            <div class="row align-items-center flex-row-reverse">
                                <div class="col-md-12 col-sm-12 text-center">
                                    Powered by <a href="<?php echo APP_POWEREDBY_LINK ?>" target="_blank"><?php echo APP_POWEREDBY_TITLE ?></a>: <?php echo APP_POWEREDBY_TEXT ?> <a href="<?php echo APP_POWEREDBY_LINK ?>" target="_blank"><?php echo APP_POWEREDBY_TITLE ?></a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- End Footer-->
                </div>
            </div>
        </div>
		<!-- firebase code>-->
		
		<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
		<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
		<script>
			// Initialize Firebase
			// TODO: Replace with your project's customized code snippet
			var config = {
				messagingSenderId: "879992803349",
				apiKey: "AIzaSyAeCWUbYBzLEBNv0GAeUw9zWL65-RanSKM",
				projectId: "foodnai-ae2e7",
				appId: "1:879992803349:web:18d9469cda74181b743e1c"
			};
			firebase.initializeApp(config);

			const messaging = firebase.messaging();
			messaging
				.requestPermission()
				.then(function () {
					console.log("Notification permission granted.");
					
					// get the token in the form of promise
					return messaging.getToken()
				})
				.then(function(token) {
					console.log('devicetoke : '+token);
					$.ajax({
                            type:"POST",
                            url:"<?=base_url();?>restaurant/setdevicetoken",
                            data:{'token':token},
							success:function(response)
                            {
								console.log(response);
                            }
                        });
				})
				.catch(function (err) {
					console.log("Unable to get permission to notify.", err);
				});

			let enableForegroundNotification = true;
			messaging.onMessage(function(payload) 
			{
				debugger;
				/* alert('message received'); */
				/* console.log("Message received. ", payload); */
				
				let res = JSON.parse(payload.data.notification);				
				getNewOrders();
				
				let orders='';				
				
				let order = JSON.parse(res.body);
				console.log('order ',order);
				let oldOrderCount = $('.new-order-count').html();
				let oldCount = parseInt(oldOrderCount)?oldOrderCount:0;
				oldCount++;
				$('.new-order-count').html(oldCount);
				$('.new-order-count1').html(oldCount);
				$('#new-order-count-inner').html(oldCount);
				document.getElementById('newordersound').play();
				/* var media = new Audio('https://testing.foodnai.com/admin/assets/neworder.mp3');
				media.play();		 */		
				/* $(".new-order-count").animate({zoom: '150%'}, "slow").animate({zoom: '100%'}, "slow");
				document.getElementById('newordersound').play();
				
				var oldorders=$('#new-order-container').html();
							
				
				let orderType = order.order_type=="Online"?1:0;
				orders += '<a class="dropdown-item d-flex pb-4" href="javascript:gotoOrder('+order.id+','+order.table_id+','+order.table_orders_id+','+orderType+');"><span class="avatar brround mr-3 align-self-center avatar-md cover-image bg-primary table-title">'+order.title+'</span><div><span class="font-weight-bold"> '+order.order_no+' | '+order.name+' </span><div class="small text-muted d-flex">'+moment(order.created_at).fromNow()+'<div class="ml-auto"><span class="badge badge-warning">New</span></div></div><div class="progress progress-xs mt-1"><div class="progress-bar bg-primary w-100"></div></div></div></a>';
				

				var newrders= orders+oldorders;
				
				if(orders!='')
				{
					$('#new-order-container').html(newrders);
				}
				else
				{
					$('#new-order-container').html("No new orders available");
				} */
				
				if(enableForegroundNotification) 
				{
					const {title, ...options} = JSON.parse(payload.data.notification);
					navigator.serviceWorker.getRegistrations().then(registration => {
						registration[0].showNotification(title, options);
					});
				}
			});
		</script>		
		
		<!-- firebase code>-->	
        <!-- Back to top -->
        <a href="#top" id="back-to-top"><i class="fas fa-angle-up "></i></a>
       
        <!-- Dashboard Core -->
        <script src="<?=base_url();?>assets/js/vendors/jquery.sparkline.min.js"></script>
        <script src="<?=base_url();?>assets/js/vendors/selectize.min.js"></script>
        <script src="<?=base_url();?>assets/js/vendors/jquery.tablesorter.min.js"></script>
        <script src="<?=base_url();?>assets/js/vendors/circle-progress.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/jquery.rating/jquery.rating-stars.js"></script>

        <!--Bootstrap.min js-->
        <script type="text/javascript" src="<?=base_url();?>assets/js/jquery.validate.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/bootstrap/popper.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <!-- Side menu js -->
        <script src="<?=base_url();?>assets/plugins/sidemenu/js/sidemenu.js"></script>

        <!-- Custom scroll bar Js-->
        <script src="<?=base_url();?>assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/sidemenu/js/left-menu.js"></script>

        <!-- Input Mask Plugin -->
        <script src="<?=base_url();?>assets/plugins/jquery.mask/jquery.mask.min.js"></script>
         <script async src="https://www.googletagmanager.com/gtag/js?id=G-8ZJNB18KS2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'G-8ZJNB18KS2');
        </script>
        <!-- Progress -->
        <script src="<?=base_url();?>assets/js/vendors/circle-progress.min.js"></script>

      

        <!--Echart Plugin -->
        <!-- script src="<?=base_url();?>assets/plugins/echart/echart.js"></script> --> 

        
<!--         <script src="<?=base_url();?>assets/js/highcharts.js"></script> -->


        <!--Jquery.knob js-->
        <!-- <script src="<?=base_url();?>assets/plugins/othercharts/jquery.knob.js"></script>
        <script src="<?=base_url();?>assets/plugins/othercharts/othercharts.js"></script> -->

        <!--Jquery.sparkline js-->
        <script src="<?=base_url();?>assets/plugins/othercharts/jquery.sparkline.min.js"></script>

        <!-- peitychart -->
        <script src="<?=base_url();?>assets/plugins/peitychart/jquery.peity.min.js"></script>

        <!--Counters -->
        <script src="<?=base_url();?>assets/plugins/counters/counterup.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/counters/waypoints.min.js"></script>

        <script src="<?=base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/buttons.html5old.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/buttons.flash.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/dataTables.select.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatables/jszip.min.js"></script>

        <!-- <script src="<?=base_url();?>assets/plugins/datatable/js/jquery.datatables.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/datatables.bootstrap4.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/datatables.buttons.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/buttons.bootstrap4.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/jszip.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/pdfmake.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/vfs_fonts.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/buttons.html5.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/buttons.print.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/js/buttons.colVis.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/datatables.responsive.min.js"></script>
        <script src="<?=base_url();?>assets/plugins/datatable/responsive.bootstrap4.min.js"></script> -->

        <script src="<?=base_url();?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
        <script src="<?=base_url();?>assets/js/sweet-alert.js"></script>
        <!-- Sidebar js -->
        <script src="<?=base_url();?>assets/plugins/sidebar/sidebar.js"></script>
        <script src="<?=base_url();?>assets/js/bootstrap3-typeahead.js"></script>


        <!-- custom js -->
        <script src="<?=base_url();?>assets/js/custom.js"></script>
       <!--  <script src="<?=base_url();?>assets/js/index.js"></script> -->
        <script src="<?=base_url();?>assets/plugins/select2/select2.full.min.js"></script>
        <script src="<?=base_url();?>assets/js/form-validation.js"></script>

		<!-- Custom Delete Script-->
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<!-- End Custom Delete -->

        <script src="<?=base_url();?>assets/plugins/multipleselect/multiple-select.js"></script>
        <script src="<?=base_url();?>assets/js/custom/Common.js"></script>
         <!-- Image Crop plugin -->
        <!-- <script src="<?php echo base_url();?>assets/plugins/croppie/croppie.js"></script> -->
   

        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvxhZ2LCPGerzgsOMPDmrsX7GPUp023AU&libraries=places&callback=initAutocomplete" async defer></script> -->
       <!--  <script src="<?=base_url();?>assets/js/select2.js"></script> -->
        <script type="text/javascript">
                        //alert(localStorage.getItem("showfullscreen"));
            // $(document).click(function(){
            //     if(localStorage.getItem("showfullscreen")){
            //         if (document.documentElement.requestFullScreen) {
            //             document.documentElement.requestFullScreen();
            //         } else if (document.documentElement.mozRequestFullScreen) {
            //             document.documentElement.mozRequestFullScreen();
            //         } else if (document.documentElement.webkitRequestFullScreen) {
            //             document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            //         } else if (document.documentElement.msRequestFullscreen) {
            //             document.documentElement.msRequestFullscreen();
            //         }
            //     } 
            // });
                    
            var old_logged_in="<?=$_SESSION['sess_rand_id'];?>";
            setInterval(function() 
			{
                $.ajax({
                    url: "<?=base_url();?>login/get_session_id/",
                    type:'POST',
                    dataType: 'json',
                    data: {},
                    success: function(result)
					{
                        if(result.status)
						{
                            var new_logged_in=result.id;
                            if(old_logged_in!=new_logged_in)
							{
                                if(result['logged_in'])
								{
                                    console.log(result);
                                    if(result.usertype=="Admin")
                                        window.location.href="<?=base_url();?>admin";
                                    if(result.usertype=="Individual User")
                                        window.location.href="<?=base_url();?>recipes/overview";
                                    if(result.usertype=="Restaurant")
                                        window.location.href="<?=base_url();?>restaurant";
                                    if(result.usertype=="Burger and Sandwich")
                                        window.location.href="<?=base_url();?>restaurant";
                                    if(result.usertype=="Restaurant chain")
                                        window.location.href="<?=base_url();?>company";
									if(result.usertype=="School")
                                        window.location.href="<?=base_url();?>school";
									if(result.usertype=="Restaurant manager")
                                        window.location.href="<?=base_url();?>restaurant";
                                }
								else
								{
                                    window.location.href="<?=base_url();?>login/logout?status=logout";
                                }
                            }
							else
							{
                                if(result['is_active']!=1) 
                                    window.location.href="<?=base_url();?>login/logout?status=inactive";
                            }
                        }
						else
						{
                            window.location.href="<?=base_url();?>login";
                        }                        
                    }
                });
            }, 6000);

            setInterval(function() {
                $.ajax({
                    url: "<?=base_url();?>restaurant/deleteuser",
                    type:'POST',
                    dataType: 'json',
                    data: {},
                    success: function(result){
                        if(result.status){
                            window.location.href="<?=base_url();?>login/logout?status=delete";
                        }
                        
                    }
                });
            }, 6000);
        </script>
    </body>
</html>