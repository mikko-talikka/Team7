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

$poistettava=isset($_GET["poistettava"]) ? $_GET["poistettava"] : "";

if (!empty($poistettava)){
    $sql="delete from ostotarjoukset where id=?";
    $stmt=mysqli_prepare($yhteys, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $poistettava);
    mysqli_stmt_execute($stmt);
}

mysqli_close($yhteys);
header("Location:./ostotarjouksetHallinnointisivu.php");
exit;
?>