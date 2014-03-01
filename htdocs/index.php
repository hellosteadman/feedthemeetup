<?php require('../private/orm.php'); open_database();

$total = -1;
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$post = isset($_POST['quotation']) ? $_POST['quotation'] : null;
	$valid = true;
	
	if($post) {
		foreach(sqlite_query("PRAGMA table_info(quotation);") as $column) {
			$value = isset($post[$column['name']]) ? $post[$column['name']] : null;
			if($column['pk']) {
				continue;
			}
			
			if(!$column['notnull']) {
				if(!$value) {
					$valid = false;
					$form_errors['quotation'][$column['name']] = array('This field is required.');
				}
			}
			
			$post[$column['name']] = $value;
		}
		
		if($valid) {
			$statement = "INSERT INTO quotation (" . implode(', ', array_keys($post)) . ") VALUES (";
			foreach(array_keys($post) as $column) {
				$statement .= ':' . $column . ', ';
			}
			
			if(substr($statement, strlen($statement) - 2) == ', ') {
				$statement = substr($statement, 0, strlen($statement) - 2);
			}
			
			$statement .= ')';
			// run_query($statement, $post);
			
			$meals = 0;
			$total = floatVal(0);

			foreach(select('mealprice') as $price) {
				if(isset($_POST[strtolower($price['name'])])) {
					$meals ++;
					$total += floatVal($price['price']);
				}
			}

			$total *= (intVal($post['covers']) * intVal($post['days']));
		}
	}
} else {
	$data = array();
} ?><html>
	<head>
		<title>Feed Your Event</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript" src="//use.typekit.net/utk6jnr.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	</head>
	<body>
		<header class="top-header">
			<div class="layout-width">
				<a href="http://www.changekitchen.co.uk/" class="ck-logo"><img src="images/logo.png" alt="Change Kitchen logo" /></a>
				<div class="slogan">
					<p class="slogan-type">Award-winning event catering</p>
					<p class="main-site-link"><a href="http://www.changekitchen.co.uk/">More information at changekitchen.co.uk</a>
				</div>
			</div>
		</header>
		
		<?php if($_SERVER['REQUEST_METHOD'] != 'POST' || $total == -1) { ?>
			<header class="intro center-text">
				<div class="layout-width">
					<h1 class="headline">Feed your event</h1>
					<p class="intro-desc no-spacing">With nutritious and ethical dishes that do good for society.</p>
				</div>
			</header>
			<div class="feature feature-one">
				<div class="layout-width">
					<h2>Info about events</h2>
					<p class="no-spacing">Lorem ipsum sit dolor.</p>
				</div>
			</div>
			<div class="feature feature-two">
				<div class="layout-width">
					<h2>Info about food</h2>
					<p class="no-spacing">Lorem ipsum sit dolor</p>
				</div>
			</div>
			<div class="feature feature-three">
				<div class="layout-width">
					<h2>We do good</h2>
					<p class="no-spacing">Lorem ipsum sit dolor.</p>
				</div>
			</div>
			<section class="form-area">
				<div class="layout-width">
					<h1 class="center-text">Your event details</h1>
					<p class="center-text">Let us know about your event. We'll give you an estimate, and get in touch a little later.</p>
					<form class="enquiry-form" method="post">
						<label for="event-your-name">Your name</label>
						<input type="text" id="event-your-name" name="quotation[name]" value="<?php if(isset($post['name'])) { echo htmlentities($post['name']); } ?>" />
				
						<label for="event-email">Your email address</label>
						<input type="email" id="event-email" name="quotation[email]" value="<?php if(isset($post['email'])) { echo htmlentities($post['email']); } ?>" />
				
						<label for="event-date">The start</label>
						<input type="date" id="event-date" name="quotation[start]" value="<?php if(isset($post['start'])) { echo htmlentities($post['start']); } ?>" />
				
						<label for="event-days">How many days?</label>
						<input type="number" id="event-days" name="quotation[days]" value="<?php if(isset($post['days'])) { echo htmlentities($post['days']); } ?>" />
				
						<label for="number">Estimate of number of people</label>
						<input type="number" id="number" name="quotation[covers]" value="<?php if(isset($post['covers'])) { echo htmlentities($post['covers']); } ?>" />
				
						<p>What meals would you like?</p>
				
						<?php foreach(select('mealprice') as $price) { ?>
							<p class="checkbox-wrap">
								<input type="checkbox" id="event-meals-<?php echo strtolower($price['name']); ?>" class="checkbox-with-label" name="<?php echo strtolower($price['name']); ?>" value="1" <?php if(isset($_POST[strtolower($price['name'])])) { echo 'checked'; } ?> /><label for="event-meals-<?php echo strtolower($price['name']); ?>" class="label-with-checkbox"><?php echo $price['name']; ?></label>
							</p>
						<?php } ?>
				
						<label for="location">Location</label>
						<input type="text" id="location" placeholder="Postcode, town, or city" name="quotation[location]" value="<?php if(isset($post['location'])) { echo htmlentities($post['location']); } ?>" />
				
						<label for="event-type">Type of event</label>
						<select id="event-type" name="quotation[eventtype_id]">
							<?php foreach(select('eventtype') as $type) { ?>
								<option value="<?php echo $type['id']; ?>"<?php if(isset($post['eventtype_id'])) {
									if(intVal($post['eventtype_id']) == intVal($type['id'])) {
										echo ' selected';
									}
								} ?>>
									<?php echo htmlentities($type['name']); ?>
								</option>
							<?php } ?>
						</select>
				
						<p class="checkbox-wrap">
							<input type="checkbox" id="event-canopes" class="checkbox-with-label" name="quotation[require_canopes]" value="1" <?php if(isset($post['require_canopes'])) { echo 'checked'; } ?> /><label for="event-canopes" class="label-with-checkbox">Do you want canopes?</label>
						</p>
				
						<p class="checkbox-wrap">
							<input type="checkbox" id="event-drinks" class="checkbox-with-label" name="quotation[require_drinks]" name="quotation[require_drinks]" value="1" <?php if(isset($post['require_drinks'])) { echo 'checked'; } ?> /><label for="event-drinks" class="label-with-checkbox">Are drinks required?</label>
						</p>
				
						<p class="checkbox-wrap">
							<input type="checkbox" id="event-cutlery" name="quotation[require_cutlery]" value="1" <?php if(isset($post['require_cutlery'])) { echo 'checked'; } ?> class="checkbox-with-label" /><label for="event-cutlery" class="label-with-checkbox">Is cutlery required?</label>
						</p>
				
						<label for="event-additional-details">Any additional details?</label>
						<textarea id="event-additional-details" name="quotation[notes]" placeholder="Tell us about any further details you think are important..."><?php if(isset($post['notes'])) { echo htmlentities($post['notes']); } ?></textarea>
				
						<button type="submit">Send</button>
					</form>
				</div>
			</section>
			<footer class="page-footer">
				<div class="layout-width">
					
				</div>
			</footer>
		<?php } else { ?>
			<header class="intro center-text">
				<div class="layout-width">
					<h1>
						<small>Your guide price is</small><br />
						&pound;<?php echo number_format($total, 0); ?>
					</h1>
				</div>
			</header>
		<?php } ?>
	</body>
</html><?php close_database();