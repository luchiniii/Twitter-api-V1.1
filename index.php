<?php
	session_start();
	include_once("twitteroauth-master/twitteroauth/twitteroauth.php");

	$twitteruser = "twitteruser";
	$notweets = 30;
	$consumerkey = "consumerkey";
	$consumersecret = "consumersecret";
	$accesstoken = "accesstoken";
	$accesstokensecret = "accesstokensecret";

	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}

	$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

	$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
		<!-- jQuery library (served from Google) -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<!-- bxSlider Javascript file -->
		<script src="js/jquery.bxslider.min.js"></script>
		<!-- bxSlider CSS file -->
		<link href="css/jquery.bxslider.css" rel="stylesheet" />
	</head>

	<body>
		<ul class="bxslider">
			<?php
				foreach ($tweets as $key => $tweet) {
					echo '<li>';
					echo $tweet->text;
					echo '</li>';
				}
			?>
		</ul>
		<script type="text/javascript">
			hashtag_regexp = /#([a-ñ-zA-Ñ-Z0-9_óáéíóúÓÁÉÍÓÚ]+)/g;
			user_regexp    = /@([a-zA-Z0-9_]+)/g;
			url_regexp     = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
			function linkHashtags(text) {
				return text.replace(
					hashtag_regexp,
					'<a class="hashtag" href="http://twitter.com/search?q=%23$1">#$1</a>'
				);
			}
			function userHashtags(text) {
				return text.replace(
					user_regexp,
					'<a class="user-twitter" href="http://twitter.com/search?q=%40$1">@$1</a>'
				);
			}
			function urlHashtags(text) {
				return text.replace(
					url_regexp,
					'<a class="twitt-link" href="$1">$1</a>'
				);
			}
			jQuery(document).ready(function($) {
				$('.bxslider li').each(function() {
					$(this).html(urlHashtags($(this).html()));
					$(this).html(linkHashtags($(this).html()));
					$(this).html(userHashtags($(this).html()));
				});

				$('.bxslider').bxSlider({
					adaptiveHeight : true,
					auto: true,
					mode: 'fade',
					pager: false,
					controls: false
				});
			});
		</script>
	</body>
</html>
