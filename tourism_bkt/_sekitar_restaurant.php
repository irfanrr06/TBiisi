<?php

	include('../connect.php');
    $latit = @$_GET['lat'];
    $longi = @$_GET['lng'];
	$rad=@$_GET['rad'];

	$querysearch="SELECT id, name, ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat, ST_DistanceSphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) as jarak FROM restaurant  where ST_DistanceSphere(ST_GeomFromText('POINT(".$longi." ".$latit.")',-1), geom) <= ".$rad.""; 

	$hasil=pg_query($querysearch);

        while($baris = pg_fetch_array($hasil))
            {
                $id=$baris['id'];
                $name=$baris['name'];
                $jarak=$baris['jarak'];
                $lat=$baris['lat'];
                $lng=$baris['lng'];
                $dataarray[]=array('id'=>$id,'name'=>$name,'jarak'=>$jarak, "lat"=>$lat,"lng"=>$lng);
            }
            if(isset($dataarray)){
                echo json_encode ($dataarray);
            }
?>