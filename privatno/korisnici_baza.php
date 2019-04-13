<?php
    require ("baza.class.php");
    $bp = new Baza();
    $bp->spojiDB();
    $upit_korisnici="select id_korisnik,korisnici.id_tip,naziv,ime,prezime,korime,lozinka,email,broj_pogresaka,status_zakljucan from korisnici,tip_korisnika where korisnici.id_tip=tip_korisnika.id_tip";
    $rs_korisnici = $bp->selectDB($upit_korisnici);
    echo "<table border=1><tr><td>ID korisnika</td><td>ID tip</td><td>Vrsta tipa</td><td>Ime</td><td>Prezime</td><td>Korisnicko ime</td><td>Lozinka</td><td>Email</td><td>Broj pogresaka</td><td>Zakljucan/odkljucan korisnicki racun</td></tr>";
    while ($red = $rs_korisnici->fetch_array()) {
        echo "<tr><td>$red[0]</td><td>$red[1]</td><td>$red[2]</td><td>$red[3]</td><td>$red[4]</td></td><td>$red[5]</td><td>$red[6]</td><td>$red[7]</td><td>$red[8]</td><td>$red[9]</td></tr>";
    }
    echo "</table>\n";
?>