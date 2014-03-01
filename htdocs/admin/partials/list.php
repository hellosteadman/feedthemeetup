<table class="table striped">
	<?php foreach($rows as $i => $row) {
		if($i == 0) { ?>
			<tr>
				<?php foreach(array_keys($row) as $column) {
					if($column != 'password') { ?>
						<th><?php echo $column; ?></th>
					<?php }
				} ?>
				
				<th width="30">Edit</th>
				<th width="30">Delete</th>
			</tr>
		<?php } ?>
		
		<tr>
			<?php foreach($row as $column => $value) {
				if($column != 'password') { ?>
					<td><?php echo htmlentities($value); ?></td>
				<?php }
			} ?>
			<td>
				<a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
			</td>
			<td>
				<a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>