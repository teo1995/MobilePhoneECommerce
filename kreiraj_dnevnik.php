<?php
            require_once("baza.class.php");
            $bp=new Baza();
            $bp->spojiDB();
            $upit_dnevnik="select * from dnevnik_rada";
            $rs_dnevnik=$bp->selectDB($upit_dnevnik);
            
            $red_dnevnik = array();
            while ($row = $rs_dnevnik->fetch_assoc()) {
                $red_dnevnik[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($red_dnevnik);
            
            

?>

