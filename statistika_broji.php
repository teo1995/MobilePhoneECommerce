<?php
        require_once("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $upit_statistika="select (select count(*) from statistika where naziv_statistike='index') as 'index', (select count(*) from statistika where naziv_statistike='dodaj_uredaj') as 'dodaj_uredaj', (select count(*) from statistika where naziv_statistike='uredaji') as 'uredaji',(select count(*) from statistika where naziv_statistike='aktivacija') as 'aktivacija',(select count(*) from statistika where naziv_statistike='o_autoru') as 'o_autoru' from statistika  ";
        $rs_stats = $bp->selectDB($upit_statistika);
        $red_stat=array();
        $red=$rs_stats->fetch_assoc();
        $red_stat[]=$red;
        
        echo json_encode($red_stat);
?>