<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ostotarjoukset - hallinnointisivu</title>
    <link rel="stylesheet" href="../css/styles-mikko.css">
</head>
<body>
    <header class="headerHuolto">
        <h1 class="h1Huolto">LUXCAR</h1>
        <h2>henkilökunnan hallinnointisivu</h2>
    </header>
    <nav class="navHuolto">
        <ul class="navUlHuolto">
            <li class="liHuolto"><a class="aHuolto">OSTOTARJOUKSET</a></li>
        </ul>
    </nav>
    <main>
    <?php
            mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

            $initials=parse_ini_file("./.ht.asetukset.ini");
            
            try{
                $yhteys=mysqli_connect($initials["palvelin"], $initials["tunnus"] , $initials["pass"], $initials["tk"]);
            }
            catch(Exception $e){
                header("Location:./yhteysvirhe.html");
                exit;
            }

            $tulos=mysqli_query($yhteys, "select * from ostotarjoukset");
            print "<table border='1'>";
            print "<tr><th>ID</th><th>Rekisterinumero</th><th>Puhelinnumero</th><th>Sähköposti</th><th>Kokonimi</th><th>Raha</th>
            <th>Kilometrilukema</th><th>Lisätieto</th><th>Kuva</th><th>Käsittelyntila</th><th>Toiminnot</th></tr>";
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
                print "<td>$rivi->kuva</td>";
                print "<td>$rivi->kasittelyntila</td>";
                print "<td><a href='./katso.php?katsottava=$rivi->id'>Katso</a> | <a href='./muokkaa.php?muokattava=$rivi->id'>Muokkaa</a> | 
                <a href='./poista.php?poistettava=$rivi->id'>Poista</a></td>";
                print "</tr>";
            }
            print "</table>";
            mysqli_close($yhteys);
        ?>
    </main>
</body>
</html>