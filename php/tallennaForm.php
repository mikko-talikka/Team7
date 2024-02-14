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

$rekisterinumero=isset($_POST["rekisterinumero"]) ? $_POST["rekisterinumero"] : "";
$puhelinnumero=isset($_POST["puhelinnumero"]) ? $_POST["puhelinnumero"] : "";
$email=isset($_POST["email"]) ? $_POST["email"] : "";
$kokonimi=isset($_POST["kokonimi"]) ? $_POST["kokonimi"] : "";
$raha=isset($_POST["raha"]) ? $_POST["raha"] : "";
$kilometrilukema=isset($_POST["kilometrilukema"]) ? $_POST["kilometrilukema"] : "";
$lisatieto=isset($_POST["lisatieto"]) ? $_POST["lisatieto"] : "";
// $kuva=
$kasittelyntila="uusi";

$sql="insert into ostotarjoukset (rekisterinumero, puhelinnumero, email, kokonimi, raha, kilometrilukema, lisatieto, kasittelyntila) values(?, ?, ?, ?, ?, ?, ?, ?)";

//Valmistellaan sql-laussee
$stmt=mysqli_prepare($yhteys, $sql);
//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_bind_param($stmt, 'sissiiss', $rekisterinumero, $puhelinnumero, $email, $kokonimi, $raha, $kilometrilukema, $lisatieto, $kasittelyntila);
//Suoritetaan sql-lause
mysqli_stmt_execute($stmt);
//Suljetaan tietokantayhteys
mysqli_close($yhteys);

header("Location:../kiitossivu.html");
exit;
?>