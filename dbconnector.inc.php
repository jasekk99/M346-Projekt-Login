<?php


//DONT FORGET to change these values when working on prod.
//$host = 'modul346-sql.mysql.database.azure.com';
//$database = 'm346_login';
//$username = 'AdminSQL';
//$password = 'fqHui89**eoQ';

$host = 'modul346-sql.mysql.database.azure.com';
$database = 'm346_login';
$username = 'AdminSQL';
$password = 'modul346!';

// mit datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// fehlermeldung, falls die Verbindung fehl schlägt.
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_error . ') '. $mysqli->connect_error);
}

?>