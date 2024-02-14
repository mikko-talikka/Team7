<?php

$target_dir = "kuvat/";                                                 
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {                                       
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);       
    if($check !== false) {                                            
      echo "Tiedostomuoto - " . $check["mime"] . ".<br>";             
      $uploadOk = 1;                                                  
    } else {
      echo "Tiedosto ei ole kuva.";                                   
      $uploadOk = 0;                                                  
    }
  }
  if (file_exists($target_file)) {
    echo "Kuva on jo tallennettu.";
    $uploadOk = 0;
  }
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Lataamasi tiedosto on liian suuri (yli 500kt).";
    $uploadOk = 0;
  }
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
  echo "Vain JPG, JPEG, PNG & GIF tiedostomuodot ovat sallittuja.";
  $uploadOk = 0;
  }
  if ($uploadOk == 0) {
    echo "Tiedostoa ei tallennettu.";
  } 
  else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "Tiedosto: ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " on tallennettu onnistuneesti.";
    } else {
      echo "Pahoittelut, tiedoston lataaminen epäonnistui. Yritä tarvittaessa myöhemmin uudelleen.";
    }
  }

$kuvaNimi = basename($_FILES["fileToUpload"]["name"]);
$tiedostoPolku = $target_dir . $kuvaNimi;

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
$kasittelyntila="uusi";

$sql="insert into ostotarjoukset (rekisterinumero, puhelinnumero, email, kokonimi, raha, kilometrilukema, lisatieto, kuvaNimi, tiedostoPolku, kasittelyntila) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

//Valmistellaan sql-laussee
$stmt=mysqli_prepare($yhteys, $sql);
//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_bind_param($stmt, 'sissiissss', $rekisterinumero, $puhelinnumero, $email, $kokonimi, $raha, $kilometrilukema, $lisatieto, $kuvaNimi, $tiedostoPolku, $kasittelyntila);
//Suoritetaan sql-lause
mysqli_stmt_execute($stmt);
//Suljetaan tietokantayhteys
mysqli_close($yhteys);

echo '<meta http-equiv="refresh" content="0;url=../pages/kiitossivu.html">';
// header("Location:../kiitossivu.html");
exit;
?>