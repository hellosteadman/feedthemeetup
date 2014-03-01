<?php global $form_inputs, $form_errors;

$form_inputs = array();
$form_errors = array();

function get_form_def($model) {
	global $form_inputs;
	if(!in_array($model, $form_inputs)) {
		$form_def = dirname(__file__) . '/forms/' . $model . '.json';
		if(is_file($form_def)) {
			$form_inputs[$model] = json_decode(file_get_contents($form_def), true);
		} else {
			$form_inputs[$model] = array();
		}
	}
	
	return $form_inputs[$model];
}

function get_column_def($model, $column) {
	$def = get_form_def($model);
	return isset($def[$column]) ? $def[$column] : array();
}

function render_column($model, $column) {
	$def = get_column_def($model, $column);
	$value = '';
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($model)) {
			$post = isset($_POST[$model]) ? $_POST[$model] : null;
			
			if($post) {
				if(isset($post[$column])) {
					$value = $post[$column];
				}
			}
		}
	} else {
		global $object;
		$value = isset($object[$column]) ? $object[$column] : '';
	}
	
	switch(isset($def['type']) ? $def['type'] : null) {
		case 'text': case 'number': case 'password': case 'email': case null:
			print '<input id="id_' . $column . '" name="' . $model . '[' . $column . ']" class="form-control" ' .
				'type="' . (isset($def['type']) ? $def['type'] : 'text') . '" value="' . htmlentities($value) . '" />';
			
			break;
	}
}

function get_label_text($label) {
	$label = ucfirst(str_replace('_', ' ', $label));
	
	if($label == 'Id') {
		$label = 'ID';
	}
	
	return $label;
}

function get_field_errors($model, $column) {
	global $form_errors;
	
	if(isset($form_errors[$model])) {
		if(isset($form_errors[$model][$column])) {
			return $form_errors[$model][$column];
		}
	}
	
	return array();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(isset($model)) {
		$data = array();
		$post = isset($_POST[$model]) ? $_POST[$model] : null;
		$valid = true;
		$new = true;
		$idcol = '';
		$id = 0;
		
		if($post) {
			foreach(sqlite_query("PRAGMA table_info($model);") as $column) {
				if($column['pk']) {
					$idcol = $column['name'];
					if($value = isset($post[$column['name']]) ? $post[$column['name']] : null) {
						$new = false;
					} else {
						$id = $value;
					}
				} else {
					$value = isset($post[$column['name']]) ? $post[$column['name']] : null;
					
					if(!$column['notnull']) {
						if(!$value) {
							$valid = false;
							$form_errors[$model][$column['name']] = array('This field is required.');
						}
					}
					
					$post[$column['name']] = $value;
				}
			}
			
			if($valid) {
				if($new) {
					$statement = "INSERT INTO ${model} (" . implode(', ', array_keys($post)) . ") VALUES (";
					foreach(array_keys($post) as $column) {
						$statement .= ':' . $column . ', ';
					}
					
					if(substr($statement, strlen($statement) - 2) == ', ') {
						$statement = substr($statement, 0, strlen($statement) - 2);
					}
					
					$statement .= ')';
				} else {
					$statement = "UPDATE ${model} SET ";
					foreach(array_keys($post) as $column) {
						$statement .= "${column} = :${column}, ";
					}
					
					if(substr($statement, strlen($statement) - 2) == ', ') {
						$statement = substr($statement, 0, strlen($statement) - 2);
					}
					
					$statement .= " WHERE ${idcol} = :${idcol}";
				}
				
				run_query($statement, $post);
				header('Location: edit.php?id=' . get_last_inserted_id() . '&message=inserted&model=user');
				close_database();
				die();
			}
		}
	}
}