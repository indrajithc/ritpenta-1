<?php

/**
 * @Author: indran
 * @Date:   2018-12-25 18:55:20
 * @Last Modified by:   indran
 * @Last Modified time: 2018-12-25 19:05:55
 */


include_once('../global.php');  
include_once('../root/connection.php');
include_once('../root/functions.php');


auth_login();  

$db=  new Database();
$message=array(null,null);

$file="export.xls";
$test=" "; 
if (isset($_POST['showdata'])) {




	$stmnt=" SELECT v.*, d.branch_or_specialisation, d.name, DATE(v.bd_date) AS ddate FROM `nss_blood_donation` v LEFT JOIN  stud_details d ON v.bd_admno = d.admissionno  WHERE DATE(v.bd_date) BETWEEN '" . $_POST['fdate'] . "' AND '" . $_POST['tdate'] . "'    ORDER BY v.bd_date DESC"; 

	if(strpos( "A+A-B+B-AB-AB+O-O+", $_POST['group'] ) > -1){

		$stmnt=" SELECT v.*, d.branch_or_specialisation, d.name, DATE(v.bd_date) AS ddate FROM `nss_blood_donation` v LEFT JOIN  stud_details d ON v.bd_admno = d.admissionno  WHERE DATE(v.bd_date) BETWEEN '" . $_POST['fdate'] . "' AND '" . $_POST['tdate'] . "'  AND v.bd_group = '".$_POST['group']."'  ORDER BY v.bd_date DESC";
	}

	$details = $db->display($stmnt);


	$test .=
	'<table class="table dataTable table-hover bg-white">'.
	'<thead>'.
	'<tr>'.
	'<th scope="col">Date</th>'.
	'<th scope="col">Quantity</th>'.
	'<th scope="col">BG</th>'.
	'<th scope="col">Name </th>'.
	'<th scope="col">Adm No</th>'.
	'<th scope="col">Department</th>'.
	'<th scope="col">Mobile No</th>'.
	'<th scope="col">Email Id</th>'. 
	'</tr>'.
	'</thead>'.
	''.
	'<tbody>'.
	''.
	''.
	'';
	if ($details ){
		foreach ($details as $key => $value){

			$test .= '<tr>'.
			'<td>' .  $value["ddate"]. '</td>'.
			'<td>' .  $value["bd_quantity"]. '</td>'.
			'<td>' .  $value["bd_group"]. '</td>'.
			'<td>' .  $value["name"]. '</td>'.
			'<td>' .  $value["bd_admno"]. '</td>'.
			'<td>' .  $value["branch_or_specialisation"]. '</td>'.
			'<td>' .  $value["bd_mobile"]. '</td>'.
			'<td>' .  $value["bd_email"]. '</td>'.
			''.
			''.

			'</tr>'.
			''.
			''.
			'';
		}
	}

	$test .= '</tbody>'.
	'</table>';


	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $test;

}
?>