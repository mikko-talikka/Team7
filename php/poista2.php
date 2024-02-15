<?php
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

$initials=parse_ini_file("./.ht.asetukset.ini");

try{
    $yhteys=mysqli_connect($initials["palvelin"], $initials["tunnus"] , $initials["pass"], $initials["tk"]);
}
catch(Exception $e){
    header("Location:../pages/yhteysvirhe.html");
    exit;
}

// poistettavan huoltopyynnön ID:n hakeminen
$poistettava=isset($_GET["poistettava2"]) ? $_GET["poistettava2"] : "";

// jos ID ei ole tyhjä
if (!empty($poistettava)){
    // SQL-lauseen muodostaminen ja valmistelu
    $sql="delete from huolto where id=?";
    $stmt=mysqli_prepare($yhteys, $sql);
    // arvojen sitominen parametripaikkoihin
    mysqli_stmt_bind_param($stmt, 'i', $poistettava);
    // SQL-lauseen suorittaminen
    mysqli_stmt_execute($stmt);
}

// tietokantayhteyden sulkeminen
mysqli_close($yhteys);
// ohjataan takaisin hallinnointisivulle
header("Location:./ostotarjouksetHallinnointisivu.php");
exit;
?>