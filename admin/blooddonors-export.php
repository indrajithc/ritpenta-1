<?php

/**
 * @Author: indran
 * @Date:   2018-12-25 18:06:42
 * @Last Modified by:   indran
 * @Last Modified time: 2018-12-25 19:04:03
 */ 
include_once('includes/header.php'); ?>


<?php



?>






<div class="card">
	<div class="card-body">

		<div class="row mb-5">
			<div class="col ">

				<form method="post" action="" data-parsley-validate>
					<div class="form-group row">
						<div class="col-sm-12 col-md-3">
							<label class="form-lable">From date</label>
							<input type="text" class="form-control datetimepicker" data-date-format="YYYY-M-D" name="fdate" value="<?php echo isit('fdate', $_POST); ?>"  placeholder=" Start On" data-parsley-required="true"  > 
						</div>
						<div class="col-sm-12 col-md-3">
							<label class="form-lable">To date</label>
							<input type="text" class="form-control datetimepicker" data-date-format="YYYY-M-D" name="tdate"  value="<?php echo isit('tdate', $_POST); ?>" placeholder=" End On" data-parsley-required="true"  > 
						</div>


						<div class="col-sm-12 col-md-3">
							<label class="form-lable">Blood Group</label>
							<select  type="text" name="group" class="form-control" required  >

								<option disabled  selected  >Select Blood Group ...</option>
								<?php $dsrew32 = "";

								if(isset($_POST['group'])) {
									$dsrew32 = $_POST['group'];
								} 

								?>
								<option  value="*" <?php if( strtolower( $dsrew32) == "*" ) echo " selected "; ?> >All</option>
								<option  value="O+" <?php if( strtolower( $dsrew32) == "o+" ) echo " selected "; ?> >O+ve</option>
								<option  value="O-" <?php if( strtolower( $dsrew32 ) == "o-" ) echo " selected "; ?> >O-ve</option>
								<option  value="B+" <?php if( strtolower( $dsrew32 ) == "b+" ) echo " selected "; ?> >B+ve</option>
								<option  value="B-" <?php if( strtolower( $dsrew32 ) == "b-" ) echo " selected "; ?> >B-ve</option>
								<option  value="A+" <?php if( strtolower( $dsrew32 ) == "a+" ) echo " selected "; ?> >A+ve</option>
								<option  value="A-" <?php if( strtolower( $dsrew32 ) == "a-" ) echo " selected "; ?> >A-ve</option>
								<option  value="AB+" <?php if( strtolower( $dsrew32 ) == "ab+" ) echo " selected "; ?> >AB+ve</option>
								<option  value="AB-" <?php if( strtolower( $dsrew32 ) == "ab-" ) echo " selected "; ?> >AB-ve</option>



							</select>
						</div>


						<div class="col-sm-12 col-md-3">
							<label></label>
							<input type="submit" name="showdata" value="find" class="btn btn-primary btn-block">
						</div>
					</div>
					
				</form>




				<?php  	echo show_error($message); ?>


			</div>
		</div>


		<?php if (isset($_POST['showdata'])):?>
			<?php
			$stmnt=" SELECT v.*, d.branch_or_specialisation, d.name, DATE(v.bd_date) AS ddate FROM `nss_blood_donation` v LEFT JOIN  stud_details d ON v.bd_admno = d.admissionno  WHERE DATE(v.bd_date) BETWEEN '" . $_POST['fdate'] . "' AND '" . $_POST['tdate'] . "'    ORDER BY v.bd_date DESC"; 

			if(strpos( "A+A-B+B-AB-AB+O-O+", $_POST['group'] ) > -1){

				$stmnt=" SELECT v.*, d.branch_or_specialisation, d.name, DATE(v.bd_date) AS ddate FROM `nss_blood_donation` v LEFT JOIN  stud_details d ON v.bd_admno = d.admissionno  WHERE DATE(v.bd_date) BETWEEN '" . $_POST['fdate'] . "' AND '" . $_POST['tdate'] . "'  AND v.bd_group = '".$_POST['group']."'  ORDER BY v.bd_date DESC";
			}

			$details = $db->display($stmnt);

			?>

			<?php if ( $details ):?>



				<div class="row">
					<div class="col-sm-12 ">



						<h1 class="h3 mb-3 font-weight-normal text-dark text-center">blood donors Details</h1>




						<div class="pull-righ text-right float-right mb-5">
							<form action="admin/exportme.php" method="post" >
								<input type="hidden" name="fdate" value="<?php echo $_POST['fdate']; ?>">
								<input type="hidden" name="tdate" value="<?php echo $_POST['tdate']; ?>">
								<input type="hidden" name="group" value="<?php echo $_POST['group']; ?>">

								<input type="submit" name="showdata" value="export" class="btn btn-warning btn-block">
							</form> 
						</div>	 
						<div class="table-responsive">

							<table class="table dataTable table-hover bg-white">
								<thead>
									<tr>
										<th scope="col">Date</th>
										<th scope="col">Quantity</th>
										<th scope="col">BG</th>
										<th scope="col">Name </th>
										<th scope="col">Adm No</th>
										<th scope="col">Department</th>
										<th scope="col">Mobile No</th>
										<th scope="col">Email Id</th>
										<th scope="col"></th> 
									</tr>
								</thead>

								<tbody>



									<?php if ($details ): ?>
										<?php foreach ($details as $key => $value): ?>
											<tr>
												<td><?php echo $value['ddate']; ?></td>
												<td><?php echo $value['bd_quantity']; ?></td>
												<td><?php echo $value['bd_group']; ?></td>
												<td><?php echo $value['name']; ?></td>
												<td><?php echo $value['bd_admno']; ?></td>
												<td><?php echo $value['branch_or_specialisation']; ?></td>
												<td><?php echo $value['bd_mobile']; ?></td>
												<td><?php echo $value['bd_email']; ?></td>


												<td>

													<form accept="" method="post">
														<input type="hidden" name="id" value="<?php echo indexMe( (int) isit('bd_id', $value, 0)); ?>">

													</form>



												</td>
											</tr>



										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>

						</div>




					</div> 
				</div>
				<?php else:  ?>

					<div class="row">
						<div class="col-sm-12 ">
							<div class="alert alert-warning">
								nothing to show !
							</div>
						</div>
					</div>

				<?php endif;  ?>

			<?php endif;  ?>


			<?php

			include_once("includes/footer.php");

			?>

















































