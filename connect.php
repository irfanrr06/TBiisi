<?php
	$host = "ec2-54-159-107-189.compute-1.amazonaws.com";
	$user = "auaaxatgnkovgt";
	$pass = "1d619629fac625377fb0a78c881539f94215188b55aab34cc93cfcd13d816c98";
	$port = "5432";
	$dbname = "deftk0mqmiisa9";
	$conn = pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$pass) or die("Gagal");
	// header("Access-Control-Allow-Origin: *");
?>