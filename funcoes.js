function Delete(table, id){
	var apagar = confirm('Você deseja excluir este registro? '+id);
    if (apagar){
        location.href = 'delete.php?id='+id+'&table='+table;
        }else{
        alert('Ufa, quase deletou o registro errado.');
        }    
		/*document.getElementById("confirmacao").style.display="block";
    	alert("Tem certeza que gostaria de deletar o registro "+id+" ?");*/
}

function Deldisp(table, id, cod_aula){
    var apagar = confirm('Você deseja remover está turma da seleção? ');
    if (apagar){
        location.href = 'delete.php?id='+id+'&table='+table+'&cod_aula='+cod_aula;
        }else{
        alert('Ufa, quase deletou o registro errado.');
        }    
        /*document.getElementById("confirmacao").style.display="block";
        alert("Tem certeza que gostaria de deletar o registro "+id+" ?");*/
}

function Delalturma(table, id, turma){
    var apagar = confirm('Você deseja remover está o aluno '+id+' da turma '+turma+'? ');
    if (apagar){
        location.href = 'delete.php?id='+id+'&table='+table+'&cod_aula='+turma;
        }else{
        alert('Ufa, quase deletou o registro errado.');
        }    
        /*document.getElementById("confirmacao").style.display="block";
        alert("Tem certeza que gostaria de deletar o registro "+id+" ?");*/
}


function abreJanela_aula(pagina){
    window.open("aula.php?id="+pagina, "_blank", " top=0, left=0, width=1280,height=600");
}

function abreJanela_insere(pagina){
    window.open("insere.php", "_blank", " top=0, left=0, width=auto,height=auto");
}


function showMask(qual){
    document.getElementById(qual).style.display="block";
}

function closeMask(qual){
    document.getElementById(qual).style.display="none";
}

function showAccess(qual, qual1){
    document.getElementById(qual).style.display="block";
    document.getElementById(qual1).style.display="block";
}

function closeAccess(qual, qual1){
    document.getElementById(qual).style.display="none";
    document.getElementById(qual1).style.display="none";
}
/*
function showdispaula(){
    document.getElementById('cad_aula').style.display="none";
    document.getElementById('disp_aulas').style.display="block";
    document.getElementById('painel_aulas').style.display="none";
}

function showaulas(){
    document.getElementById('cad_aula').style.display="none";
    document.getElementById('disp_aulas').style.display="none";
    document.getElementById('painel_aulas').style.display="block";
}

function showcadalunos(){
    document.getElementById('mask_cad_aluno').style.display="block";
}

function closecadalunos(){
    document.getElementById('mask_cad_aluno').style.display="none";
}

function showcadturmas(){
    document.getElementById('mask_cad_turmas').style.display="block";
}

function closecadturmas(){
    document.getElementById('mask_cad_turmas').style.display="none";
}

function showturmas(){
    document.getElementById('painel_turmas').style.display="block";
    document.getElementById('painel_alunos').style.display="none";
}

function showalunos(){
    document.getElementById('painel_turmas').style.display="none";
    document.getElementById('painel_alunos').style.display="block";
}
*/
