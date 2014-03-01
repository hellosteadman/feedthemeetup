<?php require('../private/orm.php'); open_database();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$covers * $days * $meals;
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
				<form class="enquiry-form">
					<label for="event-your-name">Your name</label>
					<input type="email" id="event-your-name" name="quotation[name]" />
					
					<label for="event-email">Your email address</label>
					<input type="email" id="event-email" name="quotation[email]" />
					
					<label for="event-date">The start</label>
					<input type="date" id="event-date" name="quotation[start]" />
					
					<label for="event-days">How many days?</label>
					<input type="number" id="event-days" name="quotation[days]" />
					
					<label for="number">Estimate of number of people</label>
					<input type="number" id="number" name="quotation[covers]" />
					
					<label>What meals would you like?</label>
					
					<p class="checkbox-wrap" name="breakfast" value="1">
						<input type="checkbox" id="event-meals-breakfast" class="checkbox-with-label" /><label for="event-meals-breakfast" class="label-with-checkbox">Breakfast</label>
					</p>
					
					<p class="checkbox-wrap" name="lunch" value="1">
						<input type="checkbox" id="event-meals-lunch" class="checkbox-with-label" /><label for="event-meals-lunch" class="label-with-checkbox">Lunch</label>
					</p>
					
					<p class="checkbox-wrap" name="evening" value="1">
						<input type="checkbox" id="event-meals-evening" class="checkbox-with-label" /><label for="event-meals-evening" class="label-with-checkbox">Evening meal</label>
					</p>
					
					<label for="location">Location</label>
					<input type="text" id="location" placeholder="Postcode, town, or city" name="quotation[location]" />
					
					<label for="event-type">Type of event</label>
					<select id="event-type" name="quotation[eventtype_id]">
						<?php foreach(select('eventtype') as $type) { ?>
							<option value="<?php echo $type['id']; ?>"><?php echo htmlentities($type['name']); ?></option>
						<?php } ?>
					</select>
					
					<p class="checkbox-wrap" name="quotation[require_canopes]" value="1">
						<input type="checkbox" id="event-canopes" class="checkbox-with-label" /><label for="event-canopes" class="label-with-checkbox">Do you want canopes?</label>
					</p>
					
					<p class="checkbox-wrap" name="quotation[require_drinks]" value="1">
						<input type="checkbox" id="event-drinks" class="checkbox-with-label" /><label for="event-drinks" class="label-with-checkbox">Are drinks required?</label>
					</p>
					
					<p class="checkbox-wrap" name="quotation[require_cutlery]" value="1">
						<input type="checkbox" id="event-cutlery" class="checkbox-with-label" /><label for="event-cutlery" class="label-with-checkbox">Is cutlery required?</label>
					</p>
					
					<label for="event-additional-details" name="quotation[notes]" value="1">Any additional details?</label>
					<textarea id="event-additional-details" placeholder="Tell us about any further details you think are important..."></textarea>
				</form>
			</div>
		</section>
		<footer class="page-footer">
			<div class="layout-width">

			</div>
		</footer>
	</body>
</html><?php close_database();