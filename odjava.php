<?php
        session_start();
        session_destroy();
        setcookie("korime_cookie",$korime_prijava, time()-7200);
        header("location: prijava.php");

?>

