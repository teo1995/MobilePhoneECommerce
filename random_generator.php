<?php
function randomLozinka() {
    $abeceda = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890$@$!%*?&';
    $lozinka = array(); 
    $duljinalozinke = strlen($abeceda) - 1; 
    for ($i = 0; $i < 8; $i++) {
        $random = rand(0, $duljinalozinke);
        $lozinka[] = $abeceda[$random];
    }
    return implode($lozinka); 
}
?>