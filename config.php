<?php

/* Enter the MySQL configuration details below */

$dbhost = "localhost";
$dbport = "3306";
$dbname = "dredger";
$dbuser = "root";
$dbpasswd = "";
$conn = new mysqli("localhost","root","","dredger");
$conn = new mysqli($dbhost,$dbuser,$dbpasswd,$dbname);
if($conn->connect_error)
{
    echo" an error occured!";
}

?>