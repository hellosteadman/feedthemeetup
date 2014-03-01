<?php require('../partials/header.php'); protect();
$model = 'quotation';
if(isset($_GET['id'])) {
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		run_query("DELETE FROM $model WHERE id = " . $_GET['id']);
		header('Location: ./?message=deleted&model=' . $model);
		close_database();
		end();
	}
} ?>

<h2>Delete <?php echo $model; ?></h2>
<p>Are you sure you want to delete this <?php echo $model; ?>?</p>
<form method="post">
	<a class="btn btn-default" href=".">No, go back</a>
	<button class="btn btn-danger" type="submit">Yes</button>
</form>