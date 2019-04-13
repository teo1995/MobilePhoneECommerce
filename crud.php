<?php
        include "login.php";
        
        session_start();
        if(!ulogiran()){
            header("location: prijava.php");
        }
        else {
            if(isset($_POST['submit'])){
                $ime=$_POST['ime'];
                $prezime=$_POST['prezime'];
                $korime=$_POST['korime'];
                $tip=$_POST['tip'];
                $dan=$_POST['dan'];
                $mjesec=$_POST['mjesec'];
                $godina=$_POST['godina'];
                $email=$_POST['email'];
                $lozinka=$_POST['lozinka'];
                require_once("baza.class.php");
                $bp = new Baza();
                $bp->spojiDB();
                $sql="insert into korisnici values (default,'$tip','$ime','$prezime','$korime','$lozinka','$dan','$mjesec','$godina','$email',default,default)";
                $rs_sql=$bp->selectDB($sql);
                echo("Uspjecan insert!");
            }
            
            if(isset($_POST['submit1'])){
                require_once("baza.class.php");
                $bp = new Baza();
                $bp->spojiDB();
                $select=$_POST['update_select'];
                $ime1=$_POST['ime1'];
                $prezime1=$_POST['prezime1'];
                $korime1=$_POST['korime1'];
                $tip1=$_POST['tip1'];
                $dan1=$_POST['dan1'];
                $mjesec1=$_POST['mjesec1'];
                $godina1=$_POST['godina1'];
                $email1=$_POST['email1'];
                $lozinka1=$_POST['lozinka2'];
                $upit_korisnika1="update korisnici set id_tip='$tip1', ime='$ime1', prezime='$prezime1', korime='$korime1', lozinka='$lozinka1', dan_rodenja='$dan1', mjesec_rodenja='$mjesec1', godina_rodenja='$godina1', email='$email1' where id_korisnik='$select'";
                $rs_korisnika1=$bp->selectDB($upit_korisnika1);
                echo ("Uspjesan update!");
                        }
            if(isset($_POST['submit2'])){
                require_once("baza.class.php");
                $bp = new Baza();
                $bp->spojiDB();
                $select3=$_POST['update_select1'];
                $upit_delete="delete from korisnici where id_korisnik='$select3' ";
                $rs_delete=$bp->selectDB($upit_delete);
                echo ("Uspjesan delete!");
                echo $select3;
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
   <body onload="kreirajTablice()">
       
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
                    navigacijaAdmin5();
                    }
                    ?>
        </nav>
       <section id="sadrzaj">
           <h2>CRUD</h2>
                   <form method="post" action="crud.php" id="forma_biraj">
                       <select name="odaberi" id="odaberi">
                           <option value="default">Odaberite tablicu</option>
                               <option value="aktiviraj">Aktivacija</option>
                           </select>
                       
                       <table  class="tablica_klasa">
                           </table>
                       
                       <select name="odaberi1" id="odaberi1" style="visibility: hidden">
                               <option value="default">Odaberite opciju</option>
                               <option value="insert">Insert</option>
                               <option value="update">Update</option>
                               <option value="delete">Delete</option>
                       </select><br><br>
                   </form>
           
           <form id="aktiviraj_forma" style="display: none" method="post" action="crud.php">
                   <select name="tip" id="tip">
                           <option value="default">Odaberite tip</option>
                               <option value="1">Registrirani korisnik</option>
                               <option value="2">Moderator</option>
                               <option value="3">Administrator</option>
                   </select><br><br>
                <label for="ime">Ime: </label>
                <input type="text" id="ime" name="ime"><br><br>
                <label for="ime">Prezime: </label>
                <input type="text" id="prezime" name="prezime"><br><br>
                <label for="korime">Korisnicko ime: </label>
                <input type="text" name="korime" id="korime"><br>
                <p id="pogreskakorime1"></p>
                <p id="pogreskakorime2"></p>
                <label for="lozinka1">Lozinka:</label>
                <input type="password" id="lozinka1" name="lozinka">
                <p id="pogreskalozinka1"></p>
                <label for="rođendan">Rođendan: </label>  
                <input type="number" id="rođendan" name="dan"  placeholder="dan"> 
                <input list="mjesec" placeholder="mjesec" name="mjesec" id="mjesec1">
                <datalist id="mjesec1">
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
                <input type="number" id="godina" name="godina" placeholder="godina">
                <p id="pogreskarodendan"></p>
                <label for="email">Email adresa: </label>
                <input type="email" id="email" name="email" size="35" maxlength="35">
                <p id="pogreskamail"></p>
                <label for="gumb">Slanje podataka: </label>  
                <input id="gumb" type="submit" name="submit" value="insert"><br>
                <p id="svipodaci1"></p>
           </form>
           
           
           
           
           
           <form id="update_form" style="display: none" method="post">
               <label for="update_select">Odaberite korisnicko ime: </label><br><br>
               <select id="update_select" name="update_select"></select><br><br>
                   <select name="tip1" id="tip1">
                           <option value="default">Odaberite tip</option>
                               <option value="1">Registrirani korisnik</option>
                               <option value="2">Moderator</option>
                               <option value="3">Administrator</option>
                   </select><br><br>
                <label for="ime">Ime: </label>
                <input type="text" id="ime1" name="ime1" value="<?php if(isset($_POST['submit2'])) {echo $red_korisnika['ime'];}?>"><br><br>
                <label for="ime">Prezime: </label>
                <input type="text" id="prezime1" name="prezime1"><br><br>
                <label for="korime">Korisnicko ime: </label>
                <input type="text" name="korime1" id="korime1"><br>
                <p id="pogreskakorime3"></p>
                <p id="pogreskakorime4"></p>
                <label for="lozinka1">Lozinka:</label>
                <input type="password" id="lozinka2" name="lozinka2">
                <p id="pogreskalozinka2"></p>
                <label for="rođendan">Rođendan: </label>  
                <input type="number" id="rođendan1" name="dan1"  placeholder="dan"> 
                <input list="mjesec1" placeholder="mjesec" name="mjesec1" id="mjesec2">
                <datalist id="mjesec1">
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
                <input type="number" id="godina1" name="godina1" placeholder="godina">
                <p id="pogreskarodendan1"></p>
                <label for="email1">Email adresa: </label>
                <input type="email" id="email1" name="email1" size="35" maxlength="35">
                <p id="pogreskamail1"></p>
                <label for="gumb1">Slanje podataka: </label>  
                <input id="gumb1" type="submit" name="submit1" value="update"><br>
                <p id="svipodaci2"></p>
           </form>
                      <form id="delete_form" style="display: none" method="post">
                          <label for="update_select1">Odaberite korisnicko ime: </label><br><br>
                          <select id="update_select1" name="update_select1"></select><br><br>
                          <label for="gumb2">Slanje podataka: </label>  
                          <input id="gumb2" type="submit" name="submit2" value="delete"><br>
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