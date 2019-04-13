<?php
        require_once("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $upit_update="select * from korisnici";
        $rs_update = $bp->selectDB($upit_update);
        $red_update = array();
        while( $red = $rs_update->fetch_assoc()){
    		$red_update[] = $red;
		}
        header('Content-Type: application/json');
        echo json_encode($red_update);
?>