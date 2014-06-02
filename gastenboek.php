<?php
/**
 * Created by PhpStorm.
 * User: Staal
 * Date: 27-05-14
 * Time: 22:02
 */

error_reporting(E_ALL);
$host = "localhost"; // Je host
$user = "maico"; // Je MySQL gebruikersnaam
$pass = "test"; // Je MySQL wachtwoord
$datb = "test"; // Je MySQL database

// Verbinding maken
mysql_connect($host, $user, $pass) or die ("Er is iets mis gegaan");
mysql_select_db($datb) or die ("Er is iets mis gegaan");

// UBB aanmaken
function ubb($string) {
    $string = htmlspecialchars($string); // Beveiligen voor XSS injection
    $string = stripslashes($string); // Slashes verwijderen
    $string = nl2br($string); // Zorgen dat er meerdere regels gebruikt kunnen worden
    $string = preg_replace("#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $string); // [b][/b] => <b></b>
    $string = preg_replace("#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $string); // [i][/i] => <i></i>
    $string = preg_replace("#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $string); // [u][/u] => <u></u>
    $string = preg_replace("#\[s\](.+?)\[/s\]#is", "<s>\\1</s>", $string); // [s][/s] => <s></s>

    return $string;
}

?>

<!-- Begin HTML -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Gastenboek - Gemaakt door Maico</title>
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'/>

<!-- Begin CSS -->
<style type="text/css">
.label{
    margin:0 0 5px 0;
	float:left;
	display:block;
}

input, textarea{
    font:14px 'Ubuntu', Verdana, Geneva, sans-serif;
}

input:focus, textarea:focus{
    background: rgb(255,255,255); /* Old browsers */
    background: -moz-linear-gradient(top,  rgba(255,255,255,1) 0%, rgba(229,229,229,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(100%,rgba(229,229,229,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */
}

.input{
    border:none;
    padding:10px 20px;
	font:14px 'Ubuntu', Verdana, Geneva, sans-serif;
	color:#fff;
	background: rgb(125,126,125); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(125,126,125,1) 0%, rgba(14,14,14,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(125,126,125,1)), color-stop(100%,rgba(14,14,14,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom,  rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7d7e7d', endColorstr='#0e0e0e',GradientType=0 ); /* IE6-9 */
}
</style>

</head>
<body style="font:16px 'Ubuntu', Verdana, Geneva, sans-serif;">

<div style="width:500px; margin:0 auto;">
<h1 style="text-align:center;">Gastenboek</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Als er een veld niet ingevuld is
        if (empty($_POST['naam']) || empty($_POST['bericht'])) {
            echo '<span style="color:red; font-weight: bold">Je hebt niet alle velden ingevuld!</span>';
        } elseif (strlen($_POST['naam']) > 16 || strlen($_POST['bericht']) > 500) {
            echo '<span style="color:red; font-weight: bold">De ingevulde velden hebben te veel karakters (naam maximaal 16, bericht maximaal 500)</span>';
        } else {
            // Als alle velden ingevuld zijn wordt het bericht gefilterd toegevoegd
            if (mysql_query("INSERT INTO gastenboek (naam, bericht, datum, ip) VALUES ('".trim(mysql_real_escape_string($_POST['naam']))."', '".trim(mysql_real_escape_string($_POST['bericht']))."', NOW(), '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."')")) {
                echo '<span style="color:green; font-weight: bold"Je reactie is succesvol toegevoegd!</span>';
            } else {
                echo '<span style="color:green; font-weight: bold">Er is iets fout gegaan en je reactie is niet toegevoegd. Probeer het later opnieuw.</span>';
            }
        }
    }
    ?>

<form method="post" action=""><p>
        <span class="label">Naam: (maximaal 16 karakters)</span><br />
        <input type="text" style="width:478px; padding:5px 10px; margin:0; -webkit-box-shadow: 0px 2px 5px rgba(50, 50, 50, 0.5); -moz-box-shadow: 0px 2px 5px rgba(50, 50, 50, 0.5); box-shadow:0px 2px 5px rgba(50, 50, 50, 0.5); border:1px solid #000" name="naam" maxlength="16" /><br /><br />
        <span class="label">Bericht: (maximaal 500 karakters)</span><br />
        <textarea style="width:478px; height:250px; padding:5px 10px; margin:0; -webkit-box-shadow: 0px 2px 5px rgba(50, 50, 50, 0.5); -moz-box-shadow: 0px 2px 5px rgba(50, 50, 50, 0.5); box-shadow:0px 2px 5px rgba(50, 50, 50, 0.5); border:1px solid #000" name="bericht" id="tekst" rows="6" cols="37"></textarea><br /><br />
        <input class="input"  type="submit" value="Toevoegen" onclick="this.value='Reactie wordt geplaatst...';" /> <input class="input"  type="reset" value="Herstel" />
    </p></form>
<hr />
<p>

    <?php
    // Gegevens ophalen uit de database en sorteren op id
    $sql = mysql_query("SELECT * FROM gastenboek ORDER BY datum DESC");
    if (mysql_num_rows($sql) == 0) {
        // Als er nog geen reacties geplaatst zijn
        echo 'We hebben nog geen reacties!';
    } else {
        while($data = mysql_fetch_assoc($sql)) {
            // Als er wel reacties zijn geplaatst worden deze nu weergegeven
            echo '<b>Naam:</b> '.htmlspecialchars(stripslashes($data['naam'])).'<br />
        <b>Datum:</b> '.htmlspecialchars(stripslashes($data['datum'])).'<br />
        <b>Bericht:</b><br />'.ubb($data['bericht']).'<br /><br />';
        }
    }
    ?>

</p>
</div>
</body>
</html>