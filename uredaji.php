<?php
        include "login.php";
        require("pomak_funkcija.php");
        session_start();
        if(!ulogiran()){
            header("location: prijava.php");
        }
        else {
            if(isset($_POST['submit'])){
                    $bp = new Baza();
                    
                    $imeslike=mysqli_real_escape_string($bp->spojiDB(),$_FILES["image"]["name"]);
                    $dataslike=mysqli_real_escape_string($bp->spojiDB(),file_get_contents($_FILES["image"]["tmp_name"]));
                    $vrstaslike=mysqli_real_escape_string($bp->spojiDB(),$_FILES["image"]["type"]);
                    $sesija=$_SESSION['korime_sesija'];
                    $korisnik="select id_korisnik from korisnici where korime='$sesija'";
                    $rs_korisnik=$bp->selectDB($korisnik);
                    $red_kor=$rs_korisnik->fetch_array();
                    $pomak=  pomakvremena();
                    $dnevnik_rada2="insert into dnevnik_rada values(default,'$red_kor[0]', '$pomak', 'dodana_slika')";
                    $rs_dnevnik=$bp->selectDB($dnevnik_rada2);
                    $id_uređaj=$_POST["mob_uredaj"];
                    $tag=$_POST['tag'];
                    if(substr($vrstaslike,0,5)=="image"){
                        $upit="update uređaji set name='$imeslike', image='$dataslike', tag='$tag' where id_uređaji='$id_uređaj'";
                        $rs_upit=$bp->selectDB($upit);
                        echo "Uspjesno ste uploadali sliku!";
                        
                    }
                    else{
                        echo "dozvoljene su samo slike";
                    }
                       
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
   <body onload="dodajSliku()">
       
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
                    $statistika_index="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik', 'uredaji',NOW())";
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
                    $statistika_index1="insert into statistika(id_statistika,id_korisnik,naziv_statistike,datum) values (default, '$korisnik1', 'uredaji',NOW())";
                    $rs_statistika1=$bp->selectDB($statistika_index1);
                    ?>
                <figcaption><h1> Dobrodošli, <?=$_COOKIE['korime_cookie'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?> 
           </figure></div>
                    
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(ulogiran()==1){
                        navigacijaRegistrirani3();
                    }
                    ?>
        </nav>
       <section id="sadrzaj">
           <h2>Prihvaćeni uređaji</h2>
          
           <form action="uredaji.php" method="POST" enctype="multipart/form-data">
               <?php
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
               <label for="mob_uredaj">Odaberite mobilni uredaj: </label><br>
               <select id="mob_uredaj" name="mob_uredaj"></select><br>
               <input type="text" id="tag" name="tag"  placeholder="tag"><br>
               <input type="file" name="image"><br>
               <input type="submit" name="submit" value="Upload"><br>
               
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