<?php require('../partials/header.php'); protect();
$model = 'quotation';
$rows = select($model); ?>
<h2><?php echo ucfirst($model) . 's'; ?></h2>
<?php require('../partials/list.php'); ?>
<a class="btn btn-primary" href="add.php">Create a new <?php echo $model; ?></a>
<?php require('../partials/footer.php');