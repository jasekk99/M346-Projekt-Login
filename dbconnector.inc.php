<?php

$host = 'localhost';
$database = 'M346_login';
$username = 'M346_dev';
$password = 'M346_dev';

// mit datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// fehlermeldung, falls die Verbindung fehl schlägt.
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_error . ') '. $mysqli->connect_error);
}

?>