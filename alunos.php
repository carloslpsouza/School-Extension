<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>Projeto PCA - Plataforma Extensão Escolar</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css"/>
<link href="css/estilospca.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<?php 
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

####################################### FIM CABEÇALHO PADRÃO #############################################


####################################### INICIO VALIDAÇÃO FORMULÁRIOS #####################################

if(isset($_GET['getaluno'])){
	$getaluno = $_GET['getaluno'];
}else{
	$getaluno = null;
}

if (isset($_POST['turma_aluno'])){
    $turma_aluno = $_POST['turma_aluno'];
    //var_dump($data);
    $grava = DBGrava('participa', $turma_aluno, false);
}


####################################### FIM VALIDAÇÃO FORMULÁRIOS ########################################

?>




<header id='logo'>
	<div class="bg"><img src="imagens/logo.png"></div>
	<div class="inf_login">
		Seja bem vindo <?php echo $tipo;?> <?php echo $nick;?> | Matricula:  <?php echo $id_user;?> 
		| Data: <?php print (date('d/m/Y')); ?> |
		<a href='index.php' onclick="session_destroy()">Sair</a>
		 | Alterar senha
	</div>
</header>

<div class="conteiner">


<article class='painel_esq_desk'>
	<ul>
		<li><a href="turmas.php">Turmas X Alunos</a></li>
	</ul>

	<form method="get" action="turmas.php" class="form">
		<input type="text" name="getturma" placeholder=" Digite a turma">
		<input type="submit" value="Buscar">
	</form>
</article>


<!--############################ PAINEL ALUNO  -->


<article class='painel_dir_desk' id="painel_turmas" style="display: block;">
	<h1>ALUNO</h1><a href="professor.php">Voltar</a><hr>
	<div class="linha1">
		<div class="campos_num"><th>MATRÍCULA</th></div>
		<div class="campos"><th>NOME</th></div>
		<div class="campos"><th>EMAIL</th></div>
		<div class="campos_num"><th>CONTATO</th></div>
		<div class="campos_num"><th>STATUS</th></div>
		<div class="campos_num"><th>REMOVER</th></div>
	</div><br><br>
		<?php 
			if ($getaluno != null){
			$bsc_alunos = DBRead('users', "WHERE id = '$getaluno'");
					if ($bsc_alunos != null){
						foreach ($bsc_alunos as $dt){
							$matricula = $dt['id'];
							$turma     = $dt['id_turma'];
							$nome      = $dt['nome_c'];
							$email     = $dt['user'];
							$contato   = $dt['contato'];
							$status    = $dt['status'];
							print "<div class='linha1'>";
							print "<div class='campos_num'>".str_pad($matricula, 4, 0, STR_PAD_LEFT)."</div>";
							print "<div class='campos'>".$nome."</div>";
							print "<div class='campos'>".$email."</div>";
							print "<div class='campos_num'>".$contato."</div>";
							if ($status == 1){
								print "<div class='campos_num'><input type='checkbox' value='0' checked></div>";
							}else{
								print "<div class='campos_num'><input type='checkbox' value='1'></div>";
							}
							print "<div class='campos_num'><img src='img/excluir.png' width='14' height='14' onclick='Delalturma(5, $matricula, $turma);'></div>";
							print "</div><br><br>";
				}
			}// foreach	
			}


		?>
</article>

<article class='painel_dir_desk' id="painel_respostas" style="display: block;">
	
	<h1>TURMAS</h1>
	<hr>
	
	<div class="turmas_disp">
		<h1>TURMAS DISPONÍVEIS</h1>
		<?php

			//$bsc_turmas = DBRead('participa pa', "JOIN turma t ON t.id = pa.id_turma WHERE pa.id_aluno != $getaluno", 't.id, t.disciplina');

			$bsc_turmas = DBRead('turma ');
			
				if ($bsc_turmas != null){
					foreach ($bsc_turmas as $dt){
						//$table         = 'turma';
						$id_turma      = $dt['id'];
						$disc          = $dt['disciplina'];
						print "<form action='alunos.php?getaluno=".$getaluno."&cod_turma=".$id_turma."' method='post'>";
						print "<div class='linha1'>";
						print "<div class='campos'><a href='turmas.php?getturma=".$id_turma."'>".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</a></div>";
						print "<div class='campos'>".$disc."</div>";
						print "<div class='campos_icon'><img src='img/antena.png' width='14' height='14'onclick='submit()'></div>";
						print "</div><br><br>";
						print "<input type='hidden' name='turma_aluno[id_aluno]'value='".$getaluno."'>";
						print "<input type='hidden' name='turma_aluno[id_turma]'value='".$id_turma."'>";
						//print "<input type='submit'>";
						print "</form>";
					}// foreach bsc_turmas
				}// if teste 
				else if ($bsc_turmas == null){
					$bsc_turmas_ini = DBRead('turma');
						foreach ($bsc_turmas_ini as $dt){
						//$table         = 'turma';
						$id_turma      = $dt['id'];
						$disc          = $dt['disciplina'];
						print "<form action='alunos.php?getaluno=".$getaluno."&cod_turma=".$id_turma."' method='post'>";
						print "<div class='linha1'>";
						print "<div class='campos'><a href='turmas.php?getturma=".$id_turma."'>".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</a></div>";
						print "<div class='campos'>".$disc."</div>";
						print "<div class='campos_icon'><img src='img/antena.png' width='14' height='14'onclick='submit()'></div>";
						print "</div><br><br>";
						print "<input type='hidden' name='turma_aluno[id_aluno]'value='".$getaluno."'>";
						print "<input type='hidden' name='turma_aluno[id_turma]'value='".$id_turma."'>";
						//print "<input type='submit'>";
						print "</form>";
					}// foreach bsc_turmas
				}// else
		?>
	</div>
	<div class="turmas_selec">
		<h1>TURMAS SELECIONADAS</h1>
		<?php
			$bsc_selec = DBRead('participa pa', "JOIN turma t ON pa.id_turma = t.id WHERE id_aluno='$getaluno'", "pa.id, pa.id_turma, t.disciplina");
			
				if ($bsc_selec != null){
					foreach ($bsc_selec as $dt){
						$id       = $dt['id']; 
						$id_turma = $dt['id_turma'];
						$disc     = $dt['disciplina'];
						print "<div class='linha1'>";
						print "<div class='campos_num'>".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</div>";
						print "<div class='campos'>".$disc."</div>";
						print "<div class='campos_num'><img src='img/excluir.png' width='14' height='14' onclick='Deldisp(5, $id, $getaluno);'></div>";
						print "</div><br><br>";
					}// foreach bsc_turmas
				}// if teste 
				else{
					print('Nenhuma turma selecionada.');
				}// else
		?>
	</div>
</article> 
<?php
 //Chave if bsc aula
?>

<script type="text/javascript" src="funcoes.js"></script>

</div>

<footer>
	<p>Plataforma desenvolvida por: Carlos LP Souza | Pedro Gastoldi | Roberto Neto</p>
</footer>
</body>
</html>
