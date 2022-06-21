<?php
session_start();

require_once("config.php");
require_once("connect.php");
require_once("database.php");


$_SESSION['user'] = $_POST['user'];
$_SESSION['sw']   = $_POST['sw'];

	$user = $_SESSION['user'];
	$sw   = $_SESSION['sw']; 

//Valida usuário
$acesso = DBRead('users', "WHERE user='$user' AND password='$sw'");
if ($acesso == true){
	foreach ($acesso as $dt){
		$tipo    = $dt['tipo'];
	}// foreach
	if ($tipo == 'professor' || $tipo == 'coordenador' ){
		header("Refresh: 0;url=professor.php");
	}elseif ($tipo == 'aluno'){
		header("Refresh: 0;url=aluno.php");
	}
}else{
	header("Refresh: 0;url=index.php");
	echo "<script>alert('Usuário ou senha inválidos')</script>";
}//else
	
?>
