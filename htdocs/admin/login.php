<?php require('partials/header.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(login()) {
		if(isset($_GET['next'])) {
			header('Location: ' . $_GET['next']);
			close_database();
			end();
		}
		
		header('Location: ./');
		close_database();
		end();
	} else { ?>
		<div class="alert alert-danger">Please make sure you have the correct username and password</div>
	<?php }
} ?>
<h2>Login</h2>

<Form method="post">
	<div class="form-horizontal">
		<div class="form-group">
			<label for="id_username" class="col-sm-2 control-label">Username</label>
			<div class="col-sm-10">
				<input id="id_username" name="username" type="text" class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label for="id_password" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
				<input id="id_password" name="password" type="password" class="form-control" />
			</div>
		</div>
		
		<div class="col-sm-10 col-sm-offset-2">
			<button class="btn btn-primary" type="submit">Login</button>
		</div>
	</div>
</form>

<?php require('partials/footer.php');