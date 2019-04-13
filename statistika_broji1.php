<?php
        require_once("baza.class.php");
        $bp = new Baza();    
        $bp->spojiDB();
        $upit_statistika="select (select count(*) from statistika where naziv_statistike='upit_filter') as 'filter', (select count(*) from statistika where naziv_statistike='desc') as 'desc', (select count(*) from statistika where naziv_statistike='upit_zakljucaj') as 'zakljucaj',(select count(*) from statistika where naziv_statistike='upit_odkljucaj') as 'odkljucaj' from statistika  ";
        $rs_stats = $bp->selectDB($upit_statistika);
        $red_stat=array();
        $red=$rs_stats->fetch_assoc();
        $red_stat[]=$red;
        
        echo json_encode($red_stat);
?>