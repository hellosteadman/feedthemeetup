<?php require('../partials/header.php'); protect();
$model = 'eventtype'; ?>
<h2>Add <?php echo str_replace('_', ' ', $model); ?></h2>

<Form method="post">
	<?php require('../partials/form.php'); ?>
	<div class="col-sm-10 col-sm-offset-2">
		<button class="btn btn-primary" type="save">Save</button>
	</div>
</form>

<?php require('../partials/footer.php');