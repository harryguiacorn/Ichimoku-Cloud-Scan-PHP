<!doctype html>

<html lang="en">
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/pure-min.css" integrity="sha384-UQiGfs9ICog+LwheBSRCt1o5cbyKIHbwjWscjemyBMT9YCUMZffs6UqUTd0hObXD" crossorigin="anonymous">
	<meta charset="utf-8">

	<title>One Glance</title>
	<meta name="description" content="One Glance">
	<meta name="author" content="SitePoint">
</head>
<body>
	<!-- TradingView Widget BEGIN -->
	<script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
	<script type="text/javascript" > 
		function _createTV_widget(ticker, timeframe)
		{
			new TradingView.widget({
			"width": 640,
			"height": 480,
			"symbol": ticker,
			"interval": timeframe,
			"timezone": "Etc/UTC",
			"theme": "White",
			"style": "1",
			"locale": "en",
			"toolbar_bg": "#f1f3f6",
			"enable_publishing": false,
			"allow_symbol_change": true,
			"hideideas": true,
			"studies": [
			"IchimokuCloud@tv-basicstudies",
			"MACD@tv-basicstudies"
			],
			"show_popup_button": true,
			"popup_width": "1000",
			"popup_height": "650"
			});
		}
	</script>
	<!-- TradingView Widget END -->
	
	<?php
		$__list = array(
						"NASDAQ:AAPL",
						"LSE:III"
						);
		for ($__i = 0; $__i < sizeof($__list); $__i++)
		{
			/*echo $__list[$__i];*/
			?>
				<div class="pure-g"> 
				<div class="pure-u-1-2"><p><script>_createTV_widget(<?php echo json_encode($__list[$__i]); ?>, "W");</script> </p></div>
				<div class="pure-u-1-2"><p><script>_createTV_widget(<?php echo json_encode($__list[$__i]); ?>, "D");</script> </p></div></div>
	
			<?php
		}
	?>
</body>
</html>