<?php
include "./ostotarjoukset.html";

if (isset($_POST["rekkari"])){
    $rekkari=$_POST["rekkari"];
}
else {
    $rekkari="";
}

if (isset($_POST["numero"])){
    $numero=$_POST["numero"];
}
else {
    $numero="";
}
if (isset($_POST["email"])){
    $email=$_POST["email"];
}
else {
    $email="";
}
if (isset($_POST["name"])){
    $name=$_POST["name"];
}
else {
    $name="";
}
if (isset($_POST["rahamäärä"])){
    $rahamaara=$_POST["rahamäärä"];
}
else {
    $rahamaara="";
}
if (isset($_POST["kilometri"])){
    $kilometri=$_POST["kilometri"];
}
else {
    $kilometri="";
}
if (isset($_POST["lisätietoja"])){
    $lisatietoja=$_POST["lisätietoja"];
}
else {
    $lisatietoja="";
}
if (isset($_POST["kuva"])){
    $kuva=$_POST["kuva"];
}
else {
    $kuva="";
}
// Yhteys tietokantaan

$yhteys=mysqli_connect("localhost", "trtkp23_7", "WKEsBVEP", "web_trtkp23_7");
if (!$yhteys){
    die("Yhteyttä ei voitu muodostaa ".mysqli_error());
}
$tietokanta=mysqli_select_db($yhteys, "web_trtkp23_7");
if (!$tietokantas){
    die("Tietokannan valinta epäonnistui ".mysqli_error());
}
$sql="insert into ostotarjoukset(rekisterinumero, puhelinnumero, email, kokonimi, raha, kilometrilukema, lisatieto, kuva) values (?, ?, ?, ?, ?, ?, ?)";
$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 'sissiiss',$rekkari,  $numero, $email, $name, $rahamaara, $kilometri, $lisatietoja, $kuva);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($yhteys);
?>