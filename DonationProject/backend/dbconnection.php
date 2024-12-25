<?php

$db = new mysqli('localhost', 'root', '', 'donationdb');

if ($db->connect_error) 
{
    die("Veritabanı Bağlantı hatası: " . $db->connect_error);
}

?>