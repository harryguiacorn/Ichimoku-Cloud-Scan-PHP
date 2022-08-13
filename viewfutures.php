<?php
	session_start();
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cloud Signals Futures</title>
		<link rel="shortcut icon" href="icon/cloud-icon.png">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="js/cloudsignals.js"></script>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
		<link rel="stylesheet" href="font/sansation/sansation_light/stylesheet.css" type="text/css" charset="utf-8" />
		<link rel="stylesheet" href="font/raleway/stylesheet.css" type="text/css" charset="utf-8" />
		<link rel='stylesheet' href='css/style_cloudservice.css'>
	</head>
<body>
<?php
	//session_start();
	require "class/CloudSignalMain.php";
	define('DATA_PATH','data/futures/');
	define('XML_PATH_STOCK_LIST','xml/Futures.xml');
	define('DEBUG_MODE',false);
	//date_default_timezone_set('Europe/London');//for UK market only
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes

	// if(empty($_GET["symbol"])) $_tickerSymbol = "BDEV.L";
	// else $_tickerSymbol = strtoupper($_GET["symbol"]);
	// if(empty($_GET["interval"])) $_tickerInterval = CloudUtility::DAILY;
	// else $_tickerInterval = strtoupper($_GET["interval"]);
	// _createSignal($_tickerSymbol,"Barratt Developments plc",$_tickerInterval);

	if (empty($_SESSION['count'])) $_SESSION['count'] = 1;
	else $_SESSION['count']++;
	if(DEBUG_MODE) echo "<p>Session Counter: ".$_SESSION['count']."</p>";
	
	$_cloudSignalMain = new CloudSignalMain("Cloud Signals","Futures");
	$_cloudSignalMain->init(CloudUtility::DISPLAY_MODE);
?>

</body>
</html>
