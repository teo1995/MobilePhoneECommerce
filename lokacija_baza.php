<?php
        require_once("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $kategorija_upit="select id_kategorija,Naziv from kategorija_uredaja";
        $rs_kategorija = $bp->selectDB($kategorija_upit);
        $red_kategorija = array();
        while( $red = $rs_kategorija->fetch_assoc()){
    		$red_kategorija[] = $red;
		}
        header('Content-Type: application/json');
        echo json_encode($red_kategorija);
?>