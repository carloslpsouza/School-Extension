<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/estilospca.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<title> </title>
</head>
<body>
	<header id="logo">
		<div class="bg"><img src="imagens/logo.png" alt="Logo School Extension"></div>
	</header>
	<div class="acessibilidade" onmouseover="showAccess('access', 'access1')" onmouseout="closeAccess('access', 'access1')">
		<img src='img/access.png' alt="Ferramenta de acessibilidade"><br><br>
		PRECISA DE AJUDA?
	</div>
	<div id="access" class="visao" style="display: none;">
		<img src='img/visao.png' alt="Selecione se tem dificuldades de visão">
	</div>
	<div id="access1" class="audicao" style="display: none;">
		<img src='img/audicao.png' alt="Selecione se tem dificuldades de audição">
	</div>
	<br>
	<br>

	<div id="menu">
		<a href="">HOME</a> |
		<a href="apresentacao.html">BIOGRAFIA</a> |
		<a href="contato.html">CADASTRO</a>
	</div>


<section class="content">
	<div class="login">
		<h2 class="dourado">Login</h2>

	<form class="formulario" action="valida.php" method="POST">

		<input class="field" type="text" id='user' name='user' name="e-mail" placeholder="E-mail:">
		<input class="field" type="password" id='senha' name='sw' name="senha" placeholder="Senha:">
		<input class="field" type="submit" value="Enviar">

	</form>

	
		
	</div>
	</section>
	<script type="text/javascript" src="funcoes.js"></script>

</body>
</html>
