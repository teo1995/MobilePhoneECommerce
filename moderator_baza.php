<?php
        require("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $ime_tip_upit="select id_korisnik,ime from korisnici where id_tip=2";
        $rs_tip = $bp->selectDB($ime_tip_upit);
        $red_tip = array();
        while( $row = $rs_tip->fetch_assoc()){
    		$red_tip[] = $row;
		}
        header('Content-Type: application/json');
        echo json_encode($red_tip);
?>