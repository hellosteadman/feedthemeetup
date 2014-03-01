<?php require('../../../private/forms.php'); ?>
<div class="form-horizontal">
	<?php foreach(get_columns($model) as $column) {
		if($column != 'id') {
			$errors = get_field_errors($model, $column); ?>
			<div class="form-group<?php if(count($errors) > 0) { echo ' has-error'; } ?>">
				<label for="id_<?php echo $column; ?>" class="col-sm-2 control-label"><?php echo get_label_text($column); ?></label>
				<div class="col-sm-10">
					<?php render_column($model, $column); ?>
				</div>
			</div>
		<?php }
	} ?>
</div>