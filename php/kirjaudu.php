<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="../css/styles-eemeli.css">
    </head>
    <body>
        
        <header class="headerKirjaudu">
            <h1 class="h1Kirjaudu">LUXCAR</h1>
            <h2 class="h2Kirjaudu">Henkilökunnan sisäänkirjautuminen</h2>
        </header>
        <!--Formi kirjautumista varten-->
        <form class="kirjaudu" action='./tarkistakirjautuminen.php' method='post' class="kirjaudu">
            Tunnus: <input type='text' name='tunnus' value=''><br>
            Salasana: <input type='password' name='salasana' value=''><br>
            <input type='submit' name='ok' value='OK'><br>
        </form>

</body>
</html>