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

####################################### FIM CABEÇALHO PADRÃO #############################################
?>


<!-- INICIO MASCARAS -->
<div class="mask" id="mask" style="display: none">
	<div class="painel_meio">
		<p onclick="closeMask('mask')" style="color: red">fechar X</p><h1>CADASTRO DE AULA</h1><hr>
		<form action='professor.php' class='form' method='post'>
            <input type='hidden' name='data[id_user]' value='<?php print $id_user;?>'>
            <input type='text'name='data[titulo]' placeholder="TÍTULO"><br>
            <textarea name='data[resumo]' placeholder="RESUMO"></textarea><br>
            <textarea name='data[pergunta]' placeholder="PERGUNTA"></textarea><br>
            <textarea name='data[resposta]' placeholder="RESPOSTA (A RESPOSTA NÃO APARECE PARA O ALUNO)"></textarea><br>
            <input type='text' name='data[link]' placeholder="LINK YOUTUBE"><br>
            <input type='button' id="cancelar" value='Cancelar' onclick="closeMask('mask')">
            <input type='submit' id="gravar" value='Gravar'><br>
        </form>
	</div>
</div>


<div class="mask_turma" id="mask_turma" style="display: none">
	<div class="painel_meio">
		<p onclick="closeMask('mask_turma')" style="color: red">fechar X</p><h1>DISPONIBILIZAR AULAS</h1><hr>
		<form action='professor.php' method='post'>
	<input type="hidden" name="turm[id_aula]" value="">
	Título: <input type="text" name="turm[titulo]" value=""><BR>
	 Turma:
            <select style="width:180px;" name="aluno[id_turma]">
	            <option></option>
	            <?php
	            $bsc_turma = DBRead('turma', "WHERE id_professor='$id_user'");
	            foreach ($bsc_turma as $tur){
	                $turma = $tur['id'];
	                print "<option value='$turma'>".$turma.'</option>';
	            }
	            ?>      
            </select><br>
            <?php //} ?>
            <input type='submit' value='Gravar'><br>
        </form>
	</div>
</div>

<!-- FIM MASCARAS-->

<!-- INICIO VALIDAÇÃO FORMULÁRIOS -->

<?php
if (isset($_POST['data'])){
    $data = $_POST['data'];
    //var_dump($data);
    $grava = DBGrava('aulas', $data, false);
}

?>

<!-- FIM VALIDAÇÃO FORMULÁRIOS -->
	
<header id='logo'>
	<div class="bg"><img src="imagens/logo.png"></div>
	<div class="inf_login">
		Seja bem vindo <?php echo $tipo;?> <?php echo $nick;?> | Matricula:  <?php echo $id_user;?> 
		| Data: <?php print (date('d/m/Y')); ?> |
		alterar senha
		 | <a href='index.php' onclick="session_destroy()">Sair</a>
	</div>
</header>

<div class="conteiner">

<article class='painel_esq_desk'>
	<ul>
		<li><a href='professor.php'>home</a></li>
		<li><a onclick="showMask('mask');">Cadastrar nova aula</a></li>

	</ul>
</article>


<?php

$painel = $_GET['painel'];


if($painel == 'aulas'){


// Valida form cadastro de aula
if (isset($_POST['data'])){
    $data = $_POST['data'];
    //var_dump($data);
    $grava = DBGrava('aulas', $data, false);
}

?>


<!--Painel aulas cadastradas -->


<article class='painel_dir_desk' id="painel_aulas" style="display: block;">
	
	<h1>AULAS CADASTRADAS</h1><a onclick="showMask('mask');"><img src='img/add.png' width='20' height='20'  alt='icone adicionar aula' title='Cadastrar nova aula'></a> |
	<a href="professor.php">voltar</a>

	<hr>
	
	<?php

		$bsc_aula = DBRead('aulas', "WHERE id_user='$id_user'");
			if ($bsc_aula != null){
				foreach ($bsc_aula as $au){
					$cod_aula = $au['id'];
					$titulo   = $au['titulo'];
					$link     = $au['link'];
		$corrige_link = str_replace('watch?v=',  'embed/', $link );
					
					print "<div class='linha_aula'>";
					print "<div class='link'><iframe width='180' height='101.25' src='".$corrige_link."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
					print "<div class='p_c_aulas'>Código de aula: ".str_pad($cod_aula, 4, 0, STR_PAD_LEFT)."</div>";
					print "<div class='p_t_aulas'>Título: ".$titulo."</div>";
					print "<div class='p_r_aulas'><a href='desktop.php?painel=confere&pergunta=".$cod_aula."'><img src='img/respostas.png' width='20' height='20' alt='icone respostas' title='Ver respostas dos alunos'></a></div>";
					print "<div class='p_e_aulas'><img src='img/excluir.png' width='20' height='20' onclick='Delete(1, $cod_aula);' alt='icone excluir' title='Excluir aula'></div>";
					print "<div class='p_d_aulas'><a href='desktop.php?painel=disponibiliza&cod_aula=".$cod_aula."'><img src='img/antena.png' width='20' height='20'  alt='icone transmitir' title='Liberar aula para as turmas'></a></div>";
					print "</div>";

			}//chave foreach bsc_aula
		}// if teste 
		else{
			print('Você não possui aulas cadastradas.');
		}
	?>

</article> 

<?php

}//Chave IF aulas
else if($painel == 'turmas'){

?>

<!--Painel turmas -->

<article class='painel_dir_desk' id="painel_turmas" style="display: block;">
	
	<h1>ÚLTIMAS TURMAS CADASTRADAS</h1>
	<a href="professor.php">voltar</a>
	<hr>
	
	<div class="linha1">
		<div class="campos_num"><th>TURMA</th></div>
		<div class="campos"><th>DISCIPLINA</th></div>
		<div class="campos_num"><th>LIMITE</th></div>
		<div class="campos_num"><th>CRIAÇÃO</th></div>
		<div class="campos_num"><th>TÉRMINO</th></div>
	</div><br><br>
		<?php
			//$bsc_turmas = DBRead('turma', "ORDER BY id DESC"/*, "WHERE id_professor='$id_user'"*/);
			$bsc_turmas = DBRead('administra ad', "join users u on ad.id_user = u.id join turma t on ad.id_turma = t.id WHERE u.id='$id_user'", 't.id, t.disciplina, t.lim_alunos, t.dt_criacao,  t.dt_termino');
			
				if ($bsc_turmas != null){
					foreach ($bsc_turmas as $dt){
						$table         = 'turma';
						$id_turma      = $dt['id'];
						$disc          = $dt['disciplina'];
						$limite        = $dt['lim_alunos'];
						$dt_criacao    = $dt['dt_criacao'];
						$dt_termino    = $dt['dt_termino'];
						print "<div class='linha1'>";
						print "<div class='campos_num'>".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</div>";
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


<?php
}//Chave IF turmas

else if($painel == 'turmas_coord'){

?>

<!--Painel turmas -->

<article class='painel_dir_desk' id="painel_turmas" style="display: block;">
	
	<h1>ÚLTIMAS TURMAS CADASTRADAS</h1>
	<a href="professor.php">voltar</a>
	<hr>
	
	<div class="linha1">
		<div class="campos_num"><th>TURMA</th></div>
		<div class="campos"><th>DISCIPLINA</th></div>
		<div class="campos_num"><th>LIMITE</th></div>
		<div class="campos_num"><th>CRIAÇÃO</th></div>
		<div class="campos_num"><th>TÉRMINO</th></div>
	</div><br><br>
		<?php
			//$bsc_turmas = DBRead('turma', "ORDER BY id DESC"/*, "WHERE id_professor='$id_user'"*/);
			$bsc_turmas = DBRead('turma');
			
				if ($bsc_turmas != null){
					foreach ($bsc_turmas as $dt){
						$table         = 'turma';
						$id_turma      = $dt['id'];
						$disc          = $dt['disciplina'];
						$limite        = $dt['lim_alunos'];
						$dt_criacao    = $dt['dt_criacao'];
						$dt_termino    = $dt['dt_termino'];
						print "<div class='linha1'>";
						print "<div class='campos_num'><a href='turmas.php?getturma=".$id_turma."'>".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</a></div>";
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


<?php
}//Chave IF turmas

else if($painel == 'alunos'){
?>
	<article class='painel_dir_desk' id="painel_alunos" style="display: block;">
	
	<h1>ALUNOS CADASTRADOS</h1>
	<a onclick="showMask('mask_cad_aluno');">cadastrar novo aluno</a> |
	<a href="professor.php">voltar</a>
	<hr>
	
	<div class="linha1">
		<div class="campos"><th>MATRICULA</th></div>
		<div class="campos"><th>NOME</th></div>
		<div class="campos"><th>EMAIL</th></div>
		<div class="campos_num"><th>CONTATO</th></div>
		<div class="campos_num"><th>STATUS</th></div>
	</div><br><br>
		<?php
			$bsc_turmas = DBRead('users', "WHERE tipo='aluno'");
			if ($bsc_turmas != null){
				foreach ($bsc_turmas as $dt){
					$matricula = $dt['id'];
					$nome      = $dt['nome_c'];
					$email     = $dt['user'];
					$contato   = $dt['contato'];
					$status    = $dt['status'];
					print "<div class='linha1'>";
					print "<div class='campos'><a href='alunos.php?getaluno=".$matricula."'>".str_pad($matricula, 4, 0, STR_PAD_LEFT)."</a></div>";
					print "<div class='campos'>".$nome."</div>";
					print "<div class='campos'>".$email."</div>";
					print "<div class='campos_num'>".$contato."</div>";
					if ($status == 1){
						print "<div class='campos_num'><input type='checkbox' value='0' checked></div>";
					}else{
						print "<div class='campos_num'><input type='checkbox' value='1'></div>";
					}
					print "</div><br><br>";
				}
				}else{
					print('Você não possui alunos cadastrados.');
				}// else
		?>
</article>
<?php
}// IF alunos

else if($painel == 'professor'){
?>
	<article class='painel_dir_desk' id="painel_alunos" style="display: block;">
	
	<h1>PROFESSORES CADASTRADOS</h1>
	<a href="professor.php">voltar</a>
	<hr>
	
	<div class="linha1">
		<div class="campos"><th>MATRICULA</th></div>
		<div class="campos"><th>NOME</th></div>
		<div class="campos"><th>EMAIL</th></div>
		<div class="campos_num"><th>CONTATO</th></div>
		<div class="campos_num"><th>STATUS</th></div>
	</div><br><br>
		<?php
			$bsc_turmas = DBRead('users', "WHERE tipo='professor'");
				foreach ($bsc_turmas as $dt){
					$matricula = $dt['id'];
					$nome      = $dt['nome_c'];
					$email     = $dt['user'];
					$contato   = $dt['contato'];
					$status    = $dt['status'];
					print "<div class='linha1'>";
					print "<div class='campos'>".str_pad($matricula, 4, 0, STR_PAD_LEFT)."</div>";
					print "<div class='campos'>".$nome."</div>";
					print "<div class='campos'>".$email."</div>";
					print "<div class='campos_num'>".$contato."</div>";
					if ($status == 1){
						print "<div class='campos_num'><input type='checkbox' value='0' checked></div>";
					}else{
						print "<div class='campos_num'><input type='checkbox' value='1'></div>";
					}
					print "</div><br><br>";
				}
		?>
</article>
<?php
}// IF professor

else if($painel == 'confere'){

$id_pergunta = $_GET['pergunta'];

?>

<article class='painel_dir_desk' id="painel_respostas" style="display: block;">
	
	<h1>ALUNOS QUE JA RESPONDERAM</h1>
	<a href="professor.php">voltar</a>
	<hr>
	
	<div class='linha1'>
		<div class='campos_num'>MATRÍCULA</div>
		<div class='campos'>NOME</div>
		<div class='campos'>PERGUNTA</div>
		<div class='campos_num'>DATA RESPOSTA</div>
		<div class='campos'>RESPOSTA</div>
	</div>
	<?php
		//$bsc_resp = DBRead('resposta r', "join users u on u.id = r.id_aluno join aulas a on r.id_pergunta = a.id WHERE r.resposta is not null", 'r.id, r.data, r.resposta, u.id, u.nome_c, a.pergunta');
		

		$bsc_resp = DBRead('resposta r', "join users u on r.id_aluno = u.id join aulas a on r.id_pergunta = a.id WHERE r.id_pergunta='$id_pergunta' AND a.id = '$id_pergunta'", 'r.id, r.data, r.resposta, u.id, u.nome_c, a.pergunta');
		//var_dump($bsc_resp);
			if ($bsc_resp != null){
				foreach ($bsc_resp as $dt){
					$matricula  = $dt['id'];
					$nome_c     = $dt['nome_c'];
					$pergunta   = $dt['pergunta'];
					$data       = $dt['data'];
					$resposta   = $dt['resposta'];
					
					print "<div class='linha1'>";
					print "<div class='campos_num'><a onclick='abreJanela_insere()'>".str_pad($matricula, 4, 0, STR_PAD_LEFT)."</a></div>";
					print "<div class='campos'>".$nome_c."</div>";
					print "<div class='campos'>".$pergunta."</div>";
					print "<div class='campos_num'>".$data."</div>";
					print "<div class='campos'>".$resposta."</div>";
					print "</div>";
					print "</form>";

					
			}//chave foreach bsc_resp
		}// if teste 
		else{
			print('Os alunos ainda não responderam.');
		}
	?>
</article> 
<?php
} //Chave if resposta

else if($painel == 'disponibiliza'){

$cod_aula = $_GET['cod_aula'];

if (isset($_POST['disp'])){
    $disp = $_POST['disp'];
    //var_dump($data);
    $grava = DBGrava('assiste', $disp, false);
}

?>

<article class='painel_dir_desk' id="painel_respostas" style="display: block;">
	
	<h1>DISPONIBILIZAR AULAS PARA AS TURMAS</h1>
	<a href="professor.php">voltar</a>
	<hr>
	
	<?php
		
		$bsc_aula = DBRead('aulas', "WHERE id='$cod_aula'");
			if ($bsc_aula != null){
				foreach ($bsc_aula as $au){
					$cod_aula = $au['id'];
					$titulo   = $au['titulo'];
					$link     = $au['link'];
					
		$corrige_link = str_replace('watch?v=',  'embed/', $link );
					
					print "<div class='linha_aula'>";
					print "<div class='link'><iframe width='180' height='101.25' src='".$corrige_link."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
					print "<div class='p_c_aulas'>Código de aula: ".str_pad($cod_aula, 4, 0, STR_PAD_LEFT)."</div>";
					print "<div class='p_t_aulas'>Título: ".$titulo."</div>";
					print "<div class='p_r_aulas'><a href='desktop.php?painel=confere&pergunta=".$cod_aula."'><img src='img/respostas.png' width='20' height='20' alt='icone respostas' title='Ver respostas dos alunos'></a></div>";
					print "<div class='p_e_aulas'><img src='img/excluir.png' width='20' height='20' onclick='Delete(1, $cod_aula);' alt='icone excluir' title='Excluir aula'></div>";
					print "<div class='p_d_aulas'><a href='desktop.php?painel=disponibiliza&cod_aula=".$cod_aula."'><img src='img/antena.png' width='20' height='20'  alt='icone transmitir' title='Liberar aula para as turmas'></a></div>";
					print "</div>";
			}//chave foreach bsc_aula
		}// if teste 
		else{
			print('Você não possui aulas cadastradas.');
		}
	?>
</article>


<article class='painel_dir_desk' id="painel_respostas" style="display: block;">
	
	<h1>TURMAS</h1>
	<hr>
	
	<div class="turmas_disp">
		<h1>TURMAS DISPONÍVEIS</h1>
		<?php
			//$bsc_turmas = DBRead('turma t', "JOIN assiste ass on t.id = ass.id_turma WHERE ass.id_aula != $cod_aula and t.id_professor = $id_user");
			$bsc_turmas = DBRead('turma', "WHERE id_professor = '$id_user'");
			
				if ($bsc_turmas != null){
					foreach ($bsc_turmas as $dt){
						//$table         = 'turma';
						$id_turma      = $dt['id'];
						$disc          = $dt['disciplina'];
						print "<form action='desktop.php?painel=disponibiliza&cod_aula=".$cod_aula."' method='post'>";
						print "<div class='linha1'>";
						print "<div class='campos_num'>".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</div>";
						print "<div class='campos'>".$disc."</div>";
						print "<div class='campos_icon'><img src='img/antena.png' width='20' height='20'onclick='submit()'></div>";
						print "</div><br><br>";
						print "<input type='hidden' name='disp[id_aula]'value='".$cod_aula."'>";
						print "<input type='hidden' name='disp[id_turma]'value='".$id_turma."'>";
						//print "<input type='submit'>";
						print "</form>";
					}// foreach bsc_turmas
				}// if teste 
				else{
					print('Você não possui turmas cadastradas.');
				}// else
		?>
	</div>
	<div class="turmas_selec">
		<h1>TURMAS SELECIONADAS</h1>
		<?php
			$bsc_selec = DBRead('assiste', "WHERE id_aula='$cod_aula' ORDER BY id DESC");
			//$bsc_selec = DBRead('turma t', "join assiste ass on t.id = ass.id_turma WHERE t.id_professor='$id_user'", 't.id, t.disciplina, t.lim_alunos, t.dt_criacao,  t.dt_termino');
			
				if ($bsc_selec != null){
					foreach ($bsc_selec as $dt){
						$id       = $dt['id']; 
						$id_turma = $dt['id_turma'];
						print "<div class='linha1'>";
						print "<div class='campos_num'>".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</div>";
						print "<div class='campos_num'><img src='img/excluir.png' width='20' height='20' onclick='Deldisp(4, $id, $cod_aula);'></div>";
						print "</div><br><br>";
					}// foreach bsc_turmas
				}// if teste 
				else{
					print('Esta aula ainda não foi disponibilizada.');
				}// else
		?>
	</div>
</article> 
<?php
} //Chave if bsc aula
?>


<script type="text/javascript" src="funcoes.js"></script>
</div>

<footer>
	<p>Plataforma desenvolvida por: Carlos LP Souza | Pedro Gastoldi | Roberto Neto</p>
</footer>
</body>
</html>
