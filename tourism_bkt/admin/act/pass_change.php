<?php
include("../../../connect.php");

$passwordlama = $_POST["passlama"];
$passlama = md5(md5($passwordlama));
$passwordbaru = $_POST["passbaru"];
$passbaru = md5(md5($passwordbaru));
$konfirmasipassword = $_POST["konfirm"];
$username = $_POST["user"];

	$querycek = pg_query("select * from admin where username = '$username' and password = '$passlama'");
	$count = pg_num_rows($querycek);
	echo $count;
	if ($count == 1 && $passwordbaru==$konfirmasipassword){
	$queryupdate = pg_query("update admin set password = '$passbaru' where username = '$username'");
		if($queryupdate){
		echo "<script>alert ('Password Successfully Change');</script>";
		}
	}
	else {
		echo "<script>alert ('Error');</script>";
	}

	echo "<script>
		eval(\"parent.location='../login.php'\");
		</script>";
?>