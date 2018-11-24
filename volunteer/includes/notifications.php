<?php

/**
 * @Author: indran
 * @Date:   2018-11-22 05:34:25
 * @Last Modified by:   indran
 * @Last Modified time: 2018-11-24 17:22:15
 */


include('../../global.php');  
?><?php  

if (isset($_POST['action'])  &&   isset($_SESSION[ SYSTEM_NAME . 'userid'])  && $_SESSION[ SYSTEM_NAME . 'type'] == 'vsecretary') {


	include_once('../../root/connection.php'); 
	include_once('../../root/functions.php');



	$db=  new Database();
	$message=array(null,null);











	if ($_POST['action'] == 'get-blood-r') {  

		





		?>

		<?php 

		
		$data = selectFromTable('*' , 'nss_camp_reg ' , '  cp_delete = 0 ', $db);
		$datae = selectFromTable('*' , 'nss_event_reg ' , '  event_delete = 0 ', $db);



		?>
		<?php if($data): ?>


			<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
				<i class="fas fa-tint"></i> 
				<span class="count bg-danger"><?php echo sizeof($data) + sizeof($datae); ?></span>
			</a>
			<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
				<a class="dropdown-item py-3 border-bottom">
					<p class="mb-0 font-weight-medium float-left">new <?php echo sizeof($data); ?> camps and  <?php echo sizeof($datae); ?> events  </p>
					<!-- <span class="badge badge-pill badge-primary float-right cursor-pointer" onclick="location.href='admin/brequest'" >View all</span> -->
				</a>

				<?php foreach ($data as $key => $value): ?>

					<a class="dropdown-item preview-item py-3" href="admin/viewcamp/<?php echo  indexMe($value['cp_id']); ?>"   >
						<div class="preview-thumbnail">
							<i class="fas fa-campground text-info"></i>  
						</div>
						<div class="preview-item-content">
							<h6 class="preview-subject font-weight-normal text-dark mb-1"><?php echo isit('cp_name', $value); ?> on <?php echo isit('cp_date_frm', $value); ?> blood</h6>
							<p class="font-weight-light small-text mb-0"> <time class="timeago" datetime="<?php echo isit('cp_date', $value); ?>" title="<?php echo isit('cp_date', $value); ?>">1 hour ago</time>  </p>
						</div>
					</a>
				<?php endforeach; ?>



			</div>



		<?php endif; ?>

		<?php
	}








	if ($_POST['action'] == 'get-notif') { 




		?>

		<?php 

		
		$data = selectFromTable('*' , 'nss_camp_reg ' , '  cp_delete = 0  AND  DATE (CURRENT_TIMESTAMP) <= cp_date_to   ', $db);
		$datae = selectFromTable('*' , 'nss_event_reg ' , '  event_delete = 0 AND  DATE (CURRENT_TIMESTAMP) <= event_date    ', $db);

		if (empty($datae)) {
			$datae = array();
		}
		if ( empty($data) ) {
			$data = array();
		}

		?>
		<?php if( ! empty($data) || ! empty($datae)): ?>


		<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
			<i class="mdi mdi-bell-outline"></i>
			<span class="count bg-success"><?php echo sizeof($data) + sizeof($datae); ?></span>
		</a>
		<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
			<a class="dropdown-item py-3 border-bottom">
				<p class="mb-0 font-weight-medium float-left">new <?php echo sizeof($data); ?> camps and  <?php echo sizeof($datae); ?> events  </p>
				<!-- <span class="badge badge-pill badge-primary float-right cursor-pointer" onclick="location.href='admin/brequest'" >View all</span> -->
			</a>

			<?php foreach ($data as $key => $value): ?>

				<a class="dropdown-item preview-item py-3" href="volunteer/viewcamp/<?php echo  indexMe($value['cp_id']); ?>"   >
					<div class="preview-thumbnail">
						<i class="mdi mdi-basecamp text-warning"></i>
					</div>
					<div class="preview-item-content">
						<h6 class="preview-subject font-weight-normal text-dark mb-1"><?php echo isit('cp_name', $value); ?> on <?php echo isit('cp_date_frm', $value); ?> blood</h6>
						<p class="font-weight-light small-text mb-0"> <time class="timeago" datetime="<?php echo isit('cp_date', $value); ?>" title="<?php echo isit('cp_date', $value); ?>">1 hour ago</time>  </p>
					</div>
				</a>
			<?php endforeach; ?>


			<?php foreach ($datae as $key => $value): ?>

				<a class="dropdown-item preview-item py-3" href="volunteer/viewevent/<?php echo  indexMe($value['event_id']); ?>"   >
					<div class="preview-thumbnail">
						<i class="far fa-calendar-alt text-info"></i> 
					</div>
					<div class="preview-item-content">
						<h6 class="preview-subject font-weight-normal text-dark mb-1"><?php echo isit('event_name', $value); ?> on <?php echo isit('event_date', $value); ?> blood</h6>
						<p class="font-weight-light small-text mb-0"> <time class="timeago" datetime="<?php echo isit('event_ddate', $value); ?>" title="<?php echo isit('event_ddate', $value); ?>">1 hour ago</time>  </p>
					</div>
				</a>
			<?php endforeach; ?>



		</div>



	<?php endif; ?>

	<?php 


}



















































}



?>