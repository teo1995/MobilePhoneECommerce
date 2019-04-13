<?php
        require_once("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $upit_lokacije="select id_lokacije,Latitude,Longitude,grad,ulica,broj from lokacije_poslovnica";
        $rs_lokacije = $bp->selectDB($upit_lokacije);
        $red_lokacije = array();
        while( $red = $rs_lokacije->fetch_assoc()){
    		$red_lokacije[] = $red;
		}
        header('Content-Type: application/json');
        echo json_encode($red_lokacije);
?>