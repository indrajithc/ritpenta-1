 
<?php 

include_once('includes/header.php'); ?>




<?php



















if(isset($_POST['submit-btn'])){

	$cp_name         =  $_POST['cp_name'];
	$cp_date_frm        =  $_POST['cp_date_frm'];
	$cp_date_to      =  $_POST['cp_date_to'];
	$cp_details         =  $_POST['cp_details'];
	

	$cp_coordinator_1 = $_POST['cp_coordinator_1'];
	$cp_coordinator_2 = $_POST['cp_coordinator_2'];



	if ($cp_coordinator_1  ==  $cp_coordinator_2) {

		$message [0] = 3;
		$message [1] = ' both coordinators cannot be same '; 



	} else  if(strtotime($cp_date_frm) <= strtotime($cp_date_to)) {





		$stmnt=" SELECT * FROM nss_camp_reg WHERE cp_name= '" . $cp_name ."'   ";





		$result = $db->display( $stmnt);
		if( $result ){

			$message [0] = 2;
			$message [1] = ' cmap name or camp id is already exists'; 

		} else {


			$stmnt =  'insert into nss_camp_reg( cp_name,cp_date_frm,cp_date_to,cp_details) values( :cp_name,:cp_date_frm,:cp_date_to,:cp_details)';





			$params=array(


				':cp_name'        =>  $cp_name,
				':cp_date_frm'       =>  $cp_date_frm,
				':cp_date_to'         =>  $cp_date_to,
				':cp_details'            =>  $cp_details

			);


			$istrue=$db->execute_query_return_id($stmnt,$params);

			if($istrue){
					//$message=' added!';

				$message [0] = 1;
				$message [1] = ' camp added '; 



				$params=array( 
					'cmp_id' 	=> $istrue,
					'cmp_cd_id1'        =>  $cp_coordinator_1,
					'cmp_cd_id2'       =>  $cp_coordinator_2  
				);


				$result = insertInToTable('nss_camp_cordntrs', $params, $db);

				if ($result) {

					$message [0] = 1;
					$message [1] = ' camp and coordinators are added '; 
				}


			}
			else
			{
			//$message=$istrue;	

		// $message=' value already exists';

				$message [0] = 3;
				$message [1] = ' something is wrong'; 
			}

		}


	} else  {

		$message [0] = 4;
		$message [1] = ' end date should not be less than start date '; 
	}



}



?>





<div class="card">
	<div class="card-body">

		<form  id="addcampa"  action="" method="post" class="form-horizontal borderd-row" align="center" data-parsley-validate >

			<h3 class="h3 mb-3 font-weight-normal danger-text">Add Camp Activities</h3>




			<?php echo show_error($message); ?>




			<div class="form-group row">
				<label for="exampleInputName2" class="col-sm-3 col-form-label">Camp Name</label>
				<div class="col-sm-9">
					<input type="name" data-parsley-type="name" class="form-control" name="cp_name" placeholder="Camp Name" data-parsley-required="true"  required>
				</div>
			</div>



			<div class="form-group row">
				<label for="exampleInputName2" class="col-sm-3 col-form-label">Start On</label>
				<div class="col-sm-9">
					<input type="text" class="form-control datetimepicker" data-date-format="YYYY-M-D" name="cp_date_frm" placeholder=" Start On" data-parsley-required="true"  >

				</div>
			</div>

			<div class="form-group row">
				<label for="exampleInputName2" class="col-sm-3 col-form-label">End On</label>
				<div class="col-sm-9">
					<input type="text" class="form-control datetimepicker" data-date-format="YYYY-M-D" name="cp_date_to"  placeholder=" End On" data-parsley-required="true"  >


				</div>
			</div>




			<div class="form-group row">
				<label for="exampleInputName2" class="col-sm-3 col-form-label">Objectives</label>
				<div class="col-sm-9">

					<textarea type="textarea" class="form-control" name="cp_details" placeholder="Objective Of Camp" data-parsley-required="true"   style="height: 100px"></textarea>

				</div>
			</div>




			<h5  class="text-capitalize mt-3 text-left">camp coordinator</h5>


			<?php  
			$result = selectFromTable( ' * ', '  `nss_vol_reg` v LEFT JOIN stud_details s ON v.admnno = s.admissionno   ' , "1  ORDER BY s.courseid, s.branch_or_specialisation , s.name ", $db); ?>


			<div class="form-group row">
				<label for="exampleInputcoordinator12" class="col-sm-3 col-form-label">coordinator 1:</label>
				<div class="col-sm-9">


					<select  id="exampleInputcoordinator12" type="textarea" class="form-control select2" name="cp_coordinator_1" placeholder="first camp coordinator " data-parsley-required="true"   >
						<option selected disabled > select first coordinator  </option>
						<?php if ($result):?>
							<?php foreach ($result as $key => $value): ?>


								<option value="<?php echo $value['vol_id']; ?>"><?php echo ''.$value['name'] . ' ' . $value['admissionno']. ' ' . $value['courseid']. '-' . $value['branch_or_specialisation']; ?></option>



							<?php endforeach;?>
						<?php endif; ?>
						<?php ?>
						<?php ?>


					</select> 
				</div>
			</div>




			<div class="form-group row">
				<label for="exampleInputcoordinator22" class="col-sm-3 col-form-label">coordinator 2:</label>
				<div class="col-sm-9">


					<select  id="exampleInputcoordinator22" type="textarea" class="form-control select2" name="cp_coordinator_2" placeholder="second camp coordinator " data-parsley-required="true"   >
						<option selected disabled > select second coordinator  </option>
						<?php if ($result):?>
							<?php foreach ($result as $key => $value): ?>


								<option value="<?php echo $value['vol_id']; ?>"><?php echo ''.$value['name'] . ' ' . $value['admissionno']. ' ' . $value['courseid']. '-' . $value['branch_or_specialisation']; ?></option>



							<?php endforeach;?>
						<?php endif; ?>
						<?php ?>
						<?php ?>


					</select> 
				</div>
			</div>




			<button type="submit"  class="btn btn-success mr-2 float-right"  name="submit-btn">Submit
			</button>






		</form>

	</div>

</div>

<?php   include_once('includes/footer.php'); ?>
