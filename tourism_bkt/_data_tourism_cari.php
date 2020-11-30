<?php
require '../connect.php';

$tipe   = $_GET["tipe"];	// Cari berdasarkan apa
$nilai  = $_GET["nilai"];	// Isi yang dicari
$nilai2 = $_GET["nilai2"];	// Isi yang dicari
$nilai3 = $_GET["nilai3"];	// Isi yang dicari
$rad    = $_GET["rad"];	// rad yang dicari

/*
ISI TIPE:
	1 => Nama
	2 => Alamat
	3 => Harga Tiket
	4 => Tipe tourism
	5 => Fasilitas
*/

if ($tipe == 1) {
	$querysearch	="SELECT id, name, st_x(st_centroid(geom)) as lon ,st_y(st_centroid(geom)) as lat  from tourism where  LOWER(name) like '%' || LOWER('$nilai') || '%'";
} elseif ($tipe == 2) {
	$querysearch	="SELECT id, name, st_x(st_centroid(geom)) as lon ,st_y(st_centroid(geom)) as lat  from tourism where  LOWER(address) like '%' || LOWER('$nilai') || '%'";
} elseif ($tipe == 3) {
	$querysearch	="SELECT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,st_y(st_centroid(tourism.geom)) as lat  from tourism left join tourism_type on tourism_type.id = tourism.id_type where tourism.id_type = '$nilai'";
} elseif ($tipe == 4) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,st_y(st_centroid(tourism.geom)) as lat from tourism left join detail_facility_tourism on detail_facility_tourism.id_tourism=tourism.id left join facility_tourism on facility_tourism.id = detail_facility_tourism.id_facility where facility_tourism.id IN ($nilai)";
} elseif ($tipe == 5) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,st_y(st_centroid(tourism.geom)) as lat FROM worship_place left JOIN detail_facility ON worship_place.id=detail_facility.id_worship_place left JOIN facility ON detail_facility.id_facility=facility.id left JOIN facility_condition ON facility_condition.id=detail_facility.id_facility_condition left JOIN tourism ON ST_DistanceSphere(ST_Centroid(worship_place.geom), ST_Centroid(tourism.geom)) < $rad WHERE facility.id IN ($nilai)";
	$qswp = "SELECT distinct worship_place.id, worship_place.name, st_x(st_centroid(worship_place.geom)) as lon ,st_y(st_centroid(worship_place.geom)) as lat  from worship_place left join detail_facility on detail_facility.id_worship_place=worship_place.id left join facility on facility.id = detail_facility.id_facility  JOIN tourism ON ST_DistanceSphere(ST_Centroid(worship_place.geom), ST_Centroid(tourism.geom)) < $rad WHERE facility.id IN ($nilai)";
} elseif ($tipe == 6) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,st_y(st_centroid(tourism.geom)) as lat FROM culinary_place left JOIN detail_facility_culinary ON culinary_place.id=detail_facility_culinary.id_culinary_place left JOIN facility_culinary ON detail_facility_culinary.id_facility=facility_culinary.id left JOIN detail_culinary ON culinary_place.id=detail_culinary.id_culinary_place left JOIN culinary ON detail_culinary.id_culinary=culinary.id left JOIN tourism ON ST_DistanceSphere(ST_Centroid(culinary_place.geom), ST_Centroid(tourism.geom)) < $rad WHERE culinary.id IN ($nilai2) AND facility_culinary.id IN ($nilai)";
	$qscp = "SELECT distinct culinary_place.id, culinary_place.name, st_x(st_centroid(culinary_place.geom)) as lon ,st_y(st_centroid(culinary_place.geom)) as lat  from culinary_place left join detail_facility_culinary on detail_facility_culinary.id_culinary_place=culinary_place.id left join facility_culinary on facility_culinary.id = detail_facility_culinary.id_facility left JOIN detail_culinary ON culinary_place.id=detail_culinary.id_culinary_place left JOIN culinary ON detail_culinary.id_culinary=culinary.id JOIN tourism ON ST_DistanceSphere(ST_Centroid(culinary_place.geom), ST_Centroid(tourism.geom)) < $rad where culinary.id IN ($nilai2) AND facility_culinary.id IN ($nilai)";
} elseif ($tipe == 7) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,st_y(st_centroid(tourism.geom)) as lat, district.name as d FROM tourism JOIN district ON ST_Within(tourism.geom, district.geom) JOIN small_industry ON ST_DistanceSphere(ST_Centroid(small_industry.geom), ST_Centroid(tourism.geom)) < $rad JOIN industry_type ON small_industry.id_industry_type=industry_type.id WHERE LOWER(district.name) like '%' || LOWER('$nilai') || '%' AND LOWER(industry_type.name) like '%' || LOWER('$nilai2') || '%'";
	$qssi	="SELECT DISTINCT small_industry.id, small_industry.name, st_x(st_centroid(small_industry.geom)) as lon ,st_y(st_centroid(small_industry.geom)) as lat, district.name as d FROM tourism JOIN district ON ST_Within(tourism.geom, district.geom) JOIN small_industry ON ST_DistanceSphere(ST_Centroid(small_industry.geom), ST_Centroid(tourism.geom)) < $rad JOIN industry_type ON small_industry.id_industry_type=industry_type.id WHERE LOWER(district.name) like '%' || LOWER('$nilai') || '%' AND LOWER(industry_type.name) like '%' || LOWER('$nilai2') || '%'";
} elseif ($tipe == 8) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,
	st_y(st_centroid(tourism.geom)) as lat FROM hotel
	left JOIN detail_facility_hotel ON hotel.id=detail_facility_hotel.id_hotel 
	left JOIN facility_hotel ON detail_facility_hotel.id_facility=facility_hotel.id 
	left JOIN hotel_type ON hotel.id_type=hotel_type.id 
	left JOIN tourism ON ST_DistanceSphere(ST_Centroid(hotel.geom), ST_Centroid(tourism.geom))
	< $rad WHERE hotel_type.id IN ($nilai2) AND facility_hotel.id IN ($nilai)";
	$qsh	="SELECT DISTINCT hotel.id, hotel.name, st_x(st_centroid(hotel.geom)) as lon ,st_y(st_centroid(hotel.geom)) as lat FROM hotel left JOIN detail_facility_hotel ON hotel.id=detail_facility_hotel.id_hotel left JOIN facility_hotel ON detail_facility_hotel.id_facility=facility_hotel.id left JOIN hotel_type ON hotel.id_type=hotel_type.id JOIN tourism ON ST_DistanceSphere(ST_Centroid(hotel.geom), ST_Centroid(tourism.geom)) < $rad WHERE hotel_type.id IN ($nilai2) AND facility_hotel.id IN ($nilai)";
} elseif ($tipe == 9) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon, st_y(st_centroid(tourism.geom)) as lat, district.name as d FROM tourism JOIN district ON ST_Within(tourism.geom, district.geom) JOIN souvenir ON ST_DistanceSphere(ST_Centroid(souvenir.geom), ST_Centroid(tourism.geom)) < $rad JOIN souvenir_type ON souvenir.id_souvenir_type=souvenir_type.id JOIN detail_product_souvenir ON souvenir.id=detail_product_souvenir.id_souvenir JOIN product_souvenir ON detail_product_souvenir.id_product=product_souvenir.id WHERE LOWER(district.name) like '%' || LOWER('$nilai') || '%' AND LOWER(product_souvenir.product) like '%' || LOWER('$nilai2') || '%'";
	$qss	="SELECT DISTINCT souvenir.id, souvenir.name, st_x(st_centroid(souvenir.geom)) as lon, st_y(st_centroid(souvenir.geom)) as lat, district.name as d FROM tourism JOIN district ON ST_Within(tourism.geom, district.geom) JOIN souvenir ON ST_DistanceSphere(ST_Centroid(souvenir.geom), ST_Centroid(tourism.geom)) < $rad JOIN souvenir_type ON souvenir.id_souvenir_type=souvenir_type.id JOIN detail_product_souvenir ON souvenir.id=detail_product_souvenir.id_souvenir JOIN product_souvenir ON detail_product_souvenir.id_product=product_souvenir.id WHERE LOWER(district.name) like '%' || LOWER('$nilai') || '%' AND LOWER(product_souvenir.product) like '%' || LOWER('$nilai2') || '%'";
} elseif ($tipe == 10) {
	$querysearch	="SELECT distinct tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,st_y(st_centroid(tourism.geom)) as lat , district.name as d  from tourism JOIN district ON ST_Within(tourism.geom, district.geom) JOIN culinary_place ON ST_DistanceSphere(ST_Centroid(tourism.geom), ST_Centroid(culinary_place.geom)) < $rad left JOIN detail_culinary ON culinary_place.id=detail_culinary.id_culinary_place left JOIN culinary ON detail_culinary.id_culinary=culinary.id JOIN tourism_type ON tourism.id_type=tourism_type.id where LOWER(district.name) like '%' || LOWER('$nilai') || '%' AND LOWER(tourism_type.name) like '%' || LOWER('$nilai2') ||'%' AND LOWER(culinary.name) like '%' || LOWER('$nilai3') ||'%' GROUP BY (tourism.id, district.name)";
	$qsr	="SELECT distinct culinary_place.id, culinary_place.name, st_x(st_centroid(culinary_place.geom)) as lon ,st_y(st_centroid(culinary_place.geom)) as lat , district.name as d  from tourism JOIN district ON ST_Within(tourism.geom, district.geom) JOIN culinary_place ON ST_DistanceSphere(ST_Centroid(tourism.geom), ST_Centroid(culinary_place.geom)) < $rad left JOIN detail_culinary ON culinary_place.id=detail_culinary.id_culinary_place left JOIN culinary ON detail_culinary.id_culinary=culinary.id JOIN tourism_type ON tourism.id_type=tourism_type.id where LOWER(district.name) like '%' || LOWER('$nilai') || '%' AND LOWER(tourism_type.name) like '%' || LOWER('$nilai2') ||'%' AND LOWER(culinary.name) like '%' || LOWER('$nilai3') ||'%' GROUP BY (culinary_place.id, district.name)";
} elseif ($tipe == 11) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon, st_y(st_centroid(tourism.geom)) as lat, district.name as d FROM tourism JOIN district ON ST_Within(tourism.geom, district.geom) JOIN culinary_place ON ST_DistanceSphere(ST_Centroid(culinary_place.geom), ST_Centroid(tourism.geom)) < $rad JOIN detail_culinary ON culinary_place.id=detail_culinary.id_culinary_place JOIN culinary ON detail_culinary.id_culinary=culinary.id JOIN detail_culinary_place ON culinary_place.id=detail_culinary_place.id_culinary_place JOIN detail_tourism ON tourism.id=detail_tourism.id_tourism WHERE LOWER(district.name) like '%' || LOWER('$nilai') || '%' AND detail_culinary.price < $nilai2";
	$qsr	="SELECT DISTINCT culinary.id, culinary.name, st_x(st_centroid(culinary_place.geom)) as lon, st_y(st_centroid(culinary_place.geom)) as lat, district.name as d FROM tourism JOIN district ON ST_Within(tourism.geom, district.geom) JOIN culinary_place ON ST_DistanceSphere(ST_Centroid(culinary_place.geom), ST_Centroid(tourism.geom)) < $rad JOIN detail_culinary ON culinary_place.id=detail_culinary.id_culinary_place JOIN culinary ON detail_culinary.id_culinary=culinary.id JOIN detail_culinary_place ON culinary_place.id=detail_culinary_place.id_culinary_place JOIN detail_tourism ON tourism.id=detail_tourism.id_tourism WHERE LOWER(district.name) like '%' || LOWER('$nilai') || '%' AND detail_culinary.price < $nilai2";
} elseif ($tipe == 12) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, ST_X(ST_Centroid(tourism.geom)) AS lon, ST_Y(ST_Centroid(tourism.geom)) AS lat FROM tourism JOIN detail_tourism ON tourism.id=detail_tourism.id_tourism JOIN angkot ON detail_tourism.id_angkot=angkot.id JOIN tourism_type ON tourism.id_type=tourism_type.id JOIN detail_facility_tourism ON tourism.id=detail_facility_tourism.id_tourism JOIN facility_tourism ON detail_facility_tourism.id_facility=facility_tourism.id WHERE tourism_type.id='$nilai' AND facility_tourism.name like '%$nilai2%' AND angkot.id='$nilai3'";
	$qsa	="SELECT DISTINCT angkot.id, angkot_color.color FROM tourism JOIN detail_tourism ON tourism.id=detail_tourism.id_tourism JOIN angkot ON detail_tourism.id_angkot=angkot.id JOIN tourism_type ON tourism.id_type=tourism_type.id JOIN detail_facility_tourism ON tourism.id=detail_facility_tourism.id_tourism JOIN facility_tourism ON detail_facility_tourism.id_facility=facility_tourism.id JOIN angkot_color ON angkot.id_color=angkot_color.id WHERE tourism_type.id='$nilai' AND facility_tourism.name like '%$nilai2%' AND angkot.id='$nilai3'";
} elseif ($tipe == 13) {
	$querysearch	="SELECT DISTINCT tourism.id, tourism.name, ST_X(ST_Centroid(tourism.geom)) AS lon, ST_Y(ST_Centroid(tourism.geom)) AS lat FROM tourism JOIN detail_tourism ON tourism.id=detail_tourism.id_tourism JOIN angkot ON detail_tourism.id_angkot=angkot.id JOIN culinary_place ON ST_DistanceSphere(ST_Centroid(tourism.geom), ST_Centroid(culinary_place.geom)) < $rad JOIN detail_facility_culinary ON culinary_place.id=detail_facility_culinary.id_culinary_place JOIN facility_culinary ON detail_facility_culinary.id_facility=facility_culinary.id WHERE tourism.ticket <= $nilai AND facility_culinary.facility LIKE '%$nilai2%' AND angkot.id='$nilai3'";
	$qsa	="SELECT DISTINCT angkot.id, angkot_color.color FROM tourism JOIN detail_tourism ON tourism.id=detail_tourism.id_tourism JOIN angkot ON detail_tourism.id_angkot=angkot.id JOIN culinary_place ON ST_DistanceSphere(ST_Centroid(tourism.geom), ST_Centroid(culinary_place.geom)) < $rad JOIN detail_facility_culinary ON culinary_place.id=detail_facility_culinary.id_culinary_place JOIN facility_culinary ON detail_facility_culinary.id_facility=facility_culinary.id JOIN angkot_color ON angkot.id_color=angkot_color.id WHERE tourism.ticket <= $nilai AND facility_culinary.facility LIKE '%$nilai2%' AND angkot.id='$nilai3'";
	$qscp	="SELECT DISTINCT culinary_place.id, culinary_place.name, ST_X(ST_Centroid(culinary_place.geom)) AS lon, ST_Y(ST_Centroid(culinary_place.geom)) AS lat FROM tourism JOIN detail_tourism ON tourism.id=detail_tourism.id_tourism JOIN angkot ON detail_tourism.id_angkot=angkot.id JOIN culinary_place ON ST_DistanceSphere(ST_Centroid(tourism.geom), ST_Centroid(culinary_place.geom)) < $rad JOIN detail_facility_culinary ON culinary_place.id=detail_facility_culinary.id_culinary_place JOIN facility_culinary ON detail_facility_culinary.id_facility=facility_culinary.id WHERE tourism.ticket <= $nilai AND facility_culinary.facility LIKE '%$nilai2%' AND angkot.id='$nilai3'";
} elseif ($tipe == 14) {
	$querysearch	="SELECT distinct tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,st_y(st_centroid(tourism.geom)) as lat from tourism JOIN tourism_type ON tourism.id_type = tourism_type.id WHERE tourism_type.id = '$nilai' AND tourism.open >= '$nilai2' AND tourism.close <= '$nilai3'";
} elseif ($tipe == 15) {
	$querysearch	="SELECT distinct tourism.id, tourism.name,tourism.ticket, st_x(st_centroid(tourism.geom)) as lon, st_y(st_centroid(tourism.geom)) as lat FROM tourism WHERE tourism.ticket < $nilai";
} elseif ($tipe == 16) {
	$querysearch	="SELECT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon, st_y(st_centroid(tourism.geom)) as lat from tourism JOIN detail_facility_tourism ON tourism.id = detail_facility_tourism.id_tourism JOIN facility_tourism ON detail_facility_tourism.id_facility = facility_tourism.id WHERE facility_tourism.name like '%$nilai%' AND tourism.ticket < $nilai2";
} elseif ($tipe == 17) {
	$querysearch	="SELECT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon, st_y(st_centroid(tourism.geom)) as lat from tourism JOIN tourism_type ON tourism.id_type = tourism_type.id WHERE tourism_type.id = '$nilai' AND tourism.ticket < $nilai2";
} elseif ($tipe == 18) {
	$querysearch	="SELECT tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon, st_y(st_centroid(tourism.geom)) as lat from tourism WHERE tourism.address like '%$nilai%' AND tourism.ticket < $nilai2";
} elseif ($tipe == 19) {
	$querysearch	="SELECT distinct tourism.id, tourism.name, st_x(st_centroid(tourism.geom)) as lon ,st_y(st_centroid(tourism.geom)) as lat from tourism JOIN detail_tourism ON detail_tourism.id_tourism=tourism.id JOIN detail_worship_place ON detail_tourism.id_angkot=detail_worship_place.id_angkot JOIN angkot ON detail_tourism.id_angkot=angkot.id JOIN worship_place ON detail_worship_place.id_worship_place=worship_place.id JOIN category_worship_place ON worship_place.id_category=category_worship_place.id JOIN detail_facility ON worship_place.id=detail_facility.id_worship_place JOIN facility ON detail_facility.id_facility=facility.id WHERE category_worship_place.id='$nilai' AND facility.id IN($nilai2)";
	$qswp	="SELECT distinct worship_place.id, worship_place.name, st_x(st_centroid(worship_place.geom)) as lon ,st_y(st_centroid(worship_place.geom)) as lat from tourism JOIN detail_tourism ON detail_tourism.id_tourism=tourism.id JOIN detail_worship_place ON detail_tourism.id_angkot=detail_worship_place.id_angkot JOIN angkot ON detail_tourism.id_angkot=angkot.id JOIN worship_place ON detail_worship_place.id_worship_place=worship_place.id JOIN category_worship_place ON worship_place.id_category=category_worship_place.id JOIN detail_facility ON worship_place.id=detail_facility.id_worship_place JOIN facility ON detail_facility.id_facility=facility.id WHERE category_worship_place.id='$nilai' AND facility.id IN($nilai2)";
	$qsa	="SELECT distinct angkot.id, angkot_color.color from tourism JOIN detail_tourism ON detail_tourism.id_tourism=tourism.id JOIN detail_worship_place ON detail_tourism.id_angkot=detail_worship_place.id_angkot JOIN angkot ON detail_tourism.id_angkot=angkot.id JOIN worship_place ON detail_worship_place.id_worship_place=worship_place.id JOIN category_worship_place ON worship_place.id_category=category_worship_place.id JOIN detail_facility ON worship_place.id=detail_facility.id_worship_place JOIN facility ON detail_facility.id_facility=facility.id JOIN angkot_color ON angkot.id_color=angkot_color.id WHERE category_worship_place.id='$nilai' AND facility.id IN($nilai2)";
}
// die($querysearch);

$hasil=pg_query($querysearch);
$dataarray = [];
$data = [];
while($baris = pg_fetch_assoc($hasil)){
	if($baris['id'] != NULL){
		$id=$baris['id'];
		$name=$baris['name'];
		$lng=$baris['lon'];
		$lat=$baris['lat'];
		$data[]=array('id'=>$id,'name'=>$name,'lng'=>$lng,'lat'=>$lat);
	}
}
$dataarray['tourism']=$data;
if(isset($qswp)){ // Worship Place
	$data = [];
	$hasil=pg_query($qswp);
	while($baris = pg_fetch_assoc($hasil)){
		if($baris['id'] != NULL){
			$id=$baris['id'];
			$name=$baris['name'];
			$lng=$baris['lon'];
			$lat=$baris['lat'];
			$data[]=array('id'=>$id,'name'=>$name,'lng'=>$lng,'lat'=>$lat);
		}
	}
	$dataarray['worship_place']=$data;
}
if(isset($qscp)){ // Culinary Place
	$data = [];
	$hasil=pg_query($qscp);
	while($baris = pg_fetch_assoc($hasil)){
		if($baris['id'] != NULL){
			$id=$baris['id'];
			$name=$baris['name'];
			$lng=$baris['lon'];
			$lat=$baris['lat'];
			$data[]=array('id'=>$id,'name'=>$name,'lng'=>$lng,'lat'=>$lat);
		}
	}
	$dataarray['culinary_place']=$data;
}
if(isset($qsh)){ // Hotel
	$data = [];
	$hasil=pg_query($qsh);
	while($baris = pg_fetch_assoc($hasil)){
		if($baris['id'] != NULL){
			$id=$baris['id'];
			$name=$baris['name'];
			$lng=$baris['lon'];
			$lat=$baris['lat'];
			$data[]=array('id'=>$id,'name'=>$name,'lng'=>$lng,'lat'=>$lat);
		}
	}
	$dataarray['hotel']=$data;
}
if(isset($qssi)){ // Small Industry
	$data = [];
	$hasil=pg_query($qssi);
	while($baris = pg_fetch_assoc($hasil)){
		if($baris['id'] != NULL){
			$id=$baris['id'];
			$name=$baris['name'];
			$lng=$baris['lon'];
			$lat=$baris['lat'];
			$data[]=array('id'=>$id,'name'=>$name,'lng'=>$lng,'lat'=>$lat);
		}
	}
	$dataarray['small_industry']=$data;
}
if(isset($qss)){ // Souvenir
	$data = [];
	$hasil=pg_query($qss);
	while($baris = pg_fetch_assoc($hasil)){
		if($baris['id'] != NULL){
			$id=$baris['id'];
			$name=$baris['name'];
			$lng=$baris['lon'];
			$lat=$baris['lat'];
			$data[]=array('id'=>$id,'name'=>$name,'lng'=>$lng,'lat'=>$lat);
		}
	}
	$dataarray['souvenir']=$data;
}
if(isset($qsr)){ // Restaurant
	$data = [];
	$hasil=pg_query($qsr);
	while($baris = pg_fetch_assoc($hasil)){
		if($baris['id'] != NULL){
			$id=$baris['id'];
			$name=$baris['name'];
			$lng=$baris['lon'];
			$lat=$baris['lat'];
			$data[]=array('id'=>$id,'name'=>$name,'lng'=>$lng,'lat'=>$lat);
		}
	}
	$dataarray['restaurant']=$data;
}
if(isset($qsa)){ // Angkot
	$data = [];
	$hasil=pg_query($qsa);
	while($baris = pg_fetch_assoc($hasil)){
		if($baris['id'] != NULL){
			$id=$baris['id'];
			$color=$baris['color'];
			$data[]=array('id'=>$id, 'color'=>$color);
		}
	}
	$dataarray['angkot']=$data;
}
echo json_encode ($dataarray);
?>
