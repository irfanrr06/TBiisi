<?php
include ('../../../connect.php');

$query = pg_query("SELECT MAX(id) AS id FROM facility_tourism");
$result = pg_fetch_array($query);
$idmax = $result['id'];
if ($idmax==null) {$idmax=1;}
else {$idmax++;}

$fasilitas = $_POST['fasilitas'];
$count = count($fasilitas);
$sql  = "insert into facility_tourism (id, name) VALUES "; 

for( $i=0; $i < $count; $i++ ){
	$sql .= "('{$idmax}','{$fasilitas[$i]}')";
	$sql .= ",";
	$idmax++;
}
$sql = rtrim($sql,",");
$insert = pg_query($sql);

if ($sql){
	echo "<script>
	alert ('Data Successfully Added');
	</script>";
}else{
	echo "<script>
	alert ('Error');
	</script>";
}

	echo "<script>
	eval(\"parent.location='../index.php?page=fasilitas '\");	
	</script>";
?>