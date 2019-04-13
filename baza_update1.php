<?php
        require_once("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $id_kor=$_GET['id_select'];
        $upit_update="select * from korisnici where id_korisnik='$id_kor'";
        $rs_update = $bp->selectDB($upit_update);
        $red_update = array();
        while( $red = $rs_update->fetch_assoc()){
    		$red_update[] = $red;
		}
        header('Content-Type: application/json');
        echo json_encode($red_update);
?>