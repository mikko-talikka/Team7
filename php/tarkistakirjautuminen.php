<?php
session_start();

if (isset($_POST["tunnus"]) && isset($_POST["salasana"])) {
    $tunnus=$_POST["tunnus"];
    $salasana=$_POST["salasana"];
}
else {
    header("Location:kirjaudu.php");
    exit;
}

$initials=parse_ini_file("./.ht.asetukset.ini");
            
            try{
                $yhteys=mysqli_connect($initials["palvelin"], $initials["tunnus"] , $initials["pass"], $initials["tk"]);
            }
            catch(Exception $e){
                header("Location:./yhteysvirhe.html");
                exit;
            }
$tietokanta=mysqli_select_db($yhteys, "web_trtkp23_7");

$sql="select * from tunnukset where tunnus=? and salasana=md5(?)";
$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, "ss", $tunnus, $salasana);

mysqli_execute($stmt);
$tulos=mysqli_stmt_get_result($stmt);

if ($rivi=mysqli_fetch_object($tulos)) {
    $_SESSION["user_ok"]="ok";
    header("Location:".$_SESSION["ostotarjouksetHallinnointisivu.php"]);
    exit;
}
else {
    header("Location:kirjaudu.php")
exit;
}
?>