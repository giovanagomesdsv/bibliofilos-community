<?php 
$hostname = "localhost";
$banco = "bd_tcc_etim_123_g2";
$usuario = "us_tcc_etim_123_g2";
$senha = "ec0623";

$conn = new mysqli($hostname, $usuario, $senha, $banco);

if ($conn->connect_errno) {
    echo "Falha ao se conectar: ". $conn->connect_errno." ->". $conn->connect_error;
} 
?>