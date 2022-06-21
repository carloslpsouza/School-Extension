<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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


###################################### FIM DO CABEÇALHO PADRÃO ##########################################


if(isset($_GET['getturma'])){
	$getturma = $_GET['getturma'];
}else{
	$getturma = null;
}

if (isset($_POST['turma_aluno'])){
    $turma_aluno = $_POST['turma_aluno'];
    var_dump($data);
    $grava = DBGrava('participa', $turma_aluno, false);
}



?>

<header id='logo'>
	<div class="bg"><img src="imagens/logo.png"></div>
	<div class="inf_login">
		Seja bem vindo <?php echo $tipo;?> <?php echo $nick;?> | Matricula:  <?php echo $id_user;?> 
		| Data: <?php print (date('d/m/Y')); ?> |
		Alterar senha
		 | <a href='index.php' onclick="session_destroy()">Sair</a>
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



<article class='painel_dir_desk' id="painel_turmas" style="display: block;">
	<h1>ÚLTIMAS TURMAS CADASTRADAS</h1><a href="professor.php">Voltar</a><hr>
	<div class="linha1">
		<div class="campos"><th>TURMA</th></div>
		<div class="campos"><th>DISCIPLINA</th></div>
		<div class="campos_num"><th>LIMITE</th></div>
		<div class="campos_num"><th>CRIAÇÃO</th></div>
		<div class="campos_num"><th>TÉRMINO</th></div>
	</div><br><br>
		<?php 
			//$bsc_turmas = DBRead('turma', "ORDER BY id DESC LIMIT 3 "/*, "WHERE id_professor='$id_user'"*/);
			if ($getturma != null){
			$bsc_turmas = DBRead('turma', "WHERE id = '$getturma' ORDER BY id DESC");
			}else{
				$bsc_turmas = DBRead('turma', "ORDER BY id DESC");
			}
				if ($bsc_turmas != null){
					foreach ($bsc_turmas as $dt){
						//$table         = 'turma';
						$id_turma      = $dt['id'];
						$disc          = $dt['disciplina'];
						$limite        = $dt['lim_alunos'];
						$dt_criacao    = $dt['dt_criacao'];
						$dt_termino    = $dt['dt_termino'];
						print "<div class='linha1'>";
						print "<div class='campos'><a href='turmas.php?getturma=".$id_turma."'>".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</a></div>";
						print "<div class='campos'>".$disc."</div>";
						print "<div class='campos_num'>".$limite."</div>";
						print "<div class='campos_num'>".$dt_criacao."</div>";
						print "<div class='campos_num'>".$dt_termino."</div>";
						print "</div><br><br>";
					}// foreach bsc_turmas
				}// if teste 
				else{
					print('Você não possui turmas cadastradas.');
				}// else
		?>
</article>


<article class='painel_dir_desk' id="painel_alunos" style="display: block;">
	<h1>ALUNOS CADASTRADOS</h1>
	<?php
	if ($getturma != null){
		?>
		<a onclick="showMask('inclui_aluno')">adicionar aluno a turma</a>&nbsp&nbsp&nbsp;
		<?php
	}
	?><a href="professor.php">voltar</a><hr>
	<div class="linha1">

		<div class="campos_num"><th>MATRICULA</th></div>
		<div class="campos"><th>NOME</th></div>
		<div class="campos"><th>EMAIL</th></div>
		<div class="campos_num"><th>CONTATO</th></div>
		<div class="campos_num"><th>REMOVER</th></div>
	</div><br><br>
		<?php 
			if ($getturma != null){
			$bsc_alunos = DBRead('users u', "JOIN participa p on u.id = p.id_aluno WHERE p.id_turma='$getturma'");
			//var_dump($bsc_alunos);
					if ($bsc_alunos != null){
						foreach ($bsc_alunos as $dt){
							$id        = $dt['id'];
							$matricula = $dt['id_aluno'];
							$nome      = $dt['nome_c'];
							$email     = $dt['user'];
							$contato   = $dt['contato'];
							$status    = $dt['status'];
							print "<div class='linha1'>";

							print "<div class='campos_num'><a href='alunos.php?getaluno=".$matricula."'>".str_pad($matricula, 4, 0, STR_PAD_LEFT)."</a></div>";
							print "<div class='campos'>".$nome."</div>";
							print "<div class='campos'>".$email."</div>";
							print "<div class='campos_num'>".$contato."</div>";
							print "<div class='campos_num'><img src='img/excluir.png' width='14' height='14' onclick='Delalturma(5, $id, $matricula);'></div>";
							print "</div><br><br>";
				}
			}// foreach	
			}else{
				$bsc_alunos = DBRead('users', "WHERE tipo='aluno' ORDER BY id DESC");
					if ($bsc_alunos != null){
						foreach ($bsc_alunos as $dt){
							$matricula = $dt['id'];

							$nome      = $dt['nome_c'];
							$email     = $dt['user'];
							$contato   = $dt['contato'];
							$status    = $dt['status'];
							print "<div class='linha1'>";

							print "<div class='campos_num'><a href='alunos.php?getaluno=".$matricula."'>".str_pad($matricula, 4, 0, STR_PAD_LEFT)."</a></div>";
							print "<div class='campos'>".$nome."</div>";
							print "<div class='campos'>".$email."</div>";
							print "<div class='campos_num'>".$contato."</div>";
							print "<div class='campos_num'><img src='img/excluir.png' width='14' height='14' onclick='Delalturma(5, $matricula, $getturma);'></div>";							
							print "</div><br><br>";
				}
			}// foreach	
			}

		?>
		<div class='linha1' id="inclui_aluno" style="display: none">
			<div class="campos">
				<form method="post" action="turmas.php?getturma=<?php print $getturma ?>" class="form">
					<input type="text" name="turma_aluno[id_aluno]" value="" placeholder="Matrícula">
					<input type="hidden" name="turma_aluno[id_turma]" value="<?php print $getturma; ?>">
					<input type="button" id="cancelar" onclick="closeMask('inclui_aluno')" value="cancelar">
					<input type="submit" id="gravar" value="gravar">
				</form>
			</div>
		</div>
</article>

<script type="text/javascript" src="funcoes.js"></script>
</div>

<footer>
	<p>Plataforma desenvolvida por: Carlos LP Souza | Pedro Gastoldi | Roberto Neto</p>
</footer>
</body>
</html>
