<?php
                require("baza.class.php");
                require("pomak_funkcija.php");
                $bp = new Baza();
                $bp->spojiDB();
                
                $aktivacijskikod = $_GET['aktivacija'];
                $pomak=  strtotime(pomakvremena());
                $upit_zaaktivaciju= "select datum, id_korisnik from aktivacijakod where aktivacijski_kljuc ='$aktivacijskikod'";
                $rs_zaaktivaciju=$bp->selectDB($upit_zaaktivaciju);
                $red=$rs_zaaktivaciju->fetch_array();
                $datum=strtotime($red[0]);
                $id=$red[1];
                $vrijeme=3000;
                if($pomak - $datum < $vrijeme){
                    $upit = "UPDATE aktivacijakod SET status = '1' WHERE aktivacijski_kljuc='".$aktivacijskikod."'";
                    $rs3=$bp->selectDB($upit);
                    echo ("Link je uspjesno aktiviran!");
                    header("refresh:5; url= http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x035/prijava.php?uspjeh=da&id=".$id);
                }
                else{
                    echo ("Link za aktivaciju je istekao!");
                    header("refresh:5; url= http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x035/prijava.php?uspjeh=ne");
                }
?>

