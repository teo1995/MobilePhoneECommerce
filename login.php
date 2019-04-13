<?php
function ulogiran(){
    if(isset($_SESSION['korime_sesija'])){
        require_once("baza.class.php");
        $bp = new Baza();
        $bp->spojiDB();
        $korimesesija=$_SESSION['korime_sesija'];
        $tip_upit="select id_tip from korisnici where korime='$korimesesija'";
        $rs_tip = $bp->selectDB($tip_upit);
        $red_tip=$rs_tip->fetch_assoc();
        if($red_tip['id_tip']==1){
            return 1;
        }
        if($red_tip['id_tip']==2){
            return 2;
        }
        if($red_tip['id_tip']==3){
            return 3;
        }
    }
    if(isset($_COOKIE['korime_cookie'])){
        require_once("baza.class.php");
        $bp = new Baza();
        $bp->spojiDB();
        $korimesesija1=$_COOKIE['korime_cookie'];
        $tip_upit1="select id_tip from korisnici where korime='$korimesesija1'";
        $rs_tip1 = $bp->selectDB($tip_upit1);
        $red_tip1=$rs_tip1->fetch_assoc();
        if($red_tip1['id_tip']==1){
            return 1;
        }
        if($red_tip1['id_tip']==2){
            return 2;
        }
        if($red_tip1['id_tip']==3){
            return 3;
        }
    }
}
?>
