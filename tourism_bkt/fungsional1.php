<?php

    include('../connect.php');
    $latit = @$_GET['lat'];
    $lng   = @$_GET['lng'];
    $rad   = @$_GET['rad'];

    $q = "SELECT worship_place.id as wpid, event.id, event.name, ST_X(ST_Centroid(worship_place.geom)) AS lng, ST_Y(ST_Centroid(worship_place.geom)) As lat, event.description, type_event.name as tipe, worship_place.name as masjid, ustad.name as ustad FROM event JOIN type_event ON type_event.id=event.id_type_event JOIN detail_event ON event.id=detail_event.id_event JOIN worship_place ON detail_event.id_worship_place=worship_place.id JOIN ustad ON detail_event.id_ustad=ustad.id WHERE ST_DistanceSphere(ST_Centroid(worship_place.geom), ST_GeomFromText('POINT($lng $latit)',-1)) < $rad";
    // die($q);
    $hasil=pg_query($q);
        while($baris = pg_fetch_array($hasil))
            {
                $id     = $baris['id'];
                $name   = $baris['name'];
                $desc   = $baris['description'];
                $tipe   = $baris['tipe'];
                $masjid = $baris['masjid'];
                $ustad  = $baris['ustad'];
                $lat    = $baris['lat'];
                $lng    = $baris['lng'];
                $wpid   = $baris['wpid'];

                $dataarray[] = array(
                    'id'     => $id,
                    'name'   => $name,
                    'desc'   => $desc,
                    'tipe'   => $tipe,
                    'masjid' => $masjid,
                    'ustad'  => $ustad,
                    'lat'    => $lat,
                    'lng'    => $lng,
                    'wpid'   => $wpid
                );
            }
            if(isset($dataarray)){
                echo json_encode ($dataarray);
            }