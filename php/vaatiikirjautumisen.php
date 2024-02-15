<?php
// Aloitetaan sessio
    session_start();
    // Vaatii, että henkilö on kirjautunut sivulle, jos ei ole, siirrytään kirjaudu.php
    if (!isset($_SESSION["user_ok"])){
        $_SESSION["paluuosoite"]="vaatiikirjautumisen.php";
        header("Location:./kirjaudu.php");
        exit;
    }
?>