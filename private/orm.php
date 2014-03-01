<?php global $sql, $dbFilename;

$dbFilename = dirname(__file__) . '/db.sqlite';
function open_database() {
	global $sql, $dbFilename;
	
	$sql = new SQLite3($dbFilename);
	return $sql;
}

function migrate_database() {
	global $dbFilename;
	$from = isset($_GET['from']) ? intVal($_GET['from']) : 0;
	
	if(!$from && is_file('db.sqlite')) {
		unlink('db.sqlite');
	}
	
	$sql = new SQLite3($dbFilename, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
	foreach(glob(dirname(__file__) . '/schema/*.sql') as $index => $migration) {
		if($index < $from) {
			continue;
		}
		
		$query = file_get_contents($migration);
		print('<pre>' . $query . '</pre>');
		$sql->query($query);
	}
	
	foreach(glob(dirname(__file__) . '/data/*.json') as $data) {
		$table = substr(basename($data), 0, strlen(basename($data)) - 5);
		$json = json_decode(file_get_contents($data), true);
		
		foreach($json as $row) {
			$statement = "INSERT INTO ${table} (" . implode(', ', array_keys($row)) . ') VALUES (';
			foreach(array_keys($row) as $key) {
				$statement .= ':' . $key . ', ';
			}
			
			if(substr($statement, strlen($statement) - 2) == ', ') {
				$statement = substr($statement, 0, strlen($statement) - 2);
			}
			
			$statement .= ')';
			$query = $sql->prepare($statement);
			
			foreach($row as $key => $value) {
				$query->bindValue(':' . $key, $value);
			}
			
			$query->execute();
		}
	}
}

function sqlite_query($statement, $params = array()) {
	global $sql;
	
	$query = $sql->prepare($statement);
	foreach($params as $key => $value) {
		$query->bindValue(':' . $key, $value);
	}
	
	$query = $query->execute();
	$results = array();
	
	while($result = $query->fetchArray(SQLITE3_ASSOC)) {
		$results[] = $result;
	}
	
	return $results;
}

function select($table, $params = array()) {
	$statement = "SELECT * FROM $table";
	if(count($params) > 0) {
		$statement .= ' WHERE ';
		$pairs = array();
		
		foreach(array_keys($params) as $key) {
			$pairs[] = "${key} = :${key}";
		}
		
		$statement .= implode(' AND ', $pairs);
	}
	
	return sqlite_query($statement, $params);
}

function run_query($statement, $params) {
	global $sql;
	$query = $sql->prepare($statement);
	
	foreach($params as $key => $value) {
		$query->bindValue(':' . $key, $value);
	}
	
	$query->execute();
}

function get_last_inserted_id() {
	global $sql;
	return $sql->lastInsertRowID();
}

function get_columns($table) {
	$columsn = array();
	foreach(sqlite_query("PRAGMA table_info($table);") as $column) {
		$columns[] = $column['name'];
	}
	
	return $columns;
}

function close_database() {
	global $sql;
	
	if($sql) {
		$sql->close();
		$sql = null;
	}
}