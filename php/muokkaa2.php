<?php
// Aloitetaan sessio
session_start();
// Vaatii, että henkilö on kirjautunut sivulle, jos ei ole, siirrytään kirjaudu.php
if (!isset($_SESSION["user_ok"])){
    $_SESSION["paluuosoite"]="ostotarjouksetHallinnointisivu.php";
    header("Location:./kirjaudu.php");
    exit;
}

// sijoitetaan muuttujaan tiedot muokattavasta huoltopyynnöstä
$muokattava=isset($_GET["muokattava2"]) ? $_GET["muokattava2"] : "";

// ohjataan takaisin, jos on tyhjä
if (empty($muokattava)){
    header("Location:./ostotarjouksetHallinnointisivu.php");
    exit;
}

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

$initials=parse_ini_file("./.ht.asetukset.ini");

try{
    $yhteys=mysqli_connect($initials["palvelin"], $initials["tunnus"] , $initials["pass"], $initials["tk"]);
}
catch(Exception $e){
    header("Location:../pages/yhteysvirhe.html");
    exit;
}

// SQL-lauseen muodostaminen ja valmistelu
$sql="select * from huolto where id=?";
$stmt=mysqli_prepare($yhteys, $sql);
// arvojen sitominen parametripaikkoihin
mysqli_stmt_bind_param($stmt, 'i', $muokattava);
// SQL-lauseen suorittaminen
mysqli_stmt_execute($stmt);
// tulosten hakeminen
$tulos=mysqli_stmt_get_result($stmt);
// tarkistetaan, löytyykö tuloksia
if (!$rivi=mysqli_fetch_object($tulos)){
    header("Location:../pages/yhteysvirhe.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muokkaa huoltopyyntöä</title>
    <link rel="stylesheet" href="../css/styles-mikko.css">
</head>
<body>
<header class="headerOsto">
            <h1 class="h1Osto">LUXCAR</h1>
            <h2 class="h2Osto">Muokkaa huoltopyyntöä</h2>
        </header>

<!-- tehdään käyttäjälle <form> elementtiin lomake, missä näkyy tietokannasta tämänhetkiset tiedot. Käyttäjä pääsee näitä arvoja muokkaamaan
    ja lopuksi valitsemaan kahden napin välillä: tallennetaanko muutetut (tai samat) tiedot vai palataanko takaisin etusivulle -->
<form action='./paivita2.php' method='post' class='formOsto'>
id:<input type='text' name='id' value='<?php print $rivi->id;?>' readonly><br>
kokonimi:<input type='text' name='kokonimi' value='<?php print $rivi->kokonimi;?>'><br>
puhelinnumero:<input type='tel' name='puhelinnumero' value='<?php print $rivi->puhelinnumero;?>'><br>
Sähköposti:<input type='email' name='email' value='<?php print $rivi->email;?>'><br>
Huoltopäivä:<input type='text' name='date' value='<?php print $rivi->date;?>'><br>
Huoltoaika:<input type='text' name='time' value='<?php print $rivi->time;?>'><br>
Viesti:<input type='text' name='viesti' value='<?php print $rivi->viesti;?>'><br>
Käsittelyn tila:<input type='text' name='kasittelyntila' value='<?php print $rivi->kasittelyntila;?>'><br>
<input type='submit' name='ok' value='Tallenna'><br>
<input type='button' value='Takaisin etusivulle tallentamatta' onclick="location.href='./ostotarjouksetHallinnointisivu.php'">
</form>

<?php
mysqli_close($yhteys);
?>