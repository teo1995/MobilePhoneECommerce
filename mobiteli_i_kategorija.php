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
                 
           </figure></div>
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(!ulogiran()){
                        neregistriraniKorisnik2();
                    }
                    ?>
                    
        </nav>
       <section id="sadrzaj">
           <h2>Mobilni uređaji</h2>
          <?php
                        require_once("baza.class.php");
                        $bp = new Baza();
                        $bp->spojiDB();
                        $upit_dozvola1="select * from uređaji where zahtjev=1";
                        $rs_dozvola1=$bp->selectDB($upit_dozvola1);
                        echo '<div class="prihvaceno">';
                        while ($red_dozvola1 = $rs_dozvola1->fetch_assoc()) {
                           echo '<div class="naslov">';
                           echo '<div class="img"><img src="data:image/jpeg;base64,' . base64_encode($red_dozvola1['image']) . '"height="250" width="250">';
                           echo '<div class="desc">' . $red_dozvola1['naziv_uređaja'] . '</div>';
                           echo '<div class="desc"> Cijena uređaja: ' . $red_dozvola1['cijena'] . '</div>';
                           echo '<div class="desc"> Kamera: ' . $red_dozvola1['kamera'] . '</div>';
                           echo '<div class="desc"> GPRS: ' . $red_dozvola1['GPRS'] . '</div>';
                           echo '<div class="desc"> Bluetooth: ' . $red_dozvola1['Bluetooth'] . '</div>';
                           echo '<div class="desc"> Baterija: ' . $red_dozvola1['Baterija'] . '</div>';
                           echo '</div>';
                           echo '</div>';
                       }
                       echo '</div>';
                        
          ?>
           
           
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
