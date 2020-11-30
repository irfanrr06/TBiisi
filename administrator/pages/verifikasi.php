<?php
include ('../../../connect.php');

$edit = pg_query("update admin set role='C' where username='@$_GET[user]'");

if($edit){
	header('location:http://localhost/postgresql_12/hotel_bkt/admin/login.php');
}
