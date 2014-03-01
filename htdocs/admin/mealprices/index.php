<?php require('../partials/header.php'); protect();
$model = 'mealprice';
$rows = select($model); ?>
<h2><?php echo ucfirst(str_replace('_', ' ', $model)) . 's'; ?></h2>
<?php require('../partials/list.php'); ?>
<a class="btn btn-primary" href="add.php">Create a new <?php echo str_replace('_', ' ', $model); ?></a>
<?php require('../partials/footer.php');