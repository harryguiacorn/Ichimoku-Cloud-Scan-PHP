<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cloud Dow Jones Signals</title>
		<link rel="shortcut icon" href="icon/cloud-icon.png">
		<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="js/cloudsignals.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@2.1.0/build/pure-min.css" integrity="sha384-yHIFVG6ClnONEA5yB5DJXfW2/KC173DIQrYoZMEtBvGzmf0PKiGyNEqe9N6BNDBH" crossorigin="anonymous">

		<link rel="stylesheet" href="font/sansation/sansation_light/stylesheet.css" type="text/css" charset="utf-8" />
		<link rel="stylesheet" href="font/raleway/stylesheet.css" type="text/css" charset="utf-8" />-->
		<link rel='stylesheet' href='css/style_cloudservice.css'>
	</head>
<body>

<?php
	$__timeStart = microtime(true);
	
	require "class/CloudSignalMain.php";
	define('DATA_PATH','data/dowjones/');
	define('XML_PATH_STOCK_LIST','xml/DowJonesList.xml');
	define('DEBUG_MODE',true);
	//date_default_timezone_set('Europe/London');//for UK market only
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	$_cloudSignalMain = new CloudSignalMain("Cloud Signals","Dow Jones shares");
	$_cloudSignalMain->init(CloudUtility::UPDATE_MODE_DAILY_DOWJONES_FROM_SCRATCH);
	
	$__timeFinish = microtime(true);
	$__timeSpent = round($__timeFinish - $__timeStart, 1);
	echo "<h2>Programme Duration: $__timeSpent seconds\n</h2>";
?>
</body>
</html>
