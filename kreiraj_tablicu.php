<?php
            require_once("baza.class.php");
            $bp=new Baza();
            $bp->spojiDB();
            $upit_sort="select * from korisnici";
            $rs_sort=$bp->selectDB($upit_sort);
            
            $red_tip = array();
            while ($row = $rs_sort->fetch_assoc()) {
                $red_tip[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($red_tip);
            
            

?>

