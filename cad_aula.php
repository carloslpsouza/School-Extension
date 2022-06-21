<!DOCTYPE html>
    <head>
        <link href="css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class='painel_dir_desk'>
            <form action='desktop.php' method='post'>
                Titulo:<input type='text'name='data[titulo]'><br>
                Resumo:<input type='text' name='data[resumo]'><br>
                Questão:<input type='text'name='data[pergunta]'><br>
                Resposta:<input type='text'name='data[resposta]' placeholder='Resposta não aparece para o aluno'><br>
                Link:<input type='text' name='data[link]'><br>
                id_user:<input type='text' name='data[id_user]'><br>
                id_turma:<input type='text' name='data[id_turma]'><br>
                <input type='submit'><br>
            </form>
        </div>
    </body>
</html>
