<?php
        include "login.php";
        
        session_start();
        if(!ulogiran()){
            header("location: prijava.php");
        }
        else {
            if (isset($_POST['odkljucaj'])) {
                     $bp = new Baza();
                     $bp->spojiDB();
                     $lock=$_POST['lock'];
                     $upit_odkljucaj="update korisnici set status_zakljucan=0 where id_korisnik='$lock'";
                     $rs_odkljucaj=$bp->selectDB($upit_odkljucaj);
                     echo "Korisnik uspjesno odkljucan!";
            }
            if(isset($_POST['zakljucaj'])){
                     $bp = new Baza();
                     $bp->spojiDB();
                     $unlock=$_POST['unlock'];
                     $upit_blokiraj="update korisnici set status_zakljucan=1 where id_korisnik='$unlock'";
                     $rs_blokiraj=$bp->selectDB($upit_blokiraj);
                     echo "Korisnik uspjesno odkljucan!";
            }
            
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
        <link media="screen" href="css/mateo_kantoci.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/matkantoc_jquery.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">        
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10/datatables.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        
    </head>
   <body onload="kreirajTablicu()">
       
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
                    $statistika_index="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik', 'aktivacija',NOW())";
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
                    $statistika_index1="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik1', 'aktivacija',NOW())";
                    $rs_statistika1=$bp->selectDB($statistika_index1);
                    ?>
                <figcaption><h1> Dobrodošli, <?=$_COOKIE['korime_cookie'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?> 
                <?php
                       if(isset($_POST['odkljucaj'])){
                                $tip_upit="select id_korisnik from korisnici where korime='$korimesesija'";
                                $rs_tip = $bp->selectDB($tip_upit);
                                $red_tip=$rs_tip->fetch_assoc();
                                $korisnik1=$red_tip['id_korisnik'];
                                $statistika_upit="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik1', 'upit_odkljucaj',NOW())";
                                $rs_statistika_upit=$bp->selectDB($statistika_upit);
                       }
                       if(isset($_POST['zakljucaj'])){
                                $tip_upit="select id_korisnik from korisnici where korime='$korimesesija'";
                                $rs_tip = $bp->selectDB($tip_upit);
                                $red_tip=$rs_tip->fetch_assoc();
                                $korisnik1=$red_tip['id_korisnik'];
                                $statistika_upit="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik1', 'upit_zakljucaj',NOW())";
                                $rs_statistika_upit=$bp->selectDB($statistika_upit);
                       }
                ?>
           </figure></div>
                    
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(ulogiran()==3){
                    navigacijaAdmin();
                    }
                    ?>
        </nav>
       <section id="sadrzaj">
           <h2>Aktiviraj/blokiraj korisnički račun</h2>
                   <form method="post" action="index_admin.php">
                       
                           <table  class="tablica_klasa">
                           </table> 
                       
                   </form>
                   <form method="post" action="index_admin.php" id="formaodkljucaj">
                       <label for="lock">Odkljucaj korisnicki racun: </label><br>
                       <select id="lock" name="lock"></select>
                       <p id="pogreskalock"></p>
                       <input id="odkljucaj" type="submit" name="odkljucaj" value="Odključaj"><br>
                   </form>
                   <form method="post" action="index_admin.php" id="formazakljucaj">
                       <label for="unlock">Blokiraj korisnicki racun: </label><br>
                       <select id="unlock" name="unlock"></select>
                       <p id="pogreskaunlock"></p>
                       <input id="zakljucaj" type="submit" name="zakljucaj" value="Zaključaj"><br>
                   </form>
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
<?php 
        }
?>