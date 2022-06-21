<?php
session_start();
 
require_once("config.php");
require_once("connect.php");
require_once("database.php");

$user = $_SESSION['user'];
$sw   = $_SESSION['sw']; 

//Valida usuário
$acesso = DBRead('users', "WHERE user='$user' AND password='$sw'");
if ($acesso == true){
	foreach ($acesso as $dt){
			$id_user = $dt['id'];
			$nick    = $dt['nick'];
			$tipo    = $dt['tipo'];
		}
}

else{
	header("Refresh: 0;url=index.php");
	echo "<script>alert('Usuário ou senha inválidos')</script>";
}

if (isset($_GET['id'])){
	$id       = $_GET['id'];
	$table    = $_GET['table'];
	$cod_aula = $_GET['cod_aula'];

	if ($table == 1){
		$table = 'aulas';
		$delete = DBDelete($table, 'id='.$id);
		header("Refresh: 0;url=professor.php");
	}
	if ($table == 2){
		$table = 'turma';
		$delete = DBDelete($table, 'id='.$id);
		header("Refresh: 0;url=professor.php");
	}
	if ($table == 3){
		$table = 'users';
		$delete = DBDelete($table, 'id='.$id);
		header("Refresh: 0;url=professor.php");
	}
	if ($table == 4){
		$table = 'assiste';
		$delete = DBDelete($table, 'id='.$id);
		header("Refresh: 0;url=desktop.php?painel=disponibiliza&cod_aula=".$cod_aula);
	}
	if ($table == 5){
		$table = 'participa';
		$delete = DBDelete($table, 'id='.$id);
		header("Refresh: 0;url=alunos.php?getaluno=".$cod_aula);
	}
	
}
?>
