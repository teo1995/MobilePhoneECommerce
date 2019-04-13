<?php
            require("baza.class.php");
            $bp=new Baza();
            $bp->spojiDB();
            $korime_provjera=$_POST['korime'];
            $korime_provjeri="select korime from korisnici where korime='$korime_provjera'";
            $rs_provjerikorime = $bp->selectDB($korime_provjeri);
            $red_provjeri=$rs_provjerikorime->num_rows;
            echo $red_provjeri;



?>

