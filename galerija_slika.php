<?php
        include "login.php";
        
        session_start();
        if(!ulogiran()){
            header("location: prijava.php");
        }
        else {
            
                 
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    </head>
   <body onload="dodajSliku()">
       
       <div style="background-color: #2A3F54; margin-top: -16px;">
           <figure>
                <img src="img/logo.png" alt="FOI zaglavlje" />
                <?php if(isset($_SESSION['korime_sesija'])){ 
                    $korisnik=$_SESSION['korime_sesija'];
                    ?>
                <figcaption><h1> Dobrodošli, <?=$_SESSION['korime_sesija'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?>
                <?php if(isset($_COOKIE['korime_cookie'])){                     ?>
                <figcaption><h1> Dobrodošli, <?=$_COOKIE['korime_cookie'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?>
                
           </figure></div>
                    
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(ulogiran()==1){
                        navigacijaRegistrirani4();
                    }
                    ?>
        </nav>
       <section id="sadrzaj">
           <h2>Galerija slika</h2>
           <form method="post" action="galerija_slika.php">
                   <input id="filter1" type="submit" name="Filtriraj" value="ASC">
                   <input id="filter" type="submit" name="Filtriraj1" value="DESC"><br>
                   <?php
                   if (isset($_POST['Filtriraj1'])) {
                       $bp = new Baza();
                       $bp->spojiDB();
                       $upit_dozvola1 = "select * from uređaji where zahtjev=1";
                       $rs_dozvola1 = $bp->selectDB($upit_dozvola1);
                       $korimesesija=$_SESSION['korime_sesija'];
                       $tip_upit="select id_korisnik from korisnici where korime='$korisnik'";
                       $rs_tip = $bp->selectDB($tip_upit);
                       $red_tip=$rs_tip->fetch_assoc();
                       $korisnik1=$red_tip['id_korisnik'];
                       $statistika_upit="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik1', 'desc',NOW())";
                       $rs_statistika_upit=$bp->selectDB($statistika_upit);
                       echo '<div class="prihvaceno">';
                       while ($red_dozvola1 = $rs_dozvola1->fetch_assoc()) {
                           echo '<div class="naslov">';
                           echo '<div class="img"><img src="data:image/jpeg;base64,' . base64_encode($red_dozvola1['image']) . '"height="250" width="250">';
                           echo '<div class="desc">' . $red_dozvola1['tag'] . '</div>';
                           echo '</div>';
                           echo '</div>';
                       }
                       echo '</div>';
                   }
                   if (isset($_POST['Filtriraj'])) {
                       $bp = new Baza();
                       $bp->spojiDB();
                       $upit_dozvola2 = "select * from uređaji where zahtjev=1 order by tag asc";
                       $rs_dozvola2 = $bp->selectDB($upit_dozvola2);
                       $korimesesija=$_SESSION['korime_sesija'];
                       $tip_upit="select id_korisnik from korisnici where korime='$korisnik'";
                       $rs_tip = $bp->selectDB($tip_upit);
                       $red_tip=$rs_tip->fetch_assoc();
                       $korisnik1=$red_tip['id_korisnik'];
                       $statistika_upit="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik1', 'upit_filter',NOW())";
                       $rs_statistika_upit=$bp->selectDB($statistika_upit);
                       echo '<div class="prihvaceno">';
                       while ($red_dozvola2 = $rs_dozvola2->fetch_assoc()) {
                           echo '<div class="naslov">';
                           echo '<div class="img"><img src="data:image/jpeg;base64,' . base64_encode($red_dozvola2['image']) . '"height="250" width="250">';
                           echo '<div class="desc">' . $red_dozvola2['tag'] . '</div>';
                           echo '</div>';
                           echo '</div>';
                       }
                       echo '</div>';
                   }
                   ?>
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