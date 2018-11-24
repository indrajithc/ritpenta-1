<?php

/**
 * @Author: indran
 * @Date:   2018-11-22 05:34:25
 * @Last Modified by:   indran
 * @Last Modified time: 2018-11-24 16:35:58
 */


include('../../global.php');  
?><?php  

if (isset($_POST['action'])  &&   isset($_SESSION[ SYSTEM_NAME . 'userid'])  && $_SESSION[ SYSTEM_NAME . 'type'] == 'admin') {


	include_once('../../root/connection.php'); 
	include_once('../../root/functions.php');



	$db=  new Database();
	$message=array(null,null);











	if ($_POST['action'] == 'get-notif') { 

		





		?>

		<?php 

		$details = selectFromTable( '*', ' nss_bg_reqst' , ' req_status = 0 ',$db);

		?>

		<?php if($details): ?>

			<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
				<i class="fas fa-tint"></i> 
				<span class="count bg-danger"><?php echo sizeof($details); ?></span>
			</a>
			<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
				<a class="dropdown-item py-3 border-bottom">
					<p class="mb-0 font-weight-medium float-left">You have <?php echo sizeof($details); ?> new blood requests </p>
					<span class="badge badge-pill badge-primary float-right cursor-pointer" onclick="location.href='admin/brequest'" >View all</span>
				</a>

				<?php foreach ($details as $key => $value): ?>
					<a class="dropdown-item preview-item py-3" href="admin/brequest/<?php echo  indexMe($value['req_id']); ?>"   >
						<div class="preview-thumbnail">
							<i class="fas fa-tint text-danger"></i>  
						</div>
						<div class="preview-item-content">
							<h6 class="preview-subject font-weight-normal text-dark mb-1"><?php echo isit('req_name', $value); ?> request <?php echo isit('req_bg', $value); ?> blood</h6>
							<p class="font-weight-light small-text mb-0"> <time class="timeago" datetime="<?php echo isit('req_date', $value); ?>" title="<?php echo isit('req_date', $value); ?>">1 hour ago</time>  </p>
						</div>
					</a>
				<?php endforeach; ?>


			</div>



		<?php endif; ?>

		<?php
	}





	if ($_POST['action'] == 'get-blood-r') { 







		?>


		<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdowni" href="#" data-toggle="dropdown">
			<i class="mdi mdi-bell-outline"></i>
			<span class="count bg-success">0</span>
		</a>
		<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdowni">
			<a class="dropdown-item py-3 border-bottom">
				<p class="mb-0 font-weight-medium float-left">You have 0 new notifications </p>
				<span class="badge badge-pill badge-primary float-right">View all</span>
			</a>
										<!-- <a class="dropdown-item preview-item py-3">
											<div class="preview-thumbnail">
												<i class="mdi mdi-alert m-auto text-primary"></i>
											</div>
											<div class="preview-item-content">
												<h6 class="preview-subject font-weight-normal text-dark mb-1">Application Error</h6>
												<p class="font-weight-light small-text mb-0"> Just now </p>
											</div>
										</a>
										<a class="dropdown-item preview-item py-3">
											<div class="preview-thumbnail">
												<i class="mdi mdi-settings m-auto text-primary"></i>
											</div>
											<div class="preview-item-content">
												<h6 class="preview-subject font-weight-normal text-dark mb-1">Settings</h6>
												<p class="font-weight-light small-text mb-0"> Private message </p>
											</div>
										</a>
										<a class="dropdown-item preview-item py-3">
											<div class="preview-thumbnail">
												<i class="mdi mdi-airballoon m-auto text-primary"></i>
											</div>
											<div class="preview-item-content">
												<h6 class="preview-subject font-weight-normal text-dark mb-1">New user registration</h6>
												<p class="font-weight-light small-text mb-0"> 2 days ago </p>
											</div>
										</a> -->
									</div>


									<?php
								}



















































							}



							?>