<?php
        require("baza.class.php");
        $bp = new Baza();
        $bp->spojiDB();
        $kod=$_GET['prihvati'];
        $upit_prihvati="update uređaji set zahtjev=1 where user_code='$kod'";
        $rs_prihvati=$bp->selectDB($upit_prihvati);
        echo "Prihvatili ste zahtjev za dodavanje novog uredaja! Biti cete preusmjereni na Prijavu za 5 sekundi!";
        header( "refresh:5;url=prijava.php" );
?>

