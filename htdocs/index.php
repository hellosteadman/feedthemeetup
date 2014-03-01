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
					<h1 class="headline animated bounceInLeft">Feed your event</h1>
					<p class="intro-desc animated bounceInLeft no-spacing">Looking for a caterer but no idea what you need? Then you've come to the right place. Find out more about the unique opportunity you have to feed your event, while helping help the less privileged. Then use our handy calculator to get costs, hints and tips on how to cater for your event.</p>
				</div>
			</header>
			<div class="feature feature-one">
				<div class="layout-width">
					<div class="feature-text">
						<h2>Food Glorious Food</h2>
						<p>We offer a range of innovative, award winning food carefully put together using the finest local, organic and seasonal ingredients.</p>
						<p class="no-spacing">Our menus cater for all events, from small meetups to large conferences, to weddings and corporate lunches. We shape our menus around the seasonal produce available at the time of the event, so there'll be roasted squash risottos in the autumn and crisp Evesham asparagus spears in spring. Fresh, local, seasonal and delicious.</p>
					</div>
					<div class="feature-image">
						<img src="images/feature-one-image.png" />
					</div>
				</div>
			</div>
			<div class="feature feature-two">
				<div class="layout-width">
					<div class="feature-text right">
						<h2>Trust me I'm a Caterer</h2>
						<p>From "grab bags to go" and "help your self platters" through to "knife &amp; fork round-table" lunches, we corporate catering can offer the perfect solution for your corporate event.</p>
						<p>Our talented and knowledgeable team are on hand to help with planning and organising the catering for your event so you can concentrate on other points safe in the knowledge your guests will be well fed.</p>
						<p class="no-spacing">Our service is available nationally, whether you're looking to cater a single service "ready to serve" lunch event, all day conference or a full week's pop up kitchen for a corporate getaway.</p>
					</div>
					<div class="feature-image left">
						<img src="images/feature-two-image.png" />
					</div>
				</div>
			</div>
			<div class="feature feature-three">
				<div class="layout-width">
					<div class="feature-text">
						<h2>By the people for the people!</h2>
						<p>ChangeKitchen's mission is to be part of a revolution that turns access to healthy eating away from a privilege to a right for everyone.</p>
						<p>We're a social enterprise, proud to be cooking up change for disadvantaged people in  Birmingham, as well as delicious food.</p>
						<p class="no-spacing">The single biggest difference between ChangeKitchen and other event caterers is that we create and serve our food differently; we want our clients and customers to celebrate sharing a meal, as well as fuelling their bodies.</p>
					</div>
					<div class="feature-image">
						<img src="images/feature-three-image.png" />
					</div>
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
					<p class="no-spacing">Follow us on <a href="https://twitter.com/changekitchen" class="twitter">Twitter</a> and <a href="https://www.facebook.com/ChangeKitchen" class="facebook">Facebook</a>.</p>
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