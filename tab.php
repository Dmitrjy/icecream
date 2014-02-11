<?php

/**
 * Facebook tab page
 *
 * @author: jabran@untied-agency.co.uk
 * @version: 3.7
 * @package: United Megacomp Template
 *
 */

require('config.php');
$tweet = urlencode("Win a holiday every week at: https://apps.facebook.com/tribeweeklywin #tribethursdays #ibiza2014");

?>
<!doctype html>
<html xmlns:fb="http://ogp.me/ns/fb#"> 
<head prefix="og:http://ogp.me/ns# fb:http://ogp.me/ns/fb# <?php echo $app_namespace; ?>:http://ogp.me/ns/fb/<?php echo $app_namespace; ?>"> 
    <title><?php echo $app_title; ?></title> 
    <meta charset="utf-8"> 
    <meta property="fb:app_id" content="<?php echo $facebook_app_id; ?>"> 
    <meta property="og:title" content="<?php echo $app_title; ?>"> 
    <meta property="og:type" content="website"> 
    <meta property="og:url" content="<?php echo $app_url; ?>"> 
    <meta property="og:image" content="<?php echo $app_thumbnail; ?>">
    <meta property="og:description" content="<?php echo $app_description; ?>">

	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="<?php echo $twitter_handler; ?>">
	<meta name="twitter:title" content="<?php echo $app_url; ?>">
	<meta name="twitter:description" content="<?php echo $app_description; ?>">
	<meta name="twitter:url" content="<?php echo $app_url; ?>">
	<meta name="twitter:image" content="<?php echo $app_thumbnail; ?>">
	<link href="css/reset.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<?php load_javascript(); // Load all required JavaScript files ?>
	<script>
		facebook.init({
			appid: '<?php echo $facebook_app_id; ?>',
			channelurl: '<?php echo UAS; ?>channel.php',
			autogrow: true,
			x: 0,
			y: 1
		});

		$(document).ready(function()	{ 
			$(".enter-twit").on("click", function(e) {
				window.open('thank_you.php', '_self'); 
				window.open("https://twitter.com/intent/tweet?text=<?php print urlencode('I want to win a holiday with @tribeIbiza because… '); echo $tweet; ?>", "_blank");
			})

			$('.enter-fb').on("click", function(e) {

						//FB Permission functionality
						function doLogin(user_id, first_name, last_name, email) {
								data_input = {  user_id: user_id, first_name: first_name, last_name: last_name, email: email };
								
								$.post("processlogin.php", data_input).done( function(data, status) {
									
									if (status == "success") {
										
										 window.open('register.php', '_self'); 
									}
									else {
									}
								});
						}

					
						FB.getLoginStatus(function(response) {
							if (response && response.status === "connected") {
								FB.api('/me', function(info){
									
									if (info && info.id)
										
										return doLogin(info.id, info.first_name, info.last_name, info.email);
								});
							}
							else {
								FB.login(function(info)	{
									FB.api('/me', function(info){
										
										if (info && info.id)
											
											return doLogin(info.id,  info.first_name, info.last_name, info.email);
									});
								},{scope: 'email'});
							}
						});
						e.preventDefault();
					});
		});
	</script>
</head>
<body>

	<div id="wrapper">

		<?php if ( !page_liked() && !isset($_GET["return"]) ) : ?>

			<div id="pre_like"></div>
			<a class="www-tribe" href="http://tribeibiza.com" target="_blank" title="TribeIbiza"></a>

		<?php else : ?>

		<?php if ( !ENV_PROD && isset($error) ) echo '<script>console.log("' . $error . '");</script>'; ?>

			<a class="enter-fb" href="register.php" title="Enter on Facebook"></a>
			<a class="enter-insta" href="follow.php?noaction=1" title="Enter on Instagram"></a>
			<a class="enter-twit" title="Enter on Twitter"></a>

	        <a class="www-tribe" href="http://tribeibiza.com" target="_blank" title="TribeIbiza"></a>
	        <a href="<?php echo $termsconditions; ?>" title="Terms &amp; Conditions" target="_blank" class="bttn tc">Terms &amp; Conditions</a>
	        <a href="<?php echo $privacypolicy; ?>" title="Privacy Policy" target="_blank" class="bttn privacy">Privacy Policy</a>
	         
	        <a class="tribe-advert" href="http://www.tribeibiza.com/" target="blank"></a>
			<div id="post_like"></div>

		<?php endif; ?>
	</div>
</body>
</html>