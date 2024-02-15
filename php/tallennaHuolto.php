<?php
//yhteys tietokantaan
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
//eri tiedostosta tunnukset
$initials=parse_ini_file("./.ht.asetukset.ini");

//yritetään yhdistää tietokantaan
try{
    $yhteys=mysqli_connect($initials["palvelin"], $initials["tunnus"] , $initials["pass"], $initials["tk"]);
}
//jos ei toimi niin tonne
catch(Exception $e){
    header("Location:../pages/yhteysvirhe.html");
    exit;
}
//formin vastauksien tallentaminen muuttujiin
$kokonimi=isset($_POST["kokonimi"]) ? $_POST["kokonimi"] : "";
$puhelinnumero=isset($_POST["puhelinnumero"]) ? $_POST["puhelinnumero"] : "";
$email=isset($_POST["email"]) ? $_POST["email"] : "";
$date=isset($_POST["date"]) ? $_POST["date"] : "";
$time=isset($_POST["time"]) ? $_POST["time"] : "";
$viesti=isset($_POST["viesti"]) ? $_POST["viesti"] : "";
//$lisatieto=isset($_POST["lisatieto"]) ? $_POST["lisatieto"] : "";
$kasittelyntila="uusi";

// SQL-lauseen muodostaminen ja valmistelu
$sql="insert into huolto (kokonimi, puhelinnumero, email, date, time, viesti, kasittelyntila) values(?, ?, ?, ?, ?, ?, ?)";

//Valmistellaan sql-laussee
$stmt=mysqli_prepare($yhteys, $sql);
//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_bind_param($stmt, 'sssssss', $kokonimi, $puhelinnumero, $email, $date, $time, $viesti, $kasittelyntila);
//Suoritetaan sql-lause
mysqli_stmt_execute($stmt);
//Suljetaan tietokantayhteys
mysqli_close($yhteys);

//ohjataan kiitos sivulle
echo '<meta http-equiv="refresh" content="0;url=../pages/kiitossivu.html">';
// header("Location:../kiitossivu.html");
exit;
?>