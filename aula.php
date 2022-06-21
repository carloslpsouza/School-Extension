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

$user    = $_SESSION['user'];
$sw      = $_SESSION['sw']; 
$id_aula = $_GET['id'];
//Valida usuário
$acesso = DBRead('users', "WHERE user='$user'");
if ($acesso == true){
	foreach ($acesso as $dt){
			$id_user = $dt['id'];
			$nome    = $dt['nome_c'];
			$turma   = $dt['id_turma'];
		}
}

else{
	header("Refresh: 0;url=index.php");
	echo "<script>alert('Usuário ou senha inválidos')</script>";
}

###################################### FIM DO CABEÇALHO PADRÃO ##########################################


if (isset($_POST['resp'])){
    $resp = $_POST['resp'];
    //var_dump($resp);
    $grava_resposta = DBGrava('resposta', $resp, false);
}

?>


<div class="conteiner">
<?php
	$bsc_aulas = DBRead('aulas', "WHERE id='$id_aula' ");
		foreach ($bsc_aulas as $dt){
			$titulo     = $dt['titulo'];
			$resumo     = $dt['resumo'];
			$pergunta   = $dt['pergunta'];
			$link       = $dt['link'];
	$corrige_link = str_replace('watch?v=',  'embed/', $link );

?>
<article class='painel_esq'>
	<iframe width="560" height="315" src="<?php print $corrige_link; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</article>
<!--Painel Default -->
<article class='painel_dir' id="painel_turmas" style="display: block;">
	<h1><?php print $titulo;?></h1><hr>
	
	<p><h1>Resumo:</h1>
	<?php print $resumo;?></p>

	<p><h1>Pergunta:</h1>
	<?php print $pergunta;?></p>
	<?php
		$bsc_aulas = DBRead('resposta', "WHERE id_pergunta='$id_aula' AND id_aluno='$id_user'", 'resposta');
		//var_dump($bsc_aulas);
		if ($bsc_aulas){
			foreach ($bsc_aulas as $dt) {
				$resposta = $dt['resposta'];
			}
		}
		if (!$bsc_aulas) {
			?>
	Resposta:<br>

	<form action="aula.php?id=<?php print $id_aula; ?>" method="post" class="form" >
		<input type="hidden" name="resp[id_aluno]" value="<?php print $id_user; ?>">
		<input type="hidden" name="resp[id_pergunta]" value="<?php print $id_aula; ?>">
		<input type="hidden" name="resp[data]" value="<?php print date('Y/m/d'); ?>">
		<textarea name='resp[resposta]' placeholder="Escreva sua resposta"></textarea><br>
		<p>
		<input type='button' id="cancelar" value='Cancelar' onclick="window.close()">
        <input type='submit' id="gravar" value='Enviar'><br>
        </p>
		<?php
		}else{
			print "Você ja respondeu a pergunta, sua resposta foi: <strong>( ".$resposta." )</strong>";
		}
		?>
		

	</form>
				
</article>

<?php
}//Busca aulas
?>
</div>
<footer>
	<p>Plataforma desenvolvida por: Carlos LP Souza | Pedro Gastoldi | Roberto Neto</p>
</footer>
</body>
</html>
