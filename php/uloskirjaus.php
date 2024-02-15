<?php
// session aloittaminen (tilapäinen tallennustila, joka säilyttää tietoja käyttäjän selaimen ja palvelimen välillä)
session_start();
// kaikkien tietojen poistaminen session muistista
session_unset();

// ohjataan takaisin kirjautumissivulle
header("Location:./kirjaudu.php");
exit;

?>