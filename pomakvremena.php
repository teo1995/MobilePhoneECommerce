<?php
        include "login.php";
        
        session_start();
        if(!ulogiran()){
            header("location: prijava.php");
        }
        else {
            if (isset($_POST['submit'])) {
                    require_once("baza.class.php");
                    $bp = new Baza();
                    $bp->spojiDB();
                    $json_file = file_get_contents("http://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=json");
                    $uzmi_json = json_decode($json_file, true);
                    $pomak = $uzmi_json["WebDiP"]["vrijeme"]["pomak"]["brojSati"];
                    $upit_pomak="UPDATE pomak_vremena SET pomak = '$pomak'";
                    $rs_poma=$bp->updateDB ($upit_pomak);
                    echo "Uspjesno ste dodali pomak u bazu!";

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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10/datatables.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        
    </head>
   <body>
       
       <div style="background-color: #2A3F54; margin-top: -16px;">
           <figure>
                <img src="img/logo.png" alt="FOI zaglavlje" />
                <?php if(isset($_SESSION['korime_sesija'])){
                    ?>
                <figcaption><h1> Dobrodošli, <?=$_SESSION['korime_sesija'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?>
                <?php if(isset($_COOKIE['korime_cookie'])){?>
                <figcaption><h1> Dobrodošli, <?=$_COOKIE['korime_cookie'];?> <a href="odjava.php">Odjavi se</a></h1></figcaption>
                <?php } ?> 
           </figure></div>
                    
       <nav>
            <?php
                    require_once("navigacija.php");
                    if(ulogiran()==3){
                    navigacijaAdmin6();
                    }
                    ?>
        </nav>
       <section id="sadrzaj">
           <h2>Virtualno vrijeme</h2>
                   <form method="post" action="pomakvremena.php">
                       <a id="pomak" href="http://barka.foi.hr/WebDiP/pomak_vremena/vrijeme.html" target="_blank">Pritisni me za dodavanje pomaka</a><br><br>
                       <input type="submit" value="Upisi pomak" name="submit">
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