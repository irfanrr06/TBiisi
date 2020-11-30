<?php
include ('../../../connect.php');
$id_fasilitas = $_GET['id_fasilitas'];

	
	$sql   = "DELETE from facility_tourism where id='$id_fasilitas'";	
	$delete = pg_query($sql);
	if ($delete){
		echo "<script>alert ('Data Successfully Delete');</script>";
	}
	else{
		echo "<script>alert ('Error');</script>";
	}

	/*	$sql1   = "delete from detail_facility_tourism where id_facility=$id_fasilitas";
	$delete1 = pg_query($sql1);
	if ($delete1){
		echo "<script>alert ('Data Successfully Delete');</script>";
	}
	else{
		echo "<script>alert ('Error');</script>";
	}*/


	echo "<script>eval(\"parent.location='../?page=fasilitas'\");</script>";
?>