<?php 
$hostname = "10.67.22.216";
$banco = "bd_tcc_etim_123_g2";
$usuario = "us_etim_123_g2";
$senha = "ec0623";

$conn = new mysqli($hostname, $usuario, $senha, $banco);

if ($conexao->connect_errno) {
    echo "Falha ao se conectar: ". $conexao->connect_errno." ->". $conexao->connect_error;
} 
?>