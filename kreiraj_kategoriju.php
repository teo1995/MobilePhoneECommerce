<?php
        include "login.php";
        
        session_start();
        if(!ulogiran()){
            header("location: prijava.php");
        }
        else { 
            if (isset($_POST['submit'])) {
                if(isset($_POST['kategorija'])){
                     $bp = new Baza();
                     $bp->spojiDB();
                     $kategorija=$_POST['kategorija'];
                     $moderator=$_POST['moderator'];
                     $upit_moderator="insert into kategorija_uredaja(id_kategorija,id_moderator,Naziv,datum_kreiranja) values (default, '$moderator', '$kategorija', NOW())  ";
                     $rs_dodaj=$bp->selectDB($upit_moderator);
                     echo "Kategorija uredaja uspjesno dodana";
                }
            }
            if(isset($_POST['submit1'])){
                $bp=new Baza();
                $bp->spojiDB();
                $drzava=$_POST['nazivlokacije'];
                $grad=$_POST['nazivgrada'];
                $ulica=$_POST['nazivulice'];
                $brojulice=$_POST['brojulice'];
                $kategorija1=$_POST['kategorija'];
                $latitude=$_POST['latitude'];
                $longitude=$_POST['longitude'];
                $upit_lokacija="insert into lokacije_poslovnica(id_lokacije,id_kategorija,država,grad,ulica,broj,Latitude,Longitude) values (default,'$kategorija1', '$drzava','$grad','$ulica', '$brojulice','$latitude','$longitude')";
                $rs_dodaj1=$bp->selectDB($upit_lokacija);
                echo "Lokacija uspjesno dodana!";
            }
            if(isset($_POST['submit2'])){
                $bp=new Baza();
                $bp->spojiDB();
                $naziv=$_POST['naziv_ankete'];
                $kategorija_uredaja=$_POST['kategorijaanketa'];
                $opis=$_POST['opis'];
                $upit_dodaj="insert into kategorija_anketa(id_kategorijaanketa,id_kategorija,naziv_kategorije,opis) values (default,'$kategorija_uredaja', '$naziv','$opis')";
                $rs_dodaj2=$bp->selectDB($upit_dodaj);
                echo "Anketa uspjesno dodana!";
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
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
   <body onload="moderatorFunkcija()">
       <div style="background-color: #2A3F54; margin-top: -16px;">
           <figure>
                <img src="img/logo.png" alt="FOI zaglavlje" />
                <?php if(isset($_SESSION['korime_sesija'])){ ?>
                <figcaption><h1> Dobrodošli, <?=$_SESSION['korime_sesija'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?>
                <?php if(isset($_COOKIE['korime_cookie'])){ ?>
                <figcaption><h1> Dobrodošli, <?=$_COOKIE['korime_cookie'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?>
                
           </figure></div>
      
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(ulogiran()==3){
                       navigacijaAdmin1();
                    }
                    ?>
        </nav>
       <section id="sadrzaj">
            <h2>Kreiraj kategoriju</h2>
            <form method="post" action="kreiraj_kategoriju.php" id="forma3">
                <label for="naziv_kategorije">Upisite naziv kategorije uredaja: </label><br>
                <input type="text" id="naziv_kategorije" name="kategorija">
                <p id="pogreskanaziv"></p><br>
                <label for="moderator">Odaberite moderatora: </label><br>
                <select id="moderator" name="moderator"></select>
                <p id="pogreskamoderator"></p><br>
                <input id="gumb" type="submit" name="submit" value="Dodaj kategoriju uredaja"><br><br>
            </form>
            <form method="post" action="kreiraj_kategoriju.php" id="forma4">
                <label for="nazivlokacije">Upisite naziv drzave: </label><br>
                <input type="text" id="nazivlokacije" name="nazivlokacije">
                <p id="pogreskalokacija"></p><br>
                <label for="nazivgrada">Upisite naziv grada: </label><br>
                <input type="text" id="nazivgrada" name="nazivgrada">
                <p id="pogreskagrad"></p><br>
                <label for="nazivulice">Upisite naziv ulice: </label><br>
                <input type="text" id="nazivulice" name="nazivulice">
                <p id="pogreskaulice"></p><br>
                <label for="nazivbroj">Upisite broj ulice: </label><br>
                <input type="text" id="nazivbroj" name="brojulice">
                <p id="pogreskabroj"></p><br>
                <label for="kategorija">Odaberite kategoriju uredaja: </label><br>
                <select id="kategorija" name="kategorija"></select>
                <p id="pogreskakategorija"></p>
                <label for="latitude">Upisite latitude: </label><br>
                <input type="text" id="latitude" name="latitude">
                <p id="pogreskalatitude"></p>
                <label for="longitude">Upisite longitude: </label><br>
                <input type="text" id="longitude" name="longitude">
                <p id="pogreskalongitude"></p><br>
                <input id="gumb" type="submit" name="submit1" value="Dodaj lokaciju"><br><br>
            </form>
            <form method="post" action="kreiraj_kategoriju.php" id="forma5">
                <label for="naziv_ankete">Upisite naziv kategorije ankete: </label><br>
                <input type="text" id="naziv_ankete" name="naziv_ankete">
                <p id="pogreskaanketa"></p><br>
                <label for="kategorijaanketa">Odaberite kategoriju uredaja za anketu: </label><br>
                <select id="kategorijaanketa" name="kategorijaanketa"></select>
                <p id="pogreskakategorijaanketa"></p>
                <label for="opis">Opisite anketu: </label><br>
                <input type="text" id="opis" name="opis">
                <p id="pogreskaopis"></p><br>
                <input id="gumb" type="submit" name="submit2" value="Dodaj kategoriju ankete"><br><br>
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