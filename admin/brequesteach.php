<?php

/**
 * @Author: indran
 * @Date:   2018-11-24 12:41:48
 * @Last Modified by:   indran
 * @Last Modified time: 2018-11-24 16:46:57
 */ 
//(?=<!--)(.*)(?=-->)(.*)(?=\n)




include_once('includes/header.php');


$id = -1;
if (isset($_GET['id'])) {
	$id = unIndexMe($_GET['id']);

}


if (   $id == -1) {

	setLocation("admin/brequest"); 
}




?>

<?php

if (isset($_POST['make_read'])) {


	$id = isit('id', $_POST, 0);
	$id = unIndexMe((int) $id );

	// if($_POST['make_delete'] == 1)
	$action = 1;


	$params = array(
		'req_status' => $action
	); 

	$istrue = updateTable( 'nss_bg_reqst', $params, ' req_id = ' . $id , $db);

	if($istrue){

		$message [0] = 1;
		$message [1] = ' updated ';  

	}  else {

		$message [0] = 4;
		$message [1] = ' update error ';  
	}
	



}

?>

<?php
$allREqst =array();
if (isset($_POST['request'])) {
	// var_dump($_POST);
	$to_all = "";

	foreach ($_POST['request'] as $key => $value) {
		if(	$to_all  )
			$to_all .= ", ";
		$to_all .=  "'$value'"; 
	} 
	$allREqst = selectFromTable('*', 'stud_details', " admissionno IN ( $to_all )  ", $db);



}


?>

<?php if( ! empty($allREqst )): ?>

	<div class="alert alert-success">
		<div class="list-group">

			<?php foreach ($allREqst as $key => $value): ?>
				<div class="list-group-item mt-1">
					<p> message sent to <?php echo $value['name']; ?> [<?php echo $value['admissionno']; ?> ] - <?php echo $value['branch_or_specialisation']; ?></p>
				</div>
			<?php endforeach; ?> 
			
		</div>
	</div>



<?php endif; ?>

<div class="row">
	<div class="col-sm-12 px-3  bg-white ">



		<div class="page-header">
			<div class="h3 mb-3 bg-primary text-white d-flex flex-row"><h1 class="w-75"> Complete Details</h1>
				<p class="flex-shrink text-right w-25 px-3 py-2" id="nowtime">

				</p>
			</div>


		</div>




		<?php


		$stmnt=" SELECT * FROM `nss_bg_reqst`   WHERE req_id = :id AND req_status = 0 ";

		$params = array (
			':id' => $id
		);


		$details = $db->display($stmnt,  $params );

		if (isset(  $details[0])) {
			$details =   $details[0];
		}  else {

			
			setLocation("admin/brequest");
		}

		?>

		<?php if($details): ?>

			<script type="text/javascript">
				$(document).ready(function($) {
					$('#nowtime').html('<time class="timeago" datetime="<?php echo isit('req_date', $details); ?>" title="<?php echo isit('req_date', $details); ?>">1 hour ago</time> </td> ');
				});
			</script>


			<div class="row">
				<div class="col-sm-12 col-md-8 offset-md-2">




					<table class="table table-hover w-100">
						<tbody>

							<tr>
								<th scope="col">Name</th>
								<td> 
									<?php echo  isit( 'req_name', $details); ?>
								</td>
							</tr>
							<tr>
								<th scope="col">email	</th>
								<td> 
									<?php echo  isit( 'req_email', $details); ?>
								</td>
							</tr>
							<tr>
								<th scope="col">Group</th>
								<td> 
									<?php echo  isit( 'req_bg', $details); ?>
								</td>
							</tr>
							<tr>
								<th scope="col">Address</th>
								<td> 
									<address><?php echo  isit( 'req_loc', $details); ?></address>
								</td>
							</tr>
							<tr>
								<td colspan="2">

									<form accept="" method="post">
										<input type="hidden" name="id" value="<?php echo indexMe( (int) isit('req_id', $details, 0)); ?>">

										<button class="btn btn-sm btn-warning btn-block"  name="make_read" value="1">readed</button>

									</form>

								</td>
							</tr>

						</tbody>


					</table>










				</div>
			</div>
			<div class="row">
				<div class="col-12">






					<h5 class="text-capitalize mt-5 text-left"><strong>event coordinators</strong></h5>
					<form method="post" action="" id="action-do">


						<div class="row">


							<div class="col-md-3 col-sm-6 px-2">
								<button class="btn btn-sm btn-block btn-success" type="button" id="check0">check all</button>  
							</div>
							<div class="col-md-3 col-sm-6 px-2">
								<button class="btn btn-sm btn-block btn-danger" type="button" id="check1">uncheck all</button>  
							</div>
							<div class="col-md-6 col-sm-6 px-2">
								<button class="btn btn-sm btn-block btn-primary"  type="button"id="check-go">alert selected</button>  
							</div>
						</div>
						<table class="table border">
							<thead>
								<tr>  
									<th scope="col">Last On </th>
									<th scope="col">Name </th>
									<th scope="col">Mobile No</th>
									<th scope="col">Adm No</th>
									<th scope="col text-primary">selected</th> 
									<th scope="col">Department</th>
									<th scope="col">Email Id</th>
								</tr>
							</thead>

							<tbody>

								<?php
								$stmnt=" SELECT v.*, d.branch_or_specialisation, d.name, DATE(v.bd_date) AS ddate FROM `nss_blood_donation` v LEFT JOIN  stud_details d ON v.bd_admno = d.admissionno  WHERE v.bd_group = '".isit( 'req_bg', $details)."' AND CURRENT_TIMESTAMP > DATE_ADD(v.bd_date , INTERVAL 3 MONTH)   ORDER BY v.bd_date DESC";

								$details = $db->display($stmnt);

								?>

								<?php if ($details ): ?>
									<?php foreach ($details as $key => $value): ?>
										<tr>  
											<td><?php echo $value['ddate']; ?></td>
											<td><?php echo $value['name']; ?></td>
											<td><?php echo $value['bd_mobile']; ?></td>
											<td><?php echo $value['bd_admno']; ?></td>

											<td class="text-center"> 

												<input type="checkbox"  style="width: 2rem;height: 2rem;" name="request[]" value="<?php echo $value['bd_admno']; ?>">



											</td>

											<td><?php echo $value['branch_or_specialisation']; ?></td>
											<td><?php echo $value['bd_email']; ?></td>


										</tr>



									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</form>




				</div>
			</div>
		<?php endif; ?>

	</div> 
</div>












<?php include_once('includes/footer.php'); ?>




<script type="text/javascript">
	$(document).ready(function($) {



// =======================================================
// ======================================================================================================================
// ======================================================================================================================



$(document).on('click', '#check0', function(event) {
	event.preventDefault(); 
	$('#action-do').find('input[type=checkbox]').each(function(index, el) {
		$(this).prop('checked', true);
	});
});


$(document).on('click', '#check1', function(event) {
	event.preventDefault(); 
	$('#action-do').find('input[type=checkbox]').each(function(index, el) {
		$(this).prop('checked', false);
	});
});


$(document).on('click', '#check-go', function(event) {
	event.preventDefault(); 
	$dr = true;
	$('#action-do').find('input[type=checkbox]').each(function(index, el) {  
		if($(this).prop("checked") == true){
			$dr = false; 
		} 
	});

	if($dr) {
		Lobibox.notify('warning', { 
			size: 'mini',
			icon: false,
			title: 'missing values',
			msg: 'select at least one student.'
		});
		return;
	}

	$('#action-do').submit();


});

// ======================================================================================================================
// ======================================================================================================================
// ======================================================================================================================

});
</script>
