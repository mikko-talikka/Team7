<?php

$muokattava=isset($_GET["muokattava"]) ? $_GET["muokattava"] : "";

if (empty($muokattava)){
    header("Location:./ostotarjouksetHallinnointisivu.php");
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

$sql="select * from ostotarjoukset where id=?";
$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 'i', $muokattava);
mysqli_stmt_execute($stmt);
$tulos=mysqli_stmt_get_result($stmt);
if (!$rivi=mysqli_fetch_object($tulos)){
    header("Location:../pages/yhteysvirhe.html");
    exit;
}
?>

<form action='./paivita.php' method='post'>
id:<input type='text' name='id' value='<?php print $rivi->id;?>' readonly><br>
rekisterinumero:<input type='text' name='rekisterinumero' value='<?php print $rivi->rekisterinumero;?>'><br>
puhelinnumero:<input type='tel' name='puhelinnumero' value='<?php print $rivi->puhelinnumero;?>'><br>
Sähköposti:<input type='email' name='email' value='<?php print $rivi->email;?>'><br>
Koko nimesi:<input type='text' name='kokonimi' value='<?php print $rivi->kokonimi;?>'><br>
Haluamasi rahamäärä autosta:<input type='text' name='raha' value='<?php print $rivi->raha;?>'><br>
Kilometrilukema:<input type='text' name='kilometrilukema' value='<?php print $rivi->kilometrilukema;?>'><br>
Lisätieto:<input type='text' name='lisatieto' value='<?php print $rivi->lisatieto;?>'><br>
Käsittelyn tila:<input type='text' name='kasittelyntila' value='<?php print $rivi->kasittelyntila;?>'><br>
<input type='submit' name='ok' value='Lähetä'><br>
</form>

<?php
mysqli_close($yhteys);
?>