<style type="text/css">
	 @media (min-width: 280px) and (max-width: 640px) {
	 	table{
	 		width: 100%;
	 	}

	}

</style>
<div dir="ltr">
  <div class="gmail_quote"><br><br><u></u>
	<div style="background:#efefee" bgcolor="#efefee">
	 <table border="0" cellspacing="0" cellpadding="0" style="background:#efefee;width: 40%;" align="center" bgcolor="#efefee">
		<tbody>
		  <tr>
			<td style="font-family:arial;font-size:13px;color:#797576;padding:10px 15px;background:#efefee" bgcolor="#efefee">
			 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family:arial;font-size:13px;border: #dddddd solid 1px;background-color: white;border-bottom: none;color:#797576;" >
				<tbody>
					<tr>		
						<td width="20%"></td>
						<td align="center" style="width: 60%;">
							<img src="<?php echo APP_LOGO ?>" style="width: 100%;">
						</td>
						<td width="20%"></td>

						<!-- <td align="left" width="80%">
							
									<span style="font-size:14px;"><b>3236 Genesee St, Cheektowaga, NY 14225, USA</span>
									<br/>
									
									Contact: 716-893-8801 <br>
								    Email : help@foodnai.com  <br>
								    Website: <a href="<?=base_url();?>" style="color:rgb(106,168,79);text-decoration:none;"><?=base_url();?></a></b> 
						</td> -->
					</tr>
					<tr>
						<td colspan="4">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family:arial;font-size:13px;color:#797576">
				<tbody>
					<tr>
					 <td style="padding:30px 20px;padding-bottom:0;background:#ffffff;border:#dddddd solid 1px;border-bottom:none">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family:arial;font-size:13px;color:#585455">
							<tbody>
								<tr>
									<td style="padding-bottom:15px"><b>Hello <?=$user['name'];?>,</b></td>
								</tr>
								<tr>
									<td style="line-height:20px;padding-bottom:10px">						    
									    <p>
									    	We've received a request to reset the password for your <? echo APP_NAME?> account. To reset your password please click on below button. This button takes you to a secure page where you can change your password.
									    </p>
									    	<?php
									    	$key = "iandoof";
									    	$text=$user['id'];
											$encrypted =$key.$text."doofina";
									    	?>
									    	<a href="<?php echo base_url();?>forgot/reset_password?ref=<?=$encrypted;?>" class="btn btn-primary" style="display: inline-block;font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 1px solid transparent !important;padding: 0.375rem 0.75rem;font-size: 0.9375rem;line-height: 1.84615385;border-radius: 3px;background-color: #ec6e09;color: #fff;border-color: #ec6e09;" type="submit">Reset your password</a>
									    <p>
									    	If you don't want to reset your password, please ignore this message. Your password will not be reset. For General inquiries or to request support with your account, please email us on <a style="color: blue;">noreply@youcloudresto.com</a>

									    </p>
									</td>
								</tr>
							</tbody>
						</table>
					  </td>
					</tr>
				</tbody>
			</table>
			<span>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family:arial;font-size:13px;color:#797576">
				<tbody>
				  <tr>
					<td style="padding:5px 15px;background:#ffffff;border:#dddddd solid 1px;border-top:none">
					 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family:arial;font-size:13px;color:#797576">
						<tbody>
							<tr>
								<td style="line-height:20px;padding-bottom:15px;color:#686465">
								  
									<br/>
									Thanks and Regards,<br>
									<p style="padding-left: 15px;"><?php echo APP_NAME ?></p>
									<a href="<?=base_url();?>">
										<img src="<?php echo APP_LOGO ?>" style="width: 70%;">
									</a>		
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			 </tr>
			 <tr>
				 <td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
						<tbody>
							<tr>
								<td style="background:#f37c28" height="5"></td>
								<td style="background:#f2583c" height="5"></td>
								<td style="background:#6390cb" height="5"></td>
								<td style="background:#86d2e0" height="5"></td>
								<td style="background:#fdce0f" height="5"></td>
								<td style="background:#6390cb" height="5"></td>
								<td style="background:#59c8dc" height="5"></td>
							</tr>
						</tbody>
					</table>
				   </td>
			    </tr>
		      </tbody>
	        </table>
			<table width="96%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family:arial;font-size:13px;color:#797576">
			<tbody>
				<tr>
				 <td>
					<table width="400" style="text-align:center" align="center" cellspacing="0" cellpadding="0">
					 <tbody>
					    <tr>
							<td><a href="#" style="color:#585455;font-family:arial;font-size:12px;text-decoration:none;vertical-align:middle"><img src="##base_url##email_templates/images/mail.png" width="13" height="10" style="padding-right:10px;border:none;vertical-align:middle">noreply@youcloudresto.com</a>
							</td>
						</tr>
				       </tbody>
			        </table>
		          </td>
		        </tr>
	        </tbody>
            </table>
            </span>
          </td>
        </tr>
       </tbody>
      </table>
    </div>
  </div>
</div>
