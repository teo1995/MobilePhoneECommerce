<?php
include "login.php";
        session_start();
            ?>
        
<!DOCTYPE html>
<html>
        <head>
        <title>FOI - Web dizajn i programiranje</title>
        <meta charset="UTF-8">
        <meta name="author" content="Kantoci Mateo">
        <meta name="keywords" content="FOI, WebDiP">
        <meta name="description" content="projekt_webdip">
        <meta name="viewport" content="width=device-width">
        <script src="https://maps.googleapis.com/maps/api/js"></script>   
        <script type="text/javascript" src="js/googlemaps.js"></script>
        <link media="screen" href="css/mateo_kantoci.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">        
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>       
    </head>
   <body> 
       <div style="background-color: #2A3F54; margin-top: -16px;">
           <figure>
                <img src="img/logo.png" alt="FOI zaglavlje" />
                <?php if(isset($_SESSION['korime_sesija'])){
                    require_once("baza.class.php");
                    $bp = new Baza();
                    $bp->spojiDB();
                    $korimesesija=$_SESSION['korime_sesija'];
                    $tip_upit="select id_korisnik from korisnici where korime='$korimesesija'";
                    $rs_tip = $bp->selectDB($tip_upit);
                    $red_tip=$rs_tip->fetch_assoc();
                    $korisnik=$red_tip['id_korisnik'];
                    $statistika_index="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik', 'index',NOW())";
                    $rs_statistika=$bp->selectDB($statistika_index);
                    
                    ?>
                <figcaption><h1> Dobrodošli, <?=$_SESSION['korime_sesija'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?>
                <?php if(isset($_COOKIE['korime_cookie'])){ 
                    require_once("baza.class.php");
                    $bp = new Baza();
                    $bp->spojiDB();
                    $korimecookie=$_COOKIE['korime_cookie'];
                    $tip_upit1="select id_korisnik from korisnici where korime='$korimecookie'";
                    $rs_tip1 = $bp->selectDB($tip_upit1);
                    $red_tip1=$rs_tip1->fetch_assoc();
                    $korisnik1=$red_tip1['id_korisnik'];
                    $statistika_index1="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik1', 'index',NOW())";
                    $rs_statistika1=$bp->selectDB($statistika_index1);
                    ?>
                <figcaption><h1> Dobrodošli, <?=$_COOKIE['korime_cookie'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?> 
           </figure></div>
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(ulogiran()==3){
                        navigacijaAdmin3();
                    }
                    if(ulogiran()==2){
                        navigacijaModerator1();
                    }
                    if(ulogiran()==1){
                        navigacijaRegistrirani1();
                    }
                    if(!ulogiran()){
                        neregistriraniKorisnik();
                    }
                    ?>
                    
        </nav>
       <section id="sadrzaj">
            <h2>Google mapa sa lokacijama poslovnica</h2>
            
            <div id="googleMap" style="width:1400px;height:800px;"></div>
        </section>
        <footer>
            <h2>Vrijeme potrebno za rješavanje projekta: 20 sati</h2>
            <a href="https://validator.w3.org/#validate_by_uri+with_options" target="_blank"><img src="img/HTML5.png" alt="HTML logo" width="50" height="50" /></a>
            <a href="http://jigsaw.w3.org/css-validator/" target="_blank"><img src="img/CSS3.png" alt="CSS logo" width="50" height="50" /></a>
            <address>Kontakt: <a href="mailto:matkantoc@foi.hr">Mateo Kantoci</a></address>
            <p>&copy; 2016 M.Kantoci</p>
        </footer>
       </body>
</html>
