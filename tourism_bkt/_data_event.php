<?php
require '../connect.php';

$cari = @$_GET["cari"];	//ID

	//DATA HOTEL & TIPE HOTEL
	$querysearch	="SELECT event.id, event.name, event.description, type_event.name as type, ustad.name as ustad, st_x(st_centroid(worship_place.geom)) as lon, st_y(st_centroid(worship_place.geom)) as lat, worship_place.name as worship, worship_place.address, worship_place.capacity from event left join type_event on event.id_type_event=type_event.id left join detail_event on detail_event.id_event=event.id left join ustad on ustad.id=detail_event.id_event left join worship_place on worship_place.id=detail_event.id_worship_place where event.id='$cari'";   
	$hasil=pg_query($querysearch);
	while($baris = pg_fetch_array($hasil)){
		  $id			= $baris['id'];
		  $name			= $baris['name'];
          $description	= $baris['description'];
		  $type			= $baris['type'];
          $ustad		= $baris['ustad'];
		  $worship		= $baris['worship'];
		  $address		= $baris['address'];
		  $capacity		= $baris['capacity'];
		  $lat			= $baris['lat'];
		  $lng			= $baris['lon'];
		  $dataarray[]	=array('id'=>$id,'name'=>$name,'description'=>$description,'type'=>$type,'ustad'=>$ustad,'worship'=>$worship,'address'=>$address,'capacity'=>$capacity, 'lng'=>$lng,'lat'=>$lat);
	}

    //OUTPUT
    $arr=array("data"=>$dataarray);
    echo json_encode($arr);


?>
