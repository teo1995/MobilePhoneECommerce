<?php
                $greskapromjeni="";
                if (isset($_POST['submit-form'])) {
                require("baza.class.php");
                $bp = new Baza();
                $email_reset=$_POST['promjeni'];
                $email_resetupit="select email from korisnici where email='$email_reset'";
                $bp->spojiDB();
                $rs_promjeni = $bp->selectDB($email_resetupit);
                $red_promjeni=$rs_promjeni->fetch_array();
                if ($bp->pogreskaDB()) {
                    echo "Problem kod upita na bazu podataka!";
                    exit;
                }
                if($red_promjeni[0]==$email_reset && !empty($email_reset)){
                    session_start();
                    $_SESSION['email']=$email_reset;
                    header("location: resetiraj_lozinku2.php");
                }
                else{
                    $greskapromjeni= "E-mail adresa ne postoji u bazi!";
                }}
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
                <figcaption>FOI - Web dizajn i programiranje</figcaption>  
           </figure></div>
      
       <nav>
            <ul class="navigacija">
                <li><a href="index.php" class="stranica">POČETNA STRANICA</a></li>
                </ul>
        </nav>
       <section id="sadrzaj">
            <h2>Prijava</h2>
            <form id="forma1" method="post" name="forma" action="resetiraj_lozinku.php">
                Upisite e-mail za promjenu lozinke<br><br>
                <input type="text" id="promjeni" name="promjeni" size="25"  placeholder="e-mail" value="<?php if(isset($_POST['promjeni'])){echo $_POST['promjeni'];} ?>">
                <span class="error">* <?php echo $greskapromjeni; ?></span><br>
                <input id="gumb" type="submit" name="submit-form" value="Nastavi"><br>
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
