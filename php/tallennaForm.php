<?php
//määritetään kuvien tallennuskansio
$target_dir = "kuvat/";
//määritetään ladattavan kuvan nimi ja sijainti
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//muuttuja jonka arvo määrittää onko lataus onnistunut (1 ok, 0 ei ladata)
$uploadOk = 1;
// määritetään ladatun kuvan tiedostotyyppin
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// tarkistetaan, onko ladattu tiedosto kuva: funktio palauttaa taulukon, joka sisältää tietoa kuvasta jos se on onnistuneesti tunnistettu
if(isset($_POST["submit"])) {                                       
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);       
    if($check !== false) {                                            
      $uploadOk = 1;                                                  
    } else {
      $uploadOk = 0;                                                  
    }
  }
  // tarkistetaan, onko tiedosto jo olemassa samalla nimellä
  if (file_exists($target_file)) {
    $uploadOk = 0;
  }
  // tarkistetaan, onko tiedostokoko sallittu (alle 500 kt)
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    $uploadOk = 0;
  }
  // tarkistetaan, onko tiedostotyyppi sallittu (jpg, png, jpeg, gif)
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
  $uploadOk = 0;
  }
  // jos kaikki tarkistukset epäonnistuvat
  if ($uploadOk == 0) {
  }
  // jos kaikki tarkistukset onnistuvat
  else {
    // kuva tallennetaan
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      // tiedosto tallennettu onnistuneesti
    } else {
      // tiedoston tallennus epäonnistui
    }
  }

// tallennetaan ladatun kuvan nimi ja tiedostopolku muuttujiin
$kuvaNimi = basename($_FILES["fileToUpload"]["name"]);
$tiedostoPolku = $target_dir . $kuvaNimi;

// yhteyden muodostaminen tietokantaan
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

// annetaan muuttujalle tarvittavat tunnistetiedot tietokantaan kirjautumista varten eri tiedostossa 
$initials=parse_ini_file("./.ht.asetukset.ini");

// testataan yhdistää tietokantaan
try{
    $yhteys=mysqli_connect($initials["palvelin"], $initials["tunnus"] , $initials["pass"], $initials["tk"]);
}
// jos yhdistäminen ei onnistu, ohjataan yhteysvirhesivulle
catch(Exception $e){
    header("Location:../pages/yhteysvirhe.html");
    exit;
}

// lomakkeen kenttien arvojen tallentaminen muuttujiin
$rekisterinumero=isset($_POST["rekisterinumero"]) ? $_POST["rekisterinumero"] : "";
$puhelinnumero=isset($_POST["puhelinnumero"]) ? $_POST["puhelinnumero"] : "";
$email=isset($_POST["email"]) ? $_POST["email"] : "";
$kokonimi=isset($_POST["kokonimi"]) ? $_POST["kokonimi"] : "";
$raha=isset($_POST["raha"]) ? $_POST["raha"] : "";
$kilometrilukema=isset($_POST["kilometrilukema"]) ? $_POST["kilometrilukema"] : "";
$lisatieto=isset($_POST["lisatieto"]) ? $_POST["lisatieto"] : "";
// käsittelyn tila on aina uuden tiedon tallentuessa uusi, joten tämä tallennetaan suoraan merkkijonona muuttujaan
$kasittelyntila="uusi";

// SQL-lauseen muodostaminen ja valmistelu
$sql="insert into ostotarjoukset (rekisterinumero, puhelinnumero, email, kokonimi, raha, kilometrilukema, lisatieto, kuvaNimi, tiedostoPolku, kasittelyntila) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

//Valmistellaan sql-laussee
$stmt=mysqli_prepare($yhteys, $sql);
//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_bind_param($stmt, 'ssssiissss', $rekisterinumero, $puhelinnumero, $email, $kokonimi, $raha, $kilometrilukema, $lisatieto, $kuvaNimi, $tiedostoPolku, $kasittelyntila);
//Suoritetaan sql-lause
mysqli_stmt_execute($stmt);
//Suljetaan tietokantayhteys
mysqli_close($yhteys);

// ohjataan käyttäjä kiitossivulle
header("Location:../pages/kiitossivu.html");
// echo '<meta http-equiv="refresh" content="0;url=../pages/kiitossivu.html">'; <-- tämä on vaihtoehtoinen tapa ohjata käyttäjä,
// jos sivulla on tulostetta mikä estää header funktion käytön
exit;
?>
