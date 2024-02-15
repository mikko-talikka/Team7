<?php
session_start();
// Tallennetaan käyttäjän syöttämät tunnukset muuttujiin
if (isset($_POST["tunnus"]) && isset($_POST["salasana"])) {
    $tunnus=$_POST["tunnus"];
    $salasana=$_POST["salasana"];
}
// Jos ei onnistu, siirrytään yhteysvirhe-sivulle
else {
    header("Location:../pages/yhteysvirhe.html");
    exit;
}
// Kirjautumistiedot tietokantaan löytyy .ini tiedostosta
$initials=parse_ini_file("./.ht.asetukset.ini");

// Yrittää ottaa yhteyden tietokantaan, jos ei onnistu, palataan yhteysvirhesivulle
try{
    $yhteys=mysqli_connect($initials["palvelin"], $initials["tunnus"] , $initials["pass"], $initials["tk"]);
}
catch(Exception $e){
    header("Location:./yhteysvirhe.html");
    exit;
}
// Tietokantahaku "tunnukset" taulusta.
$sql="select * from tunnukset where tunnus=? and salasana=md5(?)";
$stmt=mysqli_prepare($yhteys, $sql);
// Verrataan syötettyä salasanaa tietokantaan
mysqli_stmt_bind_param($stmt, "ss", $tunnus, $salasana);

mysqli_execute($stmt);
$tulos=mysqli_stmt_get_result($stmt);

// Jos syötetty salasana täsmää, siirrytään hallinnointisivulle
if ($rivi=mysqli_fetch_object($tulos)) {
    $_SESSION["user_ok"]="ok";
    header("Location:./ostotarjouksetHallinnointisivu.php");
    exit;
}
// Jos ei täsmää, yhteysvirhe
else {
	header("Location:../pages/yhteysvirhe.html");
	exit;
}
?>