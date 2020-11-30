<?php 
session_start();
include '../connect.php';

$id = $_POST['id'];
$review = $_POST['review'];
$nama = $_SESSION['username'];
$comment = $_POST['comment'];

$cariMax = "select max(id_review) as max from review";
$queryMax = pg_query($cariMax);
$dataMax = pg_fetch_array($queryMax);

$id_review = 0;
if($dataMax['max'] == null){
	$id_review = 1;
} else {
	$id_review = $dataMax['max'] + 1;
}

$tanggal = date("Y-m-d");

$sql = "";
//echo strpos($id,"RMasd");
if(strpos($id,"H") !== false){
	$sql = "insert into review(name,id_hotel,comment,tanggal,id_review) values('$nama','$id','$comment','$tanggal','$id_review')";
} else if(strpos($id,"SO") !== false){
	$sql = "insert into review(name,id_souvenir,comment,tanggal,id_review) values('$nama','$id','$comment','$tanggal','$id_review')";
} else if(strpos($id,"IK") !== false){
	$sql = "insert into review(name,id_ik,comment,tanggal,id_review) values('$nama','$id','$comment','$tanggal','$id_review')";
} else if(strpos($id,"RM") !== false){
	$sql = "insert into review(name,id_kuliner,comment,tanggal,id_review) values('$nama','$id','$comment','$tanggal','$id_review')";
} else if(strpos($id,"tw") !== false){
	$sql = "insert into review(name,id_ow,comment,tanggal,id_review) values('$nama','$id','$comment','$tanggal','$id_review')";
}

$query_sql = pg_query($sql);
// var_dump($sql);
// die();
if($query_sql){
	echo "<script>alert ('Data Successfully Added');</script>";
}else{
	echo "<script>alert ('Error');</script>";
}

echo "<script>
	eval(\"parent.location='gallery.php?idgallery=$id'\");	
	</script>";

?>

