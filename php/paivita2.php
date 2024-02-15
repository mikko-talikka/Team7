<?php

// sijoitetaan muuttujiin lomakkeelta tullut post muotoinen tieto
$id=isset($_POST["id"]) ? $_POST["id"] : "";
$kokonimi=isset($_POST["kokonimi"]) ? $_POST["kokonimi"] : "";
$puhelinnumero=isset($_POST["puhelinnumero"]) ? $_POST["puhelinnumero"] : "";
$email=isset($_POST["email"]) ? $_POST["email"] : "";
$date=isset($_POST["date"]) ? $_POST["date"] : "";
$time=isset($_POST["time"]) ? $_POST["time"] : "";
$viesti=isset($_POST["viesti"]) ? $_POST["viesti"] : "";
$kasittelyntila=isset($_POST["kasittelyntila"]) ? $_POST["kasittelyntila"] : "";

// tarkistetaan, onko kaikki tiedot syötetty
if (empty($id) || empty($kokonimi) || empty($puhelinnumero) || empty($email) || empty($date) || empty($time) || empty($viesti) || empty($kasittelyntila)){
    header("Location:../pages/yhteysvirhe.html");
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

// SQL-lauseen valmistelu ja muodostaminen
$sql="update huolto set kokonimi=?, puhelinnumero=?, email=?, date=?, time=?, viesti=?, kasittelyntila=? where id=?";
$stmt=mysqli_prepare($yhteys, $sql);
// Arvojen sitominen parametripaikkoihin
mysqli_stmt_bind_param($stmt, 'sssssssi', $kokonimi, $puhelinnumero, $email, $date, $time, $viesti, $kasittelyntila, $id);
// SQL-lauseen suorittaminen
mysqli_stmt_execute($stmt);
// tietokantayhteyden sulkeminen
mysqli_close($yhteys);

// ohjataan takaisin hallinnointisivulle
header("Location:./ostotarjouksetHallinnointisivu.php");
?>