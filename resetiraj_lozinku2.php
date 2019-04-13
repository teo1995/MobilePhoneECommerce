<?php
                session_start();
                require("baza.class.php");
                $bp = new Baza();
                $email_sesija=$_SESSION['email'];
                $korisnik="select ime,prezime,korime,email from korisnici where email='$email_sesija'";
                $bp->spojiDB();
                $rs_korisnik = $bp->selectDB($korisnik);
                $red_korisnik=$rs_korisnik->fetch_array();
                if (isset($_POST['submit-form'])) {
                    require_once ("random_generator.php");
                    $random=  randomLozinka();
                    $link="http://barka.foi.hr/WebDiP/2015_projekti/WebDiP2015x035/prijava.php";
                    $poruka = "Ovo je vasa nova sifra " .$red_korisnik[0].": ". $random."\n\nKliknite ovdje za novu prijavu:". $link;
                    $naslov1 = "From:" . $red_korisnik[3];
                    $subject1 = "Nova sifra";
                    mail($email_sesija,$subject1,$poruka,$naslov1);
                    $upit_promjenasifre="update korisnici set lozinka='$random' where email='$email_sesija'";
                    $rs_promjenisifru=$bp->selectDB($upit_promjenasifre);
                    echo "Nova sifra je uspješno poslana na vašu e-mail adresu!";
                    header("location: prijava.php");
                    session_destroy();
                }
                if(isset($_POST['submit-form1'])){
                    header("location: resetiraj_lozinku.php");
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
        <script type="text/javascript" src="js/matkantoc.js"></script> 
    </head>
   <body> 
       <div style="background-color: #2A3F54; margin-top: -16px;">
           <figure>
                <img src="img/logo.png" alt="FOI zaglavlje" />
                <figcaption>FOI - Web dizajn i programiranje</figcaption>  
           </figure></div>
      
       <nav>
            <ul class="navigacija">
                <li><a href="index.php" class="stranica">POČETNA STRANICA</a></li>
                </ul>
        </nav>
       <section id="sadrzaj">
            <h2>Prijava</h2>
            <form id="forma1" method="post" name="forma">
                Jeste li ovo vi:
                <span class="error"><?php echo $red_korisnik[1]," ", $red_korisnik[0]; ?></span><br>
                <input id="gumb3" type="submit" name="submit-form" value="Da"><br>
                <input id="gumb1" type="submit" name="submit-form1" value="Ne"><br>
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
