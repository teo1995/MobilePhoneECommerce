<?php
                 if(isset($_POST['g-recaptcha-response'])&& $_POST['g-recaptcha-response']){
                 var_dump($_POST);
                 $secret = "6LcxzB4TAAAAAJM3Xi23k8OyE_gX0f9C4hJZGoH1";
                 $ip = $_SERVER['REMOTE_ADDR'];
                 $captcha = $_POST['g-recaptcha-response'];
                 $rsp  = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
                 var_dump($rsp);
                 $arr = json_decode($rsp,TRUE);
                 }
                ?>
<?php
            $greska1="";
            $greskalozinka="";
            $greskapotlozinka="";
            $greskaime="";
            $greskaprezime="";
            $greskadan="";
            $greskamjesec="";
            $greskagodina="";
            $greskaemail="";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["korime"])) {
                    $greska1 = "Niste unijeli korisnicko ime!";
                } else {
                    if (!preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/", $_POST["korime"])) {
                        $greska1 = "Korisnicko ime mora sadrzavati jedno malo i veliko slovo, jedan broj te jedan specijalni znak!!";
                    }}
                if(empty($_POST["lozinka"])){
                    $greskalozinka="Niste unijeli lozinku!";
                } else{
                    if(!preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}/", $_POST["lozinka"])){
                        $greskalozinka="Lozinka mora sadrzavati jedno malo i veliko slovo, jedan broj te jedan specijalni znak!";
                    }
                    }
                if(empty($_POST["potlozinke"])){
                    $greskapotlozinka="Unesite lozinku ponovno!";
                }  else{
                    if($_POST["potlozinke"] !== $_POST["potlozinke"]){
                        $greskapotlozinka="Lozinke se ne podudaraju!";
                    }
                }
                if(empty($_POST["ime"])){
                    $greskaime="Niste unijeli ime!";
                }  else{
                    $_POST["ime"];
                }
                if(empty($_POST["prezime"])){
                    $greskaprezime="Niste unijeli prezime!";
                }  else{
                    $_POST["prezime"];
                }
                if(empty($_POST["dan"])){
                    $greskadan="Niste unijeli dan rodenja!";
                }  else{
                    if($_POST["dan"] < 0){
                        $greskadan="Unijeli ste negativnu vrijednost!";
                    }
                }
                if(empty($_POST["mjesec"])){
                    $greskamjesec="Niste unijeli mjesec rodenja!";
                }  else{
                    $_POST["mjesec"];
                }
                if(empty($_POST["godina"])){
                    $greskagodina="Niste unijeli godinu rodenja!";
                }  else{
                    if($_POST["godina"] > 2015 || $_POST["godina"] < 1930){
                        $greskagodina="Godina mora biti izmedu 1930 i 2015!";
                    }
                }
                if(empty($_POST["email"])){
                    $greskaemail="Niste unijeli e-mail adresu!";
                }  else{
                    if(!preg_match("/[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-z]{2,3}/", $_POST["email"])){
                        $greskaemail="E-mail adresa mora biti tipa: nesto@nesto.nesto";
                    }
                }
            }
            ?>
<?php
                require("pomak_funkcija.php");
                require("baza.class.php");
                
                $bp = new Baza();
                $korime = (isset($_POST['korime']) ? $_POST['korime'] : null);
                $email=(isset($_POST['email']) ? $_POST['email'] : null);
                $ime=(isset($_POST['ime']) ? $_POST['ime'] : null);
                $prezime=(isset($_POST['prezime']) ? $_POST['prezime'] : null);
                $lozinka=(isset($_POST['lozinka']) ? $_POST['lozinka'] : null);
                $dan_rodenja=(isset($_POST['dan']) ? $_POST['dan'] : null);
                $mjesec_rodenja=(isset($_POST['mjesec']) ? $_POST['mjesec'] : null);
                $godina_rodenja=(isset($_POST['godina']) ? $_POST['godina'] : null);
                $korime_upit="select korime from korisnici where korime='$korime'";
                $email_upit="select email from korisnici where email='$email'";
                $bp->spojiDB();
                $rs_korime = $bp->selectDB($korime_upit);
                $rs_email=$bp->selectDB($email_upit);
                $red_korime=$rs_korime->fetch_array();
                $red_email=$rs_email->fetch_array();
                $greskakorime1="";
                $greskaemail1="";
                if ($bp->pogreskaDB()) {
                    echo "Problem kod upita na bazu podataka!";
                    exit;
                }
                //if($red_korime['korime']==$korime && !empty($korime)){
                   // $greskakorime1= "Korisnicko ime postoji u bazi!";
                //}
               // if($red_email['email']==$email && !empty($email)){
                 //   $greskaemail1= "E-mail adresa postoji u bazi!";
                //}   
                if(!($red_korime['korime']==$korime && !empty($korime) || $red_email['email']==$email && !empty($email))){
                    if (isset($_POST['submit-form'])) {
                    if(($greska1=="") && ($greskalozinka=="") && ($greskapotlozinka=="") && ($greskaime=="") && ($greskaprezime=="") && ($greskadan=="") && ($greskamjesec=="") && ($greskagodina=="") && ($greskaemail=="")){
                        $korisnici_upit="insert into korisnici(id_korisnik,id_tip,ime,prezime,korime, lozinka,dan_rodenja,mjesec_rodenja,godina_rodenja,email) values (default, 1,  '$ime','$prezime','$korime','$lozinka','$dan_rodenja','$mjesec_rodenja','$godina_rodenja','$email')";        
                        $rs_korisnici=$bp->updateDB($korisnici_upit);                        
                        $primatelj = $_POST['email']; 
                        $aktivacijskikod = ($korime.date("Y-m-d_h:i:sa"));
                        $hash_kod=hash("md5",$aktivacijskikod);
                        $pomak=  pomakvremena();
                        $upit_aktivacijakod="insert into aktivacijakod(id_kod,id_korisnik,aktivacijski_kljuc,datum) values (default, LAST_INSERT_ID(),'$hash_kod', '$pomak')";
                        $rs_aktivacijakod=$bp->updateDB($upit_aktivacijakod);
                        $ime=$_POST['ime'];
                        $subject1 = "Aktivacijski kod";
                        $link = "http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x035/aktivacija.php?aktivacija=".$hash_kod;
                        $poruka = "Ovo je vaš aktivacijski kod " . $ime . "\n\n" . $link;
                        $naslov1 = "From:" . $primatelj;
                        mail($primatelj,$subject1,$poruka,$naslov1);
                        echo "E-mail je uspješno poslan. Hvala " . $ime . ", ubrzo cemo vas kontaktirati.";
                    }    
                    }
                }  
                $bp->zatvoriDB();
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
        <script src='https://www.google.com/recaptcha/api.js'></script>

    </head>
   <body onload="registracijaFunkcija()">
       <div style="background-color: #2A3F54; margin-top: -16px;">
           <figure>
                <img src="img/logo.png" alt="FOI zaglavlje" />
           </figure></div>
       <nav>
            <ul class="navigacija">
                <li><a href="index.php" class="stranica">POČETNA STRANICA</a></li>
                <li><a href="mobiteli_i_kategorija.php" class="stranica">MOBILNI UREĐAJI</a></li>
                <li><a href="registracija.php" class="stranica" id="registracija">REGISTRACIJA</a></li> 
                <li><a href="prijava.php" class="stranica">PRIJAVA</a></li>
                <li><a href="privatno/korisnici_baza.php" class="stranica">POPIS KORISNIKA .htaccess</a></li>
                <li><a href="dokumentacija.html" class="stranica">DOKUMENTACIJA</a></li>
                <li><a href="o_autoru.php" class="stranica">O AUTORU</a></li>
                </ul>
        </nav>
       <section id="sadrzaj">
            <h2>Registracija</h2>
            <form method="post" action="registracija.php" id="forma2">
                <label for="ime">Ime: </label>
                <input type="text" id="ime" name="ime" value="<?php if(isset($_POST['ime'])){echo $_POST['ime'];} ?>"><br><br>
                <span class="error"> <?php echo $greskaime; ?></span>
                <label for="ime">Prezime: </label>
                <input type="text" id="prezime" name="prezime" value="<?php if(isset($_POST['prezime'])){echo $_POST['prezime'];} ?>"><br><br>
                <span class="error"> <?php echo $greskaprezime; ?></span>
                <label for="korime">Korisnicko ime: </label>
                <input type="text" name="korime" id="korime" value="<?php if(isset($_POST['korime'])){echo $_POST['korime'];} ?>"><br>
                <p id="pogreskakorime1"></p>
                <p id="pogreskakorime2"></p>
                <span class="error"> <?php echo $greskakorime1; ?></span>  
                <span class="error"> <?php echo $greska1; ?></span>    
                <label for="lozinka1">Lozinka:</label>
                <input type="password" id="lozinka1" name="lozinka" value="<?php if(isset($_POST['lozinka'])){echo $_POST['lozinka'];} ?>">
                <p id="pogreskalozinka1"></p>
                <span class="error"> <?php echo $greskalozinka; ?></span>
                <label for="lozinka2">Potvrda lozinke: </label>
                <input type="password" id="lozinka2" name="potlozinke" value="<?php if(isset($_POST['potlozinke'])){echo $_POST['potlozinke'];} ?>">
                <p id="pogreskalozinka2"></p>
                <span class="error"> <?php echo $greskapotlozinka; ?></span>
                <label for="rođendan">Rođendan: </label>  
                <input type="number" id="rođendan" name="dan"  placeholder="dan" value="<?php if(isset($_POST['dan'])){echo $_POST['dan'];} ?>"> 
                <span class="error"> <?php echo $greskadan; ?></span>
                <input list="mjesec" placeholder="mjesec" name="mjesec" id="mjesec1" value="<?php if(isset($_POST['mjesec'])){echo $_POST['mjesec'];} ?>">
                <span class="error"> <?php echo $greskamjesec; ?></span>
                <datalist id="mjesec">
                    select from the list
                    <option value="Siječanj">Siječanj</option>
                    <option value="Veljača">Veljača</option>
                    <option value="Ožujak">Ožujak</option>
                    <option value="Travanj">Travanj</option>
                    <option value="Svibanj">Svibanj</option>
                    <option value="Lipanj">Lipanj</option>
                    <option value="Srpanj">Srpanj</option>
                    <option value="Kolovoz">Kolovoz</option>
                    <option value="Rujan">Rujan</option>
                    <option value="Listopad">Listopad</option>
                    <option value="Studeni">Studeni</option>
                    <option value="Prosinac">Prosinac</option>
                </datalist>
                <input type="number" id="godina" name="godina" placeholder="godina" value="<?php if(isset($_POST['godina'])){echo $_POST['godina'];} ?>">
                <span class="error"> <?php echo $greskagodina; ?></span>
                <p id="pogreskarodendan"></p>
                <label for="email">Email adresa: </label>
                <input type="email" id="email" name="email" size="35" maxlength="35" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                <span class="error"> <?php echo $greskaemail1; ?></span>
                <span class="error"> <?php echo $greskaemail; ?></span>
                <p id="pogreskamail"></p>
                <div class="g-recaptcha" data-sitekey="6LcxzB4TAAAAAFA1CaqjoEYYgOOn-cgyTp36LyFf"></div>
                <label for="gumb">Slanje podataka: </label>  
                <input id="gumb" type="submit" name="submit-form"><br>
                <p id="svipodaci1"></p>
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
