<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Projeto PCA - Plataforma Extensão Escolar</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css"/>
<link href="css/estilos_aluno.css" rel="stylesheet" type="text/css"/>
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
$acesso = DBRead('users', "WHERE user='$user'");
if ($acesso == true){
	foreach ($acesso as $dt){
			$id_user = $dt['id'];
			$tipo    = $dt['tipo'];
			$nick    = $dt['nick'];
			$turma   = $dt['id_turma'];
		}
}

else{
	header("Refresh: 0;url=index.php");
	echo "<script>alert('Usuário ou senha inválidos')</script>";
}

###################################### FIM DO CABEÇALHO PADRÃO ##########################################


?>
<div class="conteiner">

<header id='logo'>
	<div class="bg"><img src="imagens/logo.png"></div>
	<div class="inf_login">
		Seja bem vindo <?php echo $tipo;?>: <?php echo $nick;?> | Matricula:  <?php echo $id_user;?> 
		| Data: <?php print (date('d/m/Y')); ?> |
		Alterar senha
		 | <a href='index.php' onclick="session_destroy()">Sair</a>
	</div>
</header>

<article class='painel_esq_desk'>
	<ul>
		<li><a onclick="showcadalunos();">Meu cadastro</a></li>
		<li><a onclick="showcadalunos();">Fale com professor</a></li>
		<li><a onclick="showcadalunos();">Mural</a></li>
	</ul>
</article>
<!--Painel Default -->
<article class='painel_dir_desk' id="painel_turmas" style="display: block;">
	<h1>SUAS AULAS</h1><hr>
	<div class="linhas_card">
	    <br>
		<?php
			$bsc_aulas = DBRead('aulas au', "join assiste ass on ass.id_aula = au.id"); //join turma t on ass.id_turma = t.id join participa p on p.id_turma = ass.id_turma ");
			//var_dump($bsc_aulas);
			if ($bsc_aulas != null){
				foreach ($bsc_aulas as $dt){
					$id         = $dt['id_aula'];
					$titulo     = $dt['titulo'];
					$resumo     = $dt['resumo'];
					$pergunta   = $dt['pergunta'];
					$link       = $dt['link'];
			$corrige_link       = str_replace('watch?v=',  'embed/', $link );
					
					print "<div class='linha_aluno_aula'>";
					print "<div class='link_aula'><iframe width='180' height='101.25' src='".$corrige_link."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
					print "<div class='aluno_titulo'><p>".$titulo."</p></div>";
					print "<div class='aluno_resumo' title=".$resumo.">".mb_strimwidth($resumo, 0, 30)."</div>";
					print "<div class='icone_abrir'><img src='img/abrir.png' width='20' height='20'  alt='icone abre aula' title='Clique para abrir a aula' onclick='abreJanela_aula($id)'></div>";
					print "</div>";
				}//Busca aulas
			}// if teste 
				else{
					print('Você não possui aulas liberadas.');
				}// else
		?>
</article>

</div>
<script type="text/javascript" src="funcoes.js"></script>
<footer>
	<p>Plataforma desenvolvida por: Carlos LP Souza | Pedro Gastoldi | Roberto Neto</p>
</footer>
</body>
</html>
