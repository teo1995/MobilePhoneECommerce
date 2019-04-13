<?php
        require("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $upit_status="select id_korisnik,ime,status_zakljucan from korisnici where status_zakljucan=1";
        $rs_status = $bp->selectDB($upit_status);
        $red_status = array();
        while( $row = $rs_status->fetch_assoc()){
    		$red_status[] = $row;
		}
        header('Content-Type: application/json');
        echo json_encode($red_status);
?>