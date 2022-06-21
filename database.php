<?php
function DBDelete($table, $where = null){
	//$table  = DB_PREFIX."_".$table;
	$where = ($where) ? " WHERE {$where}" : null;
	$query = "DELETE FROM {$table}{$where}";
	return DBExecute($query);
}


function DBUpdate($table, array $data, $where = null, $insertID = false){//o ultimo parametro retorna LAST_INSERT_ID
	foreach ($data as $key => $value) {
		$fields[] = "{$key} = '{$value}'";
	}
	$fields = implode(', ', $fields);
	
	$table  = DB_PREFIX."_".$table;
	$where = ($where) ? " WHERE {$where}" : null;
	$query = "UPDATE {$table} SET {$fields}{$where}";
	return DBExecute($query, $insertID);
}


function DBRead($table, $params = null, $fields = '*'){
	//$table  = DB_PREFIX."_".$table;
	$params = ($params) ? " {$params}": null;
	$query  = "SELECT {$fields} FROM {$table}{$params}";
	$result = DBExecute($query);
	if(!mysqli_num_rows($result))
		return false;
	else {
		while ($res = mysqli_fetch_assoc($result)) {// transforma o resultado vindo de Result em um array
			$data [] = $res;//monta a variavel data como array vinda do fetch_assoc
		};

		return $data;
	}
}


function DBGrava($table, array $data, $insertID = false){//o ultimo parametro retorna LAST_INSERT_ID
	$data   = DBEscape($data); 
	$fields = implode(',', array_keys($data));
	$values = "'".implode("', '", array_values($data))."'";

	$query = "INSERT INTO {$table} ($fields) VALUES ($values)";

	return DBExecute($query, $insertID);
}

function DBExecute($query, $insertID = false){//o ultimo parametro retorna LAST_INSERT_ID
	$link   = DBConnect();
	$result = @mysqli_query($link, $query) or die(mysqli_error($link));
	if($insertID)// Se o parametro foi passado na consulta, o resultado vai ser retornado
		$result = mysqli_insert_id($link);
	DBClose($link);
	return $result;
}

?>
