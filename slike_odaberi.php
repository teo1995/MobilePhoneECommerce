<?php
        require_once("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $upit_slike="select *from uređaji where zahtjev=1";
        $rs_slike = $bp->selectDB($upit_slike);
        $red_slike = array();
        while( $red = $rs_slike->fetch_assoc()){
    		$red_slike[] = $red;
		}
        header('Content-Type: application/json');
        echo json_encode($red_slike);
?>