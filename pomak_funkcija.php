<?php
        function pomakvremena(){
        require_once("baza.class.php");
        $bp = new Baza();
        $bp->spojiDB();
        $upit_pomak="select pomak from pomak_vremena";
        $rs_pomak=$bp->selectDB($upit_pomak);
        $red_pomak = $rs_pomak -> fetch_assoc();
        $vrijednost_pomaka = intval($red_pomak['pomak']);
        $trenutnovrijeme = time();
        $pretvoreno_vrijeme = $trenutnovrijeme + ($vrijednost_pomaka * 60 * 60);
        $vrijeme_sustava = date('Y-m-d H:i:s', $pretvoreno_vrijeme);  
        return $vrijeme_sustava;
        }
        ?>