<?php
/**
 * Created by PhpStorm.
 * User: Staal
 * Date: 27-05-14
 * Time: 21:44
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
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>