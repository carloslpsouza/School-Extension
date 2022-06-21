<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Projeto PCA - Plataforma Extensão Escolar</title>
<link href="css/estilospca.css" rel="stylesheet" type="text/css"/>
<link href="css/estilos.css" rel="stylesheet" type="text/css"/>
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






####################################### INICIO IF CORRDENADOR #############################################

//Valida painel
if($tipo == 'coordenador'){

// Valida form cadastro de aula
if (isset($_POST['usuario'])){
    $data = $_POST['usuario'];
    //var_dump($data);
    $grava = DBGrava('users', $data, false);
}

?>
<!-- INICIO MASCARAS -->

<div class="mask" id="mask_cad_aluno" style="display: none">
	<div class="painel_meio">
		<h1>CADASTRO DE USUÁRIOS</h1><hr>
		<form action='professor.php' class="form" method='post'>
            Nome completo:<input type='text'name='usuario[nome_c]' required><br>
            Apelido:<input type='text' name='usuario[nick]' required><br>
            email:<input type='text'name='usuario[user]' required><br>
            Senha:<input type='password'name='usuario[password]' required><br>
            Repetir senha:<input type='password'name='' ><br>
            Contato:<input type='text' name='usuario[contato]' required size="15" maxlength="15" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$" title="Digite o telefone no formato (xx) xxxx-xxxx" placeholder=" (xx) xxxx-xxxx"><br>
            Tipo:
            <select name='usuario[tipo]' required style="width: 182px">
            	<option>aluno</option>
            	<option>professor</option>
            	<option>coordenador</option>
            </select><br>

            Status:
            <select name='usuario[status]' required style="width: 182px">
            	<option value="1">Ativo</option>
            	<option value="0">Inativo</option>
            </select><br>
            <input type="button" id="cancelar" onclick="closeMask('mask_cad_aluno')" value="Cancelar">
            <input type='submit' id="gravar" value='Gravar'><br>
        </form>
	</div>
</div>

<div class="mask" id="mask_cad_turma" style="display: none">
	<div class="painel_meio">
		<h1>CADASTRO DE TURMAS</h1><hr>
		<form action='professor.php' class="form" method='post'>
            Limite de alunos:<input type='number'name='c_turma[lim_alunos]' required value=""><br>
            <input type='hidden' name='c_turma[dt_criacao]' required value="<?php print (date('d/m/Y')); ?>">
            Data de término:<input type='date'name='c_turma[dt_termino]' required value=""><br>
            Disciplina:<input type='text'name='c_turma[disciplina]' required value=""><br>
            Matricula Professor:<input type='text' name='c_turma[id_professor]' required value=""><br>
            Status:
            <select name='c_turma[status]' required style="width: 182px">
            	<option value="1">Ativa</option>
            	<option value="0">Inativa</option>
            </select><br>
            <input type="button" id="cancelar" onclick="closeMask('mask_cad_turma')" value="Cancelar">
            <input type='submit' id="gravar" value='Gravar'><br>
        </form>
	</div>
</div>
<!-- FIM MASCARAS -->

<!-- ################################# INICIO VALIDAÇÃO DE FORMULÁRIOS -->

<?php
// Valida form cadastro de aula
if (isset($_POST['c_turma'])){
    $c_turma = $_POST['c_turma'];
    //var_dump($data);
    $c_turma = DBGrava('turma', $c_turma, false);
}
?>

<!-- ################################# FIM VALIDAÇÃO DE FORMULÁRIOS-->
<header id='logo'>
	<div class="bg"><img src="imagens/logo.png"></div>
	<div class="inf_login">
		Seja bem vindo <?php echo $tipo;?> <?php echo $nick;?> | Matricula:  <?php echo $id_user;?> 
		| Data: <?php print (date('d/m/Y')); ?> |
		alterar senha |
		<a href='index.php' onclick="session_destroy()">Sair</a>
	</div>
</header>

<div class="conteiner">

<article class='painel_esq_desk'>
	<ul>
		<li><a onclick="showMask('mask_cad_aluno');">cadastrar novo usuário</a></li>
		<li><a onclick="showMask('mask_cad_turma');">cadastrar nova turma</a></li>
		<li><a href="turmas.php">turmas x alunos</a></li>
		<li><a href="manuais.html">como usar</a></li>
	</ul>

	<form method="get" class="form" action="turmas.php">
		<input type="text" name="getturma" placeholder=" Pesquisar turma">
		<input type="submit" value="Buscar">
	</form>
</article>



<!-- ################################# ULTIMOS PROFESSORES CADASTRADOS -->



<article class='painel_dir_desk' id="painel_alunos" style="display: block;">
	
	<h1>PROFESSORES CADASTRADOS</h1>
	<a onclick="showMask('mask_cad_aluno');">cadastrar novo </a> |
	<a href="desktop.php?painel=professor">ver todos</a> 
	<hr>
	
	<div class="linha1">
		<div class="campos"><th>MATRICULA</th></div>
		<div class="campos"><th>NOME</th></div>
		<div class="campos"><th>EMAIL</th></div>
		<div class="campos_num"><th>CONTATO</th></div>
		<div class="campos_num"><th>ATIVO</th></div>
	</div><br><br>
		<?php
			$bsc_turmas = DBRead('users', "WHERE tipo='professor' ORDER BY id DESC LIMIT 3");
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


<!-- ################################# ULTIMAS TURMAS CADASTRADAS -->


<article class='painel_dir_desk' id="painel_turmas" style="display: block;">
	
	<h1>ÚLTIMAS TURMAS CADASTRADAS</h1>
	<a onclick="showMask('mask_cad_turma');">cadastrar nova turma </a> |
	<a href="desktop.php?painel=turmas_coord">ver todas</a>
	<hr>
	
	<div class="linha1">
		<div class="campos"><th>TURMA</th></div>
		<div class="campos"><th>DISCIPLINA</th></div>
		<div class="campos_num"><th>LIMITE</th></div>
		<div class="campos_num"><th>CRIAÇÃO</th></div>
		<div class="campos_num"><th>TÉRMINO</th></div>
	</div><br><br>
		<?php 
			$bsc_turmas = DBRead('turma', "ORDER BY id DESC LIMIT 3");
			
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


<!-- ################################# ULTIMOS ALUNOS CADASTRADOS -->


<article class='painel_dir_desk' id="painel_alunos" style="display: block;">
	
	<h1>ALUNOS CADASTRADOS</h1>
	<a onclick="showMask('mask_cad_aluno');">cadastrar novo </a> |
	<a href="desktop.php?painel=alunos">ver todos</a>
	<hr>
	
	<div class="linha1">
		<div class="campos"><th>MATRICULA</th></div>
		<div class="campos"><th>NOME</th></div>
		<div class="campos"><th>EMAIL</th></div>
		<div class="campos_num"><th>CONTATO</th></div>
		<div class="campos_num"><th>ATIVO</th></div>
	</div><br><br>
		<?php
			$bsc_alunos = DBRead('users', "WHERE tipo='aluno' ORDER BY id DESC LIMIT 3");
			if ($bsc_alunos != null){
				foreach ($bsc_alunos as $dt){
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
}//IF Coordenador


######################################### FIM IF COORDENADOR ############################################



####################################### INICIO IF PROFESSOR #############################################


if($tipo == 'professor'){

 ################################# INICIO VALIDAÇÃO FORMULÁRIOS -->

// Valida form cadastro de aula
if (isset($_POST['data'])){
    $data = $_POST['data'];
    //var_dump($data);
    $grava = DBGrava('aulas', $data, false);
}


################################# FIM VALIDAÇÃO FORMULÁRIOS -->
?>

<!-- ################################# INICIO PAINEL MASCARAS -->

<div class="mask" id="mask" style="display: none">
	<div class="painel_meio">
		<h1>CADASTRO DE AULA</h1><hr>
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
		<h1>DISPONIBILIZAR AULAS</h1><hr>
		<form action='professor.php' class='form' method='post'>
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
            <input type="button" id="cancelar" onclick="closeMask('mask_turma')" value="Cancelar">
            <input type='submit' id="gravar" value='Gravar'><br>
        </form>
	</div>
</div>

<!-- ################################# FIM PAINEL MASCARAS -->


<header id='logo'>
	<div class="bg"><img src="imagens/logo.png"></div>
	<div class="inf_login">
		Seja bem vindo <?php echo $tipo;?> <?php echo $nick;?> | Matricula:  <?php echo $id_user;?> 
		| Data: <?php print (date('d/m/Y')); ?> |
		alterar senha |
		<a href='index.php' onclick="session_destroy()">Sair</a>
	</div>
</header>

<div class="conteiner">

<article class='painel_esq_desk'>
	<ul>
		<li><a href='professor.php'>home</a></li>
		<li><a onclick="showMask('mask');">cadastrar nova aula</a></li>
		<li><a href="manuais.html">como usar</a></li>
	</ul>
</article>


<!-- Painel turmas -->
<!--<div>-->

<article class='painel_dir_desk' id="painel_turmas" style="display: block;">
	
	<h1>ÚLTIMAS TURMAS CADASTRADAS</h1>
	<a href="desktop.php?painel=turmas">ver todas</a>
	<hr>
	
		<?php 
			$bsc_turmas = DBRead('turma', "WHERE id_professor='$id_user' ORDER BY id DESC LIMIT 3 "/*, "WHERE id_professor='$id_user'"*/);
					
				if ($bsc_turmas != null){
					foreach ($bsc_turmas as $dt){
						$table         = 'turma';
						$id_turma      = $dt['id'];
						$disc          = $dt['disciplina'];
						$limite        = $dt['lim_alunos'];
						$dt_criacao    = $dt['dt_criacao'];
						$dt_termino    = $dt['dt_termino'];
						print "<div class='linha_turma'>";
						print "<div class='turma'>Turma: ".str_pad($id_turma, 4, 0, STR_PAD_LEFT)."</div>";
						print "<div class='disc'>Disciplina: ".$disc."</div>";
						print "<div class='lim'>Limite: ".$limite."</div>";
						print "<div class='icone_mural'><img src='img/mural.png' width='20' height='20'  alt='icone mural' title='Enviar mensagem no mural da turma'></div>";
						print "<div class='dt_criacao'>Criação: ".$dt_criacao."</div>";
						print "<div class='dt_termino'>Termino: ".$dt_termino."</div>";
						print "</div>";
					}// foreach bsc_turmas
				}// if teste 
				else{
					print('Você não possui turmas cadastradas.');
				}// else
		?>

</article>


<!--Painel aulas cadastradas -->


<article class='painel_dir_desk' id="painel_aulas" style="display: block;">
	
	<h1>ÚLTIMAS AULAS CADASTRADAS</h1>
	<a onclick="showMask('mask');"><img src='img/add.png' width='20' height='20'  alt='icone adicionar aula' title='Cadastrar nova aula'></a> |
	<a href="desktop.php?painel=aulas">ver todas</a>
	<hr>
	
	<?php

		$bsc_aula = DBRead('aulas', "WHERE id_user='$id_user' ORDER BY id DESC LIMIT 3");
			if ($bsc_aula != null){
				foreach ($bsc_aula as $au){
					$cod_aula = $au['id'];
					$titulo   = $au['titulo'];
					$link     = $au['link'];
		$corrige_link = str_replace('watch?v=',  'embed/', $link );
					
					print "<div class='linha_aula'>";
					print "<div class='link_prof'><iframe width='180' height='101.25' src='".$corrige_link."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
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
	<p>&nbsp</p>
</article> 


<!--</div>-->

<?php
}//Chave IF professor
?>

<!--#################################### FIM IF PROFESSOR #############################################-->

</div><!-- ###### FIM DIV CONTEINER-->
<script type="text/javascript" src="funcoes.js"></script>
<!--
<footer>
	<p>Plataforma desenvolvida por: Carlos LP Souza | Pedro Gastoldi | Roberto Neto</p>
</footer>
-->
</body>
</html>
