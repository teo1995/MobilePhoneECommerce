<?php
        include "login.php";
        require("pomak_funkcija.php");
        session_start();
        if(!ulogiran()){
            header("location: prijava.php");
        }
        else {
            if (isset($_POST['submit'])) {
                        $bp = new Baza();
                        $bp->spojiDB();
                        $sesija=$_SESSION['korime_sesija'];
                        $korisnik="select id_korisnik from korisnici where korime='$sesija'";
                        $rs_korisnik=$bp->selectDB($korisnik);
                        $red_kor=$rs_korisnik->fetch_array();
                        $pomak=  pomakvremena();
                        $dnevnik_rada2="insert into dnevnik_rada values(default,'$red_kor[0]', '$pomak', 'zahtjev_za_uredaj')";
                        $rs_dnevnik=$bp->selectDB($dnevnik_rada2);
                        $nazivuredaja=$_POST['nazivuredaja'];
                        $cijenauredaja=$_POST['cijenauredaja'];
                        $kamera=$_POST['kamera'];
                        $gprs=$_POST['gprs'];
                        $bluetooth=$_POST['bluetooth'];
                        $baterija=$_POST['baterija'];
                        $kategorija_reg=$_POST['kategorija_reg'];
                        $korime=$_SESSION['korime_sesija'];
                        $sifra = ($korime.date("Y-m-d_h:i:sa"));
                        $hash_kod=hash("md5",$sifra);
                        $upit_uredaj="insert into uređaji(id_uređaji, id_kategorija, naziv_uređaja,cijena,kamera, GPRS, Bluetooth,Baterija,zahtjev,user_code, korime) values(default, '$kategorija_reg','$nazivuredaja','$cijenauredaja','$kamera','$gprs','$bluetooth','$baterija', default,'$hash_kod','$korime')";
                        $rs_uredaj=$bp->selectDB($upit_uredaj);
                        $id_moderatora=$_POST['kategorija_reg'];
                        $upit_moderator="select id_moderator from kategorija_uredaja,uređaji where kategorija_uredaja.id_kategorija=uređaji.id_kategorija and uređaji.id_kategorija='$id_moderatora' ";
                        $rs_moderator=$bp->selectDB($upit_moderator);
                        $red_moderator=$rs_moderator->fetch_assoc();
                        $id_moderator=$red_moderator['id_moderator'];
                        $upit_email="select email from korisnici where id_korisnik='$id_moderator' ";        
                        $rs_mail=$bp->updateDB($upit_email);  
                        $red_mail=$rs_mail->fetch_assoc();
                        $primatelj = $red_mail['email'];
                        $subject1 = "Dodavanje uredaja";
                        $forma=array($nazivuredaja,$cijenauredaja,$kamera,$gprs,$bluetooth,$baterija,$kategorija_reg);
                        $link = "http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x035/prihvati_uredaj.php?prihvati=".$hash_kod;
                        $link1= "http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x035/odbij_zahtjev.php?prihvati=".$hash_kod;
                        $poruka = "Uredaj: " . print_r($forma,true) . "\n\n Prihvati: " . $link . "\n\n Odbij: " . $link1 ;
                        $naslov1 = "From:" . $primatelj;
                        mail($primatelj,$subject1,$poruka,$naslov1);
                        echo "E-mail je uspješno poslan. U prozoru vidi uređaje će vam biti prikazani odbijeni/prihvaćeni uređaji!";
                        
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    </head>
   <body onload="dodajUredaj()">
       
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
                    $statistika_index="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik', 'dodaj_uredaj',NOW())";
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
                    $statistika_index1="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik1', 'dodaj_uredaj',NOW())";
                    $rs_statistika1=$bp->selectDB($statistika_index1);
                    ?>
                <figcaption><h1> Dobrodošli, <?=$_COOKIE['korime_cookie'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?> 
           </figure></div>
                    
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(ulogiran()==1){
                        navigacijaRegistrirani();
                    }
                    ?>
        </nav>
       <section id="sadrzaj">
           <h2>Dodaj uređaj</h2>
           <form id="posalji" method="post" action="dodaj_uredaj.php">
                <label for="kategorija_reg">Odaberite kategoriju: </label><br>
                <select id="kategorija_reg" name="kategorija_reg"></select><br><br>
                <label for="nazivuredaja">Naziv uredaja: </label><br>
                <input type="text" id="nazivuredaja" name="nazivuredaja">
                <p id="pogreskanazivuredaja"></p><br>
                <label for="cijenauredaja">Cijena uredaja: </label><br>
                <input type="text" id="cijenauredaja" name="cijenauredaja">
                <p id="pogreskacijenauredaja"></p><br>
                <label for="kamera">Kamera: </label><br>
                <input type="text" id="kamera" name="kamera">
                <p id="pogreskakamera"></p><br>
                <label for="gprs">GPRS: </label><br>
                <input type="text" id="gprs" name="gprs">
                <p id="pogreskagprs"></p><br>
                <label for="bluetooth">Bluetooth: </label><br>
                <input type="text" id="bluetooth" name="bluetooth">
                <p id="pogreskabluetooth"></p><br>
                <label for="baterija">Baterija: </label><br>
                <input type="text" id="baterija" name="baterija">
                <p id="pogreskabaterija"></p>
                <label for="gumb">Kliknite na gumb kako biste zatrazili zahtjev za dodavanjem novog uredaja: </label>  
                <input id="gumb" type="submit" name="submit" value="Posalji zahtjev"><br>
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