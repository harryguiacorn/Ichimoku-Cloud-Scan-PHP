<?php
	session_start();
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cloud Signals Forex</title>
		<link rel="shortcut icon" href="icon/cloud-icon.png">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="js/cloudsignals.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@2.1.0/build/pure-min.css" integrity="sha384-yHIFVG6ClnONEA5yB5DJXfW2/KC173DIQrYoZMEtBvGzmf0PKiGyNEqe9N6BNDBH" crossorigin="anonymous">

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@2.1.0/build/grids-responsive-min.css">
		<link rel="stylesheet" href="font/sansation/sansation_light/stylesheet.css" type="text/css" charset="utf-8" />
		<link rel="stylesheet" href="font/raleway/stylesheet.css" type="text/css" charset="utf-8" />
		<link rel='stylesheet' href='css/style_cloudservice.css'>
	</head>
<body>
<?php
	//session_start();
	require "class/CloudSignalMain.php";
	define('DATA_PATH','data/forex/');
	define('XML_PATH_STOCK_LIST','xml/ForexList.xml');
	define('DEBUG_MODE',false);
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes

	if (empty($_SESSION['count'])) $_SESSION['count'] = 1;
	else $_SESSION['count']++;
	if(DEBUG_MODE) echo "<p>Session Counter: ".$_SESSION['count']."</p>";
	
	$_cloudSignalMain = new CloudSignalMain("Cloud Signals","Forex");
	$_cloudSignalMain->init(CloudUtility::DISPLAY_MODE);
?>

</body>
</html>
