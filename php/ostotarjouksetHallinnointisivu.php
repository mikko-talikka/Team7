<?php
    include ("./vaatiikirjautumisen.php");
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ostotarjoukset - hallinnointisivu</title>
    <link rel="stylesheet" href="../css/styles-mikko.css">
    <script src="../JS/suurennaKuva.js"></script>
</head>
<body>
    <header class="headerOsto">
        <h1 class="h1Osto">LUXCAR</h1>
        <h2 class="h2Osto">Henkilökunnan hallinnointisivu</h2>
    </header>
    <nav class="navOsto">
        <ul class="navUlOsto">
            <li class="liOsto"><a class="aOsto">OSTOTARJOUKSET</a></li>
            <li class="liUloskirjaus"><a class="aUloskirjaus" href="./uloskirjaus.php"><h3>KIRJAUDU ULOS</h3></a></li>
        </ul>
    </nav>
    <main class="mainOsto">
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

            $tulos=mysqli_query($yhteys, "select * from ostotarjoukset");
            print "<table class='tableOsto'>";
            print "<tr><th>ID</th><th>Rekisterinumero</th><th>Puhelinnumero</th><th>Sähköposti</th><th>Kokonimi</th><th>Raha</th><th>Kilometrilukema</th>
            <th>Lisätieto</th><th>Kuva</th><th>Käsittelyntila</th><th>Toiminnot</th></tr>";
            while ($rivi = mysqli_fetch_object($tulos)) {
                print "<tr>";
                print "<td>$rivi->id</td>";
                print "<td>$rivi->rekisterinumero</td>";
                print "<td>$rivi->puhelinnumero</td>";
                print "<td>$rivi->email</td>";
                print "<td>$rivi->kokonimi</td>";
                print "<td>$rivi->raha</td>";
                print "<td>$rivi->kilometrilukema</td>";
                print "<td>$rivi->lisatieto</td>";
                print "<td><img src='$rivi->tiedostoPolku' alt='Kuva ei lataudu tai sitä ei ole' onclick='suurennaKuva(this)'></td>";
                print "<td>$rivi->kasittelyntila</td>";
                print "<td><a href='./muokkaa.php?muokattava=$rivi->id'>Muokkaa</a> | <a href='./poista.php?poistettava=$rivi->id'>Poista</a></td>";
                print "</tr>";
            }
            print "</table>";
            mysqli_close($yhteys);
        ?>
    </main>
    
</body>
</html>