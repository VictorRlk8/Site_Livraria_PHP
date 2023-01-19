<?php 
$servidor = "Localhost";
$usuario = "ead";
$senha = "1234567";
$banco = "db_ead";
$porta = "3307";
$cn = new PDO("mysql:host=$servidor;dbname=$banco; port=$porta;",$usuario, $senha);
?>