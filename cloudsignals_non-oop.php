<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cloud Signals</title>
		<link rel="shortcut icon" href="icon/cloud-icon.png">
		<!---->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="js/cloudsignals.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@2.1.0/build/pure-min.css" integrity="sha384-yHIFVG6ClnONEA5yB5DJXfW2/KC173DIQrYoZMEtBvGzmf0PKiGyNEqe9N6BNDBH" crossorigin="anonymous">

		<link rel="stylesheet" href="font/sansation/sansation_light/stylesheet.css" type="text/css" charset="utf-8" />
		<link rel="stylesheet" href="font/raleway/stylesheet.css" type="text/css" charset="utf-8" />
		<link rel='stylesheet' href='css/style_cloudservice.css'>
	</head>
<body>

<?php
require 'class/oop_classes.php';
define('DATA_PATH','data/ftse100/');
define('XML_PATH_STOCK_LIST','xml/FTSE100List.xml');
define('HISTORICAL_URL', 'https://real-chart.finance.yahoo.com/table.csv?s=');
define('ALL','all');
define('BULLISH','bullish');
define('BEARISH','bearish');
define('NEUTRAL','neutral');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

// if(empty($_GET["symbol"])) $_tickerSymbol = "BDEV.L";
// else $_tickerSymbol = strtoupper($_GET["symbol"]);
// if(empty($_GET["interval"])) $_tickerInterval = "D";
// else $_tickerInterval = strtoupper($_GET["interval"]);
// _createSignal($_tickerSymbol,"Barratt Developments plc",$_tickerInterval);

date_default_timezone_set('Europe/London');//for UK market only

$_arrayOHLCSeries = array();
$_bGetLatestCSV = true;
// $_cloudSignalMain = new CloudSignalMain();

_init();
_outputSummaryTable($_arrayOHLCSeries);

function _init()
{
	_checkCSVDate();
	_readXMLStockList();
}
function _readXMLStockList()
{
	$__xml = simplexml_load_file(XML_PATH_STOCK_LIST) or die("Error: Cannot create object");
	foreach($__xml->children() as $__instrument)
	{
		_createSignal($__instrument->symbol,$__instrument->name);
	}
}
function _outputSummaryTable($_arrayOHLCSeries,$__filter=ALL)
{
	if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["signalFilter"])) 
	{
		$__filter = $_POST["signalFilter"];
	}
	if (!isset($__filter)) $__filter = ALL;
	?>
	<h1 class = "title">Cloud Signals</h1>
	<h2>FTSE 100 shares</h2>
	<form id="cloudSerivce" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 

	<!--Signal Filter:
	<input type="radio" name="signalFilter"
	<?php //if (isset($__filter) && $__filter=="all") echo "checked";?>
	value="all">All
	<input type="radio" name="signalFilter"
	<?php //if (isset($__filter) && $__filter=="bullish") echo "checked";?>
	value="bullish">Bullish
	<input type="radio" name="signalFilter"
	<?php //if (isset($__filter) && $__filter=="bearish") echo "checked";?>
	value="bearish">Bearish
	<input type="radio" name="signalFilter" 
	<?php //if (isset($__filter) && $__filter=="in cloud") echo "checked";?>
	value="in cloud">In Cloud-->
	<!--
	<input type="submit" name="submit" value="Show Results" class="pure-button pure-button-primary">
	-->
	
	<div class="pure-g" id="div_button">
		<input type="submit" name="signalFilter" value="all" class="btn btn-success btn-lg <?php if (strcmp($__filter, ALL) != 0) echo "outline"; ?>" >
		<input type="submit" name="signalFilter" value="bullish" class="btn btn-success btn-lg <?php if (strcmp($__filter, BULLISH) != 0) echo "outline"; ?>" >
		<input type="submit" name="signalFilter" value="bearish" class="btn btn-success btn-lg <?php if (strcmp($__filter, BEARISH) != 0) echo "outline"; ?>" >
		<input type="submit" name="signalFilter" value="neutral" class="btn btn-success btn-lg <?php if (strcmp($__filter, NEUTRAL) != 0) echo "outline"; ?>" >
	</div>
	</form>
	<table class="pure-table pure-table-bordered">
		<thead>
			<tr>
				<th><?php echo "Symbol" ?></th>
				<th><?php echo "Name" ?></th>
				<th><?php echo "Date" ?></th>
				<th><?php echo "Daily Direction" ?></th>
			</tr>
		</thead>
		<tbody>
	<?php
	
	$__toggleRowHighligh = true;
	for($__i=0;$__i<count($_arrayOHLCSeries);$__i++)
	{
		$__signalCollector = $_arrayOHLCSeries[$__i];
		
		// echo $__filter." vs ". strtolower(end($__signalCollector->OHLCIchimokuData)->signalCloud)."<br>";
		if($__filter == "all"||strtolower($__filter)==strtolower(end($__signalCollector->OHLCIchimokuData)->signalCloud))
		{
	?>
			<tr <?php 
				if($__toggleRowHighligh) 
				{
					$__toggleRowHighligh = !$__toggleRowHighligh; 
					echo "class='pure-table-odd'";
				}
				else $__toggleRowHighligh = !$__toggleRowHighligh;
				?> >
				<td><?php echo end($__signalCollector->OHLCIchimokuData)->tickerSymbol; ?></td>
				<td><?php echo end($__signalCollector->OHLCIchimokuData)->tickerName; ?></td>
				<td><?php echo end($__signalCollector->OHLCIchimokuData)->date; ?></td>
				
				<?php _getTextDirection(end($__signalCollector->OHLCIchimokuData)->signalCloud); ?>
			</tr>
		<?php
		}
	}?>
		</tbody>
	</table>
	<br>
	<?php
}
function _getTextDirection($__strDirection)
{
	switch (strtolower($__strDirection))
	{
		case BULLISH:
			echo '<td id="txtDirectionBullish" data-toggle="tooltip" data-placement="right"title="Bullish"> &#8679;</td>';
			// echo '<td class="svgBullish"><img src="img/arrow-right.svg" alt="Bullish"></td>'; //svg arrow
		break;
		case BEARISH:
			echo '<td id="txtDirectionBearish" <a data-toggle="tooltip" data-placement="right"title="Bearish">&#8681;</a></td>';
		break;
		default:
			echo '<td id="txtDirectionNeutral" <a data-toggle="tooltip" data-placement="right"title="Neutral">&#8680;</a></td>';

	}
}
function _getCsvUrl($__name, $__fromDay = "1", $__fromMonth = "7", $__fromYear = "2015", $__interval = "d", $__toDay = "", $__toMonth = "", $__toYear = "")
{
	if(!empty($__fromMonth)) $__fromMonth -= 1;
	if(!empty($__toMonth)) $__toMonth -= 1;
	return HISTORICAL_URL.$__name."&a=".$__fromMonth."&b=".$__fromDay."&c=".$__fromYear."&g=".$__interval."&d=".$__toMonth."&e=".$__toDay."&f=".$__toYear."&ignore=.csv";
}
/* function _checkCSVDataStatue($__tickerSymbol,$__tickerInterval="D")
{
	//-- get latest date from yahoo finance --
	$__dateFrom = getdate(strtotime('-1 days'));
	$__file_url = _getCsvUrl($__tickerSymbol,$__dateFrom["mday"],$__dateFrom["mon"],$__dateFrom["year"],$__tickerInterval);
	$__csvOnline = array_map('str_getcsv', file($__file_url));
	$__lastValidDateFromOnlineCSV = new DateTime($__csvOnline[1][0]);//latest date on csv
	
	//-- get latest date from existing copy
	$__OHLCSeries = new IchimokuSeries(); 
	$__OHLCSeries->tickerSymbol = $__tickerSymbol;
	_processCSV($__tickerSymbol, "",DATA_PATH.$__tickerSymbol."_".$__tickerInterval.".csv",$__OHLCSeries,false);
	$__strLastValidDateFromExistingCSV = _getLastValidDateFromExistingCSV($__OHLCSeries);
	$__lastValidDateFromExistingCSV = DateTime::createFromFormat('Y-m-d', $__strLastValidDateFromExistingCSV);
	
	$__diffDays = _getDiffBetweenDates($__lastValidDateFromExistingCSV,$__lastValidDateFromOnlineCSV);
	// echo "server version::".$__csvOnline[1][0];
	// echo "<br>existing version::",$__lastValidDateFromExistingCSV->format('Y-m-d');
	// echo "<br>".$__diffDays->format('%R%a days');
	return $__diffDays->d==0;
} */
function _getDiffBetweenDates($__dataTimeFrom,$__dataTimeTo)
{
	return date_diff($__dataTimeFrom,$__dataTimeTo,false);
}
function _getLastValidDateFromExistingCSV($__OHLCSeries)
{
	if(empty($__OHLCSeries->arrayOHLC)) return null;
	$__i=0;
	for($__i; $__i<count($__OHLCSeries->arrayOHLC); $__i++)
	{
		if(empty($__OHLCSeries->arrayOHLC[$__i]->date))
		{
			return $__OHLCSeries->arrayOHLC[$__i-1]->date;
		}
	}
	return $__OHLCSeries->arrayOHLC[$__i]->date;
}
function _createXMLCSVDownloadDate()
{
	$__xml = new SimpleXMLElement('<xml/>');
	$__nodeLocalCopy = $__xml->addChild('LocalCopy');
	$__nodeLocalCopy ->addChild( 'DownloadDate',date('Y-m-d'));
	$__nodeLocalCopy ->addChild( 'DownloadDateTime',date('Y-m-d h:i:s'));
	$__xmlCsvHistory = fopen("xml/csvHistory.xml", "w") or die("Unable to open file!");
	fwrite($__xmlCsvHistory, $__xml->asXML());
	fclose($__xmlCsvHistory);
}
function _checkCSVDate()
{
	//-- a simpler alternative,check date against a text file.
	global $_bGetLatestCSV;
	if(!file_exists("xml/csvHistory.xml"))
	{
		// echo "<br>local xml not existed";
		$_bGetLatestCSV = true;
	}
	else
	{
		// echo "<br>local xml existed";
		_createXMLCSVDownloadDate();
		$__xml = simplexml_load_file("xml/csvHistory.xml") or die("Error: Cannot create object");
		$__strCSVDownloadDateLocalCopy = $__xml->LocalCopy->DownloadDate;
		$__cSVDownloadDateLocalCopy = DateTime::createFromFormat('Y-m-d', $__strCSVDownloadDateLocalCopy);
		$__strDateNow = date('Y-m-d');
		$__dateNow = DateTime::createFromFormat('Y-m-d', $__strDateNow);
		$__diffDays = _getDiffBetweenDates($__cSVDownloadDateLocalCopy,$__dateNow);
		if($__diffDays->format('%R%a')>0)
		{
			$_bGetLatestCSV = true;
			// echo "<br> notified to get latest online";
		}
		else 
		{
			// $_bGetLatestCSV = false;//TODO: fix here
			// echo "<br> keep using local xml";
		}
		// echo "<br>local copy created date:", $__strCSVDownloadDateLocalCopy;
		// echo "<br>diff between today and created date:".$__diffDays->format('%R%a');
	}	
}
function _createSignal($__tickerSymbol,$__tickerName,$__tickerInterval="D")
{
	global $_arrayOHLCSeries;
	global $_bGetLatestCSV;
	$__OHLCSeries = new IchimokuSeries(); 
	$__OHLCSeries->tickerSymbol = $__tickerSymbol;
	$__signalCollector = new SignalCollector();
	
	//-- check date between existing and yahoo finance,disable it due to slow performance --
	// $__bHasLatestCSV = _checkCSVDataStatue($__tickerSymbol,$__tickerInterval="D");
	// $_bGetLatestCSV = !$__bHasLatestCSV; // end of comment
	
	if($_bGetLatestCSV)
	{
		$__dateFrom = getdate(strtotime('-6 month'));
		_downloadFile(_getCsvUrl($__tickerSymbol,$__dateFrom["mday"],$__dateFrom["mon"],$__dateFrom["year"],$__tickerInterval), _getCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval)));
	}
	_processCSV($__tickerSymbol, $__tickerName,DATA_PATH.$__tickerSymbol."_".$__tickerInterval.".csv",$__OHLCSeries,$_bGetLatestCSV);
	
	_getTenkansen($__OHLCSeries);
	_getKijunsen($__OHLCSeries);
	_getsenkouspanA($__OHLCSeries);
	_getsenkouspanB($__OHLCSeries);
	_createCloudSignal($__OHLCSeries,$__signalCollector);
	
	// _outputTable($__OHLCSeries,$__signalCollector,true,false);
	_saveArrayToCSV($__OHLCSeries);
	$_arrayOHLCSeries[] = $__signalCollector;
}
function _createCloudSignal($__OHLCSeries,$__signalCollector)
{
	for($__i=0; $__i < count($__OHLCSeries->arrayOHLC); $__i++)
	{
		$__OHLC = $__OHLCSeries->arrayOHLC[$__i];
		
		if($__i==0) $__OHLC->signalCloud = "Direction";
		else if(!empty($__OHLC->close)&&!empty($__OHLC->senkouspanA)&&!empty($__OHLC->senkouspanB))
		{
			if($__OHLC->close>$__OHLC->senkouspanA&&$__OHLC->close>$__OHLC->senkouspanB)
			{
				$__OHLC->signalCloud = "Bullish";
			}
			else if($__OHLC->close<$__OHLC->senkouspanA&&$__OHLC->close<$__OHLC->senkouspanB)
			{
				$__OHLC->signalCloud = "Bearish";
			}
			else if(_isBetween($__OHLC->close,$__OHLC->senkouspanA,$__OHLC->senkouspanB))
			{
				$__OHLC->signalCloud = "Neutral";
			}
			
			if(!empty($__OHLC->date)) 
			{
				$__signalCollector->OHLCIchimokuData[] = $__OHLC;//push valid signals to array
			}
		}
	}
}
function _isBetween($__checkNumber, $__beginNumber, $__endNumber)
{
	$__min = min($__beginNumber, $__endNumber);
	$__max = max($__beginNumber, $__endNumber);
	if($__checkNumber>=$__min && $__checkNumber<=$__max) return true;
	return false;
}
function _getsenkouspanA($__OHLCSeries)
{
	$__period = 26;
	for($__i=0; $__i < count($__OHLCSeries->arrayOHLC); $__i++)
	{
		$__OHLC = $__OHLCSeries->arrayOHLC[$__i];
		if($__i==0) $__OHLC->senkouspanA = "SenkouSpanA";
		else if(!empty($__OHLC->tenkansen)&&!empty($__OHLC->kijunsen))
		{
			$__OHLCFuture = $__OHLCSeries->arrayOHLC[$__i+abs($__period)];
			$__OHLCFuture->senkouspanA = _getMidPointSpanA($__OHLC->tenkansen,$__OHLC->kijunsen);
		}
	}	
}
function _getsenkouspanB($__OHLCSeries)
{
	$__period = -52;
	$__shift = 26;
	for($__i=0; $__i < count($__OHLCSeries->arrayOHLC); $__i++)
	{
		$__OHLC = $__OHLCSeries->arrayOHLC[$__i];
		if($__i==0) $__OHLC->senkouspanB = "SenkouSpanB";
		else if($__i>=abs($__period)&&!empty($__OHLC->date))
		{
			$__OHLCFuture = $__OHLCSeries->arrayOHLC[$__i+abs($__shift)];
			$__OHLCFuture->senkouspanB = _getMidPointOHLC($__OHLCSeries->arrayOHLC,$__i,$__period+1);;
		}
	}	
}
function _getTenkansen($__OHLCSeries)
{
	$__period = -9;
	for($__i=0; $__i < count($__OHLCSeries->arrayOHLC); $__i++)
	{
		$__OHLC = $__OHLCSeries->arrayOHLC[$__i];
		if($__i==0) $__OHLC->tenkansen = "Tenkansen";
		else if($__i>=abs($__period)&&!empty($__OHLC->date))
		{
			$__OHLC->tenkansen = _getMidPointOHLC($__OHLCSeries->arrayOHLC,$__i,$__period+1);
		}
	}
}
function _getKijunsen($__OHLCSeries)
{
	$__period = -26;
	for($__i=0; $__i < count($__OHLCSeries->arrayOHLC); $__i++)
	{
		$__OHLC = $__OHLCSeries->arrayOHLC[$__i];
		if($__i==0) $__OHLC->kijunsen = "Kijunsen";
		else if($__i>=abs($__period)&&!empty($__OHLC->date))
		{
			// if($__i==26){print_r($__OHLC);
			$__OHLC->kijunsen = _getMidPointOHLC($__OHLCSeries->arrayOHLC,$__i,$__period+1);
			// echo $__i."___".$__OHLC->tickerSymbol."___".$__OHLC->kijunsen."<br>";
			// }
		}
	}
}
function _getMidPointOHLC($__arrayOHLC, $__index, $__period = -9)
{
	$__tempArray = array_slice($__arrayOHLC,$__index+$__period,abs($__period));
	// echo $__index." ".$__period; print_r($__tempArray);
	$__midPoint = (_getMaxOHLC($__tempArray)+_getMinOHLC($__tempArray))/2;
	if($__midPoint==0) $__midPoint=null; 
	return $__midPoint;
}
function _getMidPointSpanA($__tenkansen,$__kijunsen)
{
	return ($__tenkansen+$__kijunsen)/2;
}
function _getMaxOHLC($__arrayOHLC)
{
	$__tempArray = array();
	foreach($__arrayOHLC as $__tempHigh){$__tempArray[] =$__tempHigh->high;}
	return max($__tempArray);
}
function _getMinOHLC($__arrayOHLC)
{
	$__tempArray = array();
	foreach($__arrayOHLC as $__tempHigh){$__tempArray[] =$__tempHigh->low;}
	return min($__tempArray);
}
function _saveArrayToCSV($__OHLCSeries)
{
	$__arrayCSV = array();
	for($__i=0; $__i < count($__OHLCSeries->arrayOHLC); $__i++)
	{
		$__OHLC = $__OHLCSeries->arrayOHLC[$__i];
		$__row = array(
						$__OHLC->date,
						$__OHLC->open,
						$__OHLC->high,
						$__OHLC->low,
						$__OHLC->close,
						$__OHLC->tenkansen,
						$__OHLC->kijunsen,
						$__OHLC->senkouspanA,
						$__OHLC->senkouspanB,
						$__OHLC->signalCloud
						);
		$__arrayCSV[] = $__row;
	}
	$__fp = fopen(_getCsvSaveToPath($__OHLCSeries->tickerSymbol), 'w');
	foreach ($__arrayCSV as $__row) {fputcsv($__fp, $__row);}
	fclose($__fp);
}
function _outputTable($__OHLCSeries,$__signalCollector,$__showLatest=true,$__showHistory=false)
{
	$__OHLC = $__OHLCSeries->arrayOHLC[0];
	if($__showLatest)
	{
	?>
	<h1 class = "title">Latest Signal</h1>
	<table 
		<tr>
			<th><?php echo "Symbol" ?></th>
			<th><?php echo "Name" ?></th>
			<th><?php echo $__OHLC->date; ?></th>
			<th><?php echo $__OHLC->signalCloud; ?></th>
		</tr>
		<tr>
			<td><?php echo end($__signalCollector->OHLCIchimokuData)->tickerSymbol; ?></td>
			<td><?php echo end($__signalCollector->OHLCIchimokuData)->tickerName; ?></td>
			<td><?php echo end($__signalCollector->OHLCIchimokuData)->date; ?></td>
			<td><?php echo end($__signalCollector->OHLCIchimokuData)->signalCloud; ?></td>
		</tr>
	</table>
	<br>
	<?php }
	if($__showHistory)
	{
		echo "
		<h1 class = \"title\">Signal History</h1>
		<table ";
		for($__i=0; $__i < count($__OHLCSeries->arrayOHLC); $__i++)
		{
			$__OHLC = $__OHLCSeries->arrayOHLC[$__i];
			if($__i==0)
			{
				echo "
					<tr>
						<th>Index</th>
						<th>{$__OHLC->date}</th>
						<th>{$__OHLC->close}</th>
						<th>{$__OHLC->tenkansen}</th>
						<th>{$__OHLC->kijunsen}</th>
						<th>{$__OHLC->senkouspanA}</th>
						<th>{$__OHLC->senkouspanB}</th>
						<th>{$__OHLC->signalCloud}</th>
					</tr>";
			}
			else
			{
				echo "
					<tr>
						<td>{$__i}</td>
						<td>{$__OHLC->date}</td>
						<td>{$__OHLC->close}</td>
						<td>{$__OHLC->tenkansen}</td>
						<td>{$__OHLC->kijunsen}</td>
						<td>{$__OHLC->senkouspanA}</td>
						<td>{$__OHLC->senkouspanB}</td>
						<td>{$__OHLC->signalCloud}</td>
					</tr>";
			}
		}
		echo "</table>";
	}
}
function _getCsvSaveToPath($__name, $__period = "D")
{
	return DATA_PATH."{$__name}_{$__period}.csv";
}
function _downloadFile($__file_url, $__save_to)
{
	$__fp = fopen($__save_to, 'w');
	$__ch = curl_init($__file_url);
	curl_setopt($__ch, CURLOPT_FILE, $__fp);
	$__data = curl_exec($__ch);
	curl_close($__ch);
	fclose($__fp);
}
function _parseCSVToArray($__tickerSymbol, $_tickerName, $__file_url, $__OHLCSeries)
{
	$__file = fopen($__file_url,"r");
	$__tempArray = array();
	try
	{
		while(! feof($__file))
		{
			$__array_split = fgetcsv($__file);
			if (empty($__array_split)==false)//ignore emply lines in csv if there is any
			{
				// echo $__array_split;
				$__OHLC = new Ichimoku();
				$__OHLC->tickerSymbol = $__tickerSymbol;
				$__OHLC->tickerName = $_tickerName;
				$__OHLC->date 	= $__array_split[0];
				$__OHLC->open  	= $__array_split[1];
				$__OHLC->high  	= $__array_split[2];
				$__OHLC->low	= $__array_split[3];
				$__OHLC->close 	= $__array_split[4];
				$__tempArray[] 	= $__OHLC;
			}
		}
	}
	catch (Exception $e) 
	{
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
	fclose($__file);
	return $__tempArray;
}
function _processRawCSV($__tempArray)
{
	$__tempArray = array_reverse($__tempArray);
	array_unshift($__tempArray,$__tempArray[count($__tempArray)-1]);
	array_pop($__tempArray);
	for($__i=0;$__i<26;$__i++)//Future Cloud
	{
		$__tempArray[] = new Ichimoku();
	}
	return $__tempArray;
}
function _processCSV($__tickerSymbol, $_tickerName, $__file_url, $__OHLCSeries, $__bProcessRawCSV=false)
{
	$__tempArray = _parseCSVToArray($__tickerSymbol, $_tickerName, $__file_url, $__OHLCSeries);
	
	if($__bProcessRawCSV) 
	{ 
		$__tempArray = _processRawCSV($__tempArray);
	}
	$__OHLCSeries->arrayOHLC = $__tempArray;
}

?>
</body>
</html>
