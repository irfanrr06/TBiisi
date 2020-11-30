
<?php
require '../connect.php';
//$gid=@$_GET['gid'];
$querysearch= "SELECT id, name FROM tourism_type order by id asc";

$hasil=pg_query($querysearch);
while($baris = pg_fetch_array($hasil))
	{
		$id=$baris['id'];
        $name=$baris['name'];
        $dataarray[]=array('id'=>$id,'name'=>$name);
    }
echo json_encode ($dataarray);
?>
