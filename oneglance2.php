<!doctype html>

<html lang="en">
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/pure-min.css" integrity="sha384-UQiGfs9ICog+LwheBSRCt1o5cbyKIHbwjWscjemyBMT9YCUMZffs6UqUTd0hObXD" crossorigin="anonymous">
	<meta charset="utf-8">

	<title>One Glance 2</title>
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
			"width": 570,
			"height": 350,
			"symbol": ticker,
			"interval": timeframe,
			"timezone": "Etc/UTC",
			"theme": "White",
			"style": "1",
			"locale": "en",
			"toolbar_bg": "#f1f3f6",
			"enable_publishiNG.": false,
			"allow_symbol_change": true,
			"hide_top_toolbar": true,
			"hideideas": true,
			"studies": [
			"IchimokuCloud@tv-basicstudies",
			"MACD@tv-basicstudies"
			]
			});
		}
	</script>
	<!-- TradingView Widget END -->
	
	<?php
		$__list = array(
						/*"NASDAQ:AAPL",
						"LSE:III",
						"LSE:ADN",
						"LSE:ADM",
						"LSE:AAL",
						"LSE:ANTO",
						"LSE:AHT",
						"LSE:ABF",
						"LSE:AZN",
						"LSE:AV",
						"LSE:BAB",
						"LSE:BA.",
						"LSE:BARC",
						"LSE:BDEV",
						"LSE:BLT",
						"LSE:BP.",
						"LSE:BATS",
						"LSE:BT.A",
						"LSE:BNZL",
						"LSE:BRBY",
						"LSE:CPI",
						"LSE:CCL",
						"LSE:CNA",
						"LSE:CCH",
						"LSE:CPG",*/
						"LSE:CTEC",
						"LSE:CRH",
						"LSE:CRDA",
						"LSE:DCC",
						"LSE:DGE",
						"LSE:DLG",
						"LSE:DC.",
						"LSE:EZJ",
						"LSE:EXPN",
						"LSE:FRES",
						"LSE:GFS",
						"LSE:GKN",
						"LSE:GSK",
						"LSE:GLEN",
						"LSE:HMSO",
						"LSE:HL.",
						"LSE:HIK",
						"LSE:HSBA",
						"LSE:IMB",
						"LSE:ISAT",
						"LSE:IHG",
						"LSE:IAG",
						"LSE:ITRK",
						"LSE:INTU"/*,
						"LSE:ITV",
						"LSE:SBRY",
						"LSE:JMAT",
						"LSE:KGF",
						"LSE:LAND",
						"LSE:LGEN",
						"LSE:LLOY",
						"LSE:LSE",
						"LSE:MKS",
						"LSE:MDC",
						"LSE:MGGT",
						"LSE:MCRO",
						"LSE:MNDI",
						"LSE:NG.",
						"LSE:NXT",
						"LSE:OML",
						"LSE:PPB",
						"LSE:PSON",
						"LSE:PRU",
						"LSE:RRS",
						"LSE:RB.",
						"LSE:REL",
						"LSE:RIO",
						"LSE:RR.",
						"LSE:RDSA",
						"LSE:RDSB",
						"LSE:RMG",
						"LSE:RSA",
						"LSE:SGE",
						"LSE:SDR",
						"LSE:SVT",
						"LSE:SHP",
						"LSE:SKY",
						"LSE:SN.",
						"LSE:SMIN",
						"LSE:SKG",
						"LSE:SPD",
						"LSE:SSE",
						"LSE:STJ",
						"LSE:STAN",
						"LSE:SL.",
						"LSE:TW.",
						"LSE:TSCO",
						"LSE:BKG",
						"LSE:BLND",
						"LSE:RBS",
						"LSE:TPK",
						"LSE:TUI",
						"LSE:ULVR",
						"LSE:UU.",
						"LSE:VOD",
						"LSE:WTB",
						"LSE:MRW",
						"LSE:WOS",
						"LSE:WPG",
						"LSE:WPP"*/
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