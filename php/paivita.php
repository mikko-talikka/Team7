<?php

// sijoitetaan muuttujiin lomakkeelta tullut post muotoinen tieto
$id=isset($_POST["id"]) ? $_POST["id"] : "";
$rekisterinumero=isset($_POST["rekisterinumero"]) ? $_POST["rekisterinumero"] : "";
$puhelinnumero=isset($_POST["puhelinnumero"]) ? $_POST["puhelinnumero"] : "";
$email=isset($_POST["email"]) ? $_POST["email"] : "";
$kokonimi=isset($_POST["kokonimi"]) ? $_POST["kokonimi"] : "";
$raha=isset($_POST["raha"]) ? $_POST["raha"] : "";
$kilometrilukema=isset($_POST["kilometrilukema"]) ? $_POST["kilometrilukema"] : "";
$lisatieto=isset($_POST["lisatieto"]) ? $_POST["lisatieto"] : "";
$kasittelyntila=isset($_POST["kasittelyntila"]) ? $_POST["kasittelyntila"] : "";

// tarkistetaan, onko kaikki tiedot syötetty
if (empty($id) || empty($rekisterinumero) || empty($puhelinnumero) || empty($email) || empty($kokonimi) || empty($raha) || empty($kilometrilukema) || empty($lisatieto) || empty($kasittelyntila)){
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
$sql="update ostotarjoukset set rekisterinumero=?, puhelinnumero=?, email=?, kokonimi=?, raha=?, kilometrilukema=?, lisatieto=?, kasittelyntila=? where id=?";
$stmt=mysqli_prepare($yhteys, $sql);
// Arvojen sitominen parametripaikkoihin
mysqli_stmt_bind_param($stmt, 'ssssiissi', $rekisterinumero, $puhelinnumero, $email, $kokonimi, $raha, $kilometrilukema, $lisatieto, $kasittelyntila, $id);
// SQL-lauseen suorittaminen
mysqli_stmt_execute($stmt);
// tietokantayhteyden sulkeminen
mysqli_close($yhteys);

// ohjataan takaisin hallinnointisivulle
header("Location:./ostotarjouksetHallinnointisivu.php");
?>