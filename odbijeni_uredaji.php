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
                <?php if(isset($_SESSION['korime_sesija'])){?>
                <figcaption><h1> Dobrodošli, <?=$_SESSION['korime_sesija'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?>
                <?php if(isset($_COOKIE['korime_cookie'])){?>
                <figcaption><h1> Dobrodošli, <?=$_COOKIE['korime_cookie'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?> 
           </figure></div>
                    
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(ulogiran()==1){
                        navigacijaRegistrirani5();
                    }
                    ?>
        </nav>
       <section id="sadrzaj">
           <form action="uredaji.php" method="POST" enctype="multipart/form-data">
                        <h2>Odbijeni uređaji</h2>
           <?php
                        require_once("baza.class.php");
                        $bp=new Baza();
                        $bp->spojiDB();
                        $upit_dozvola="select * from uređaji where zahtjev=0";
                        $rs_dozvola=$bp->selectDB($upit_dozvola);
                        echo '<div class="odbijeno">';
                        while( $red_dozvola=$rs_dozvola->fetch_assoc()){
                               echo '<div class="naslov">';
                               echo '<h1>'. $red_dozvola['naziv_uređaja'] . '</h2>';
                               echo '<p>Cijena uređaja: ' . $red_dozvola['cijena'] . '</p>';
                               echo '<p>Kamera: ' . $red_dozvola['kamera'] . '</p>';
                               echo '<p>GPRS: ' . $red_dozvola['GPRS'] . '</p>';
                               echo '<p>Bluetooth: ' . $red_dozvola['Bluetooth'] . '</p>';
                               echo '<p>Baterija: ' . $red_dozvola['Baterija'] . '</p>';
                               echo '</div>';
                        }
                        echo '</div>';
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