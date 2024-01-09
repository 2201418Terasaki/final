<?php
const SERVER = 'mysql220.phy.lolipop.lan';
const DBNAME = 'LAA1517364-final';
const USER = 'LAA1517364';
const PASS = 'terasaki';
$connect = 'mysql:host='.SERVER.';dbname='.DBNAME.';charset=utf8';
$pdo = new PDO($connect, USER, PASS);
?>
