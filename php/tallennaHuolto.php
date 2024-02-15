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

$kokonimi=isset($_POST["kokonimi"]) ? $_POST["kokonimi"] : "";
$puhelinnumero=isset($_POST["puhelinnumero"]) ? $_POST["puhelinnumero"] : "";
$email=isset($_POST["email"]) ? $_POST["email"] : "";
$date=isset($_POST["date"]) ? $_POST["date"] : "";
$time=isset($_POST["time"]) ? $_POST["time"] : "";
$viesti=isset($_POST["viesti"]) ? $_POST["viesti"] : "";
//$lisatieto=isset($_POST["lisatieto"]) ? $_POST["lisatieto"] : "";
//$kasittelyntila="uusi";

$sql="insert into huolto (kokonimi, puhelinnumero, email, date, time, viesti) values(?, ?, ?, ?, ?, ?)";

//Valmistellaan sql-laussee
$stmt=mysqli_prepare($yhteys, $sql);
//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_bind_param($stmt, 'sssssss', $kokonimi, $puhelinnumero, $email, $date, $time, $viesti, $kasittelyntila);
//Suoritetaan sql-lause
mysqli_stmt_execute($stmt);
//Suljetaan tietokantayhteys
mysqli_close($yhteys);

echo '<meta http-equiv="refresh" content="0;url=../pages/kiitossivu.html">';
// header("Location:../kiitossivu.html");
exit;
?>