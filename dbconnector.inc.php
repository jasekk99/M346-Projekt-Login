<?php

$host = '13.73.160.137';
$database = 'm346_login';
$username = 'AdminSQL';
$password = 'fqHui89**eoQ';

// mit datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// fehlermeldung, falls die Verbindung fehl schlägt.
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_error . ') '. $mysqli->connect_error);
}

?>