<?php
        require("pomak_funkcija.php");
        include "login.php";
        session_start();
        if(ulogiran()==3){
            header("location: index_admin.php");
            exit();
        }
        if(ulogiran()==2){
            header("location: ankete.php");
            exit();
        }
        if(ulogiran()==1){
            header("location: dodaj_uredaj.php");
            exit();
        }
        if (!isset($_SERVER['HTTPS']) || strtolower($_SERVER["HTTPS"]) != "on") {
            $url = 'https://' . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            header("Location: $url");
            exit();
        }
        if (isset($_POST['submit_form'])) {
            $korime_prijava=$_POST['korime'];
            $lozinka_prijava=$_POST['lozinka'];
            $zapamti_me=(isset($_POST['checkbox']) ? $_POST['checkbox'] : null);
            require("baza.class.php");
            $bp = new Baza();
            $bp->spojiDB();
            $korime_lozinka="select korime,lozinka,status_zakljucan,id_tip,id_korisnik from korisnici where korime='$korime_prijava' and lozinka='$lozinka_prijava'";
            $rs_korimelozinka = $bp->selectDB($korime_lozinka);
            $red_korimelozinka=$rs_korimelozinka->fetch_array();
            $korime_aktivacija="select status,korime from aktivacijakod,korisnici where aktivacijakod.id_korisnik=korisnici.id_korisnik and korime='$korime_prijava'";
            $rs_aktivacija=$bp->selectDB($korime_aktivacija);
            $red_aktivacija=$rs_aktivacija->fetch_array();
            if($korime_prijava==$red_korimelozinka[0] && $lozinka_prijava==$red_korimelozinka[1] && $red_korimelozinka>0 && $red_korimelozinka[2]=='0' && $red_aktivacija[0]=='1'){
                $korime_ponisti="update korisnici set broj_pogresaka=0 where korime='$korime_prijava'";
                $rs_ponisti=$bp->selectDB($korime_ponisti);
                $pomak=  pomakvremena();
                if($zapamti_me=="on"){
                    setcookie("korime_cookie",$korime_prijava, time()+7200);
                }
                else if($zapamti_me==""){
                    $_SESSION['korime_sesija']=$korime_prijava;
                    //setcookie("korime1_cookie", $korime_prijava, time()+7200);
                }
                if($red_korimelozinka[3]==3){
                $dnevnik_rada="insert into dnevnik_rada values(default,'$red_korimelozinka[4]', '$pomak', 'prijava admin')";
                $rs_dnevnik=$bp->selectDB($dnevnik_rada);
                header("location: index_admin.php");
                exit; }
                if($red_korimelozinka[3]==2){
                $dnevnik_rada1="insert into dnevnik_rada values(default,'$red_korimelozinka[4]', '$pomak', 'prijava moderator')";
                $rs_dnevnik=$bp->selectDB($dnevnik_rada1);
                header("location: ankete.php");
                exit;   }
                if($red_korimelozinka[3]==1){
                $dnevnik_rada2="insert into dnevnik_rada values(default,'$red_korimelozinka[4]', '$pomak', 'prijava reg_korisnik')";
                $rs_dnevnik=$bp->selectDB($dnevnik_rada2);
                header("location: dodaj_uredaj.php");
                exit;
                }
            }
            else if($red_aktivacija[0]=='0'){
                    echo "Racun nije aktiviran!";
                }
            else{
                $korime_upit="update korisnici set broj_pogresaka=broj_pogresaka + 1 where korime='$korime_prijava'";
                $korime_brojac="select broj_pogresaka from korisnici where korime='$korime_prijava'";
                $rs_upit=$bp->selectDB($korime_upit);
                $rs_brojac=$bp->selectDB($korime_brojac);
                $red_brojac=$rs_brojac->fetch_array();
                $brojac=(int)$red_brojac[0];
                if($brojac>3){
                    $korime_postavi="update korisnici set status_zakljucan=1 where broj_pogresaka='$brojac'";
                    $rs_postavi=$bp->selectDB($korime_postavi);
                    echo "Previse puta ste unijeli krivu lozinku, korisnicki racun je deaktiviran!";
                }
                
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
    </head>
   <body> 
       <div style="background-color: #2A3F54; margin-top: -16px;">
           <figure>
                <img src="img/logo.png" alt="FOI zaglavlje" />
           </figure></div>
      
       <nav>
            <ul class="navigacija">
                <li><a href="index.php" class="stranica">POČETNA STRANICA</a></li>
                <li><a href="mobiteli_i_kategorija.php" class="stranica">MOBILNI UREĐAJI</a></li>
                <li><a href="registracija.php" class="stranica">REGISTRACIJA</a></li> 
                <li><a href="prijava.php" class="stranica" id="prijava">PRIJAVA</a></li>
                <li><a href="privatno/korisnici_baza.php" class="stranica">POPIS KORISNIKA .htaccess</a></li>
                <li><a href="dokumentacija.html" class="stranica">DOKUMENTACIJA</a></li>
                <li><a href="o_autoru.php" class="stranica">O AUTORU</a></li>
                </ul>
        </nav>
       <section id="sadrzaj">
            <h2>Prijava</h2>
            <form id="forma1" method="post" name="forma" action="prijava.php">
                Korisničko ime: 
                <input type="text" id="korime" name="korime" size="10"  placeholder="korisničko ime"><br>
                <p id="pogreskakorime"></p>
                Lozinka:
                <input type="password" id="lozinka" name="lozinka" placeholder="lozinka"  ><br>
                <p id="pogreskalozinka"></p>
                Zapamti me:
                <input type="checkbox" name="checkbox"><br> 
                Slanje podataka:               
                <input id="pošalji" type="submit" name="submit_form"><br>
                <a id="reset" href="resetiraj_lozinku.php">Zaboravljena lozinka</a>
                <p id="svipodaci"></p>
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
