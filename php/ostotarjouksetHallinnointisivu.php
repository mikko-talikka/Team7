<?php
// Aloitetaan sessio
    session_start();
    // Vaatii, että henkilö on kirjautunut sivulle, jos ei ole, siirrytään kirjaudu.php
    if (!isset($_SESSION["user_ok"])){
        $_SESSION["paluuosoite"]="ostotarjouksetHallinnointisivu.php";
        header("Location:./kirjaudu.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ostotarjoukset ja huoltopyynnöt - hallinnointisivu</title>
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
            <li class="liOsto"><a class="aOsto">OSTOTARJOUKSET JA HUOLTOPYYNNÖT</a></li>
            <li class="liOsto"><a href="./dokumentaatio/WebOhjelmointi_team7.docx" download="DokumentaatioTeam7" class="aOsto">LATAA RYHMÄTYÖN DOKUMENTAATIO TÄSTÄ</a></li>
            <li class="liUloskirjaus"><a class="aUloskirjaus" href="./uloskirjaus.php"><h3>KIRJAUDU ULOS</h3></a></li>
        </ul>
    </nav>
    <main class="mainOsto">
        <?php
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
            // ostotarjousten hakeminen tietokannasta
            $tulos=mysqli_query($yhteys, "select * from ostotarjoukset");
            // ostotarjousten otsikon tulostaminen
            print "<h2 class='otsikko'>Ostotarjoukset</h2>";
            // ostotarjoustaulukon alku
            print "<div class='divOsto'>";
            print "<table class='tableOsto'>";
            print "<tr><th>ID</th><th>Rekisterinumero</th><th>Puhelinnumero</th><th>Sähköposti</th><th>Kokonimi</th><th>Raha</th><th>Kilometrilukema</th>
            <th>Lisätieto</th><th>Kuva</th><th>Käsittelyn tila</th><th>Toiminnot</th></tr>";
            // ostotarjousten tulostaminen taulokkoon
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
            // ostotarjoustaulukon loppu
            print "</table>";
            print "</div>";

            // huoltopyyntöjen hakeminen tietokannasta
            $tulos=mysqli_query($yhteys, "select * from huolto");
            // huoltopyyntöjen otsikon tulostaminen
            print "<h2 class='otsikko'>Huoltopyynnöt</h2>";
            // huoltopyyntötaulukon alku
            print "<div class='divOsto'>";
            print "<table class='tableOsto'>";
            print "<tr><th>ID</th><th>Kokonimi</th><th>Puhelinnumero</th><th>Sähköposti</th><th>Huoltopäivä</th><th>Huoltoaika</th><th>Lisätiedot</th>
            <th>Käsittelyn tila</th><th>Toiminnot</th></tr>";
            // huoltopyyntöjen tulostaminen taulokkoon
            while ($rivi = mysqli_fetch_object($tulos)) {
                print "<tr>";
                print "<td>$rivi->id</td>";
                print "<td>$rivi->kokonimi</td>";
                print "<td>$rivi->puhelinnumero</td>";
                print "<td>$rivi->email</td>";
                print "<td>$rivi->date</td>";
                print "<td>$rivi->time</td>";
                print "<td>$rivi->viesti</td>";
                print "<td>$rivi->kasittelyntila</td>";
                print "<td><a href='./muokkaa2.php?muokattava2=$rivi->id'>Muokkaa</a> | <a href='./poista2.php?poistettava2=$rivi->id'>Poista</a></td>";
                print "</tr>";
            }
            // huoltopyyntötaulukon alku
            print "</table>";
            print "</div>";
            mysqli_close($yhteys);
        ?>
    </main>
    
</body>
</html>