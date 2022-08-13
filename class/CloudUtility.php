<?php
class CloudUtility
{	
	const UPDATE_MODE = "updateMode";
	const DISPLAY_MODE = "displayMode";
	const UPDATE_MODE_DAILY_FTSE100_FROM_SCRATCH 			= "updateModeDailyFtse100FromScratch";
	const UPDATE_MODE_WEEKLY_FTSE100_FROM_SCRATCH 			= "updateModeWeeklyFtse100FromScratch";
	
	const UPDATE_MODE_DAILY_NASDAQ100_FROM_SCRATCH 			= "updateModeDailyNasdaq100FromScratch";
	const UPDATE_MODE_WEEKLY_NASDAQ100_FROM_SCRATCH 		= "updateModeWeeklyNasdaq100FromScratch";

	const UPDATE_MODE_DAILY_SPX500_PART1_FROM_SCRATCH 		= "updateModeDailySpx500Part1FromScratch";
	const UPDATE_MODE_WEEKLY_SPX500_PART1_FROM_SCRATCH 		= "updateModeWeeklySpx500Part1FromScratch";

	const UPDATE_MODE_DAILY_SPX500_PART2_FROM_SCRATCH 		= "updateModeDailySpx500Part2FromScratch";
	const UPDATE_MODE_WEEKLY_SPX500_PART2_FROM_SCRATCH 		= "updateModeWeeklySpx500Part2FromScratch";

	const UPDATE_MODE_DAILY_SPX500_PART3_FROM_SCRATCH 		= "updateModeDailySpx500Part3FromScratch";
	const UPDATE_MODE_WEEKLY_SPX500_PART3_FROM_SCRATCH 		= "updateModeWeeklySpx500Part3FromScratch";

	const UPDATE_MODE_DAILY_SPX500_PART4_FROM_SCRATCH 		= "updateModeDailySpx500Part4FromScratch";
	const UPDATE_MODE_WEEKLY_SPX500_PART4_FROM_SCRATCH 		= "updateModeWeeklySpx500Part4FromScratch";

	const UPDATE_MODE_DAILY_SPX500_PART5_FROM_SCRATCH 		= "updateModeDailySpx500Part5FromScratch";
	const UPDATE_MODE_WEEKLY_SPX500_PART5_FROM_SCRATCH 		= "updateModeWeeklySpx500Part5FromScratch";

	const UPDATE_MODE_DAILY_DOWJONES_FROM_SCRATCH 			= "updateModeDailyDowJonesFromScratch";
	const UPDATE_MODE_WEEKLY_DOWJONES_FROM_SCRATCH 			= "updateModeWeeklyDowJonesFromScratch";

	const UPDATE_MODE_DAILY_ESTOXX_FROM_SCRATCH 			= "updateModeDailyEstoxxFromScratch";
	const UPDATE_MODE_WEEKLY_ESTOXX_FROM_SCRATCH 			= "updateModeWeeklyEstoxxFromScratch";

	const UPDATE_MODE_DAILY_INDICES_FROM_SCRATCH 			= "updateModeDailyIndicesFromScratch";
	const UPDATE_MODE_WEEKLY_INDICES_FROM_SCRATCH 			= "updateModeWeeklyIndicesFromScratch";

	const UPDATE_MODE_DAILY_FUTURES_FROM_SCRATCH 			= "updateModeDailyFuturesFromScratch";
	const UPDATE_MODE_WEEKLY_FUTURES_FROM_SCRATCH 			= "updateModeWeeklyFuturesFromScratch";

	const UPDATE_MODE_DAILY_FOREX_FROM_SCRATCH 				= "updateModeDailyForexFromScratch";
	const UPDATE_MODE_WEEKLY_FOREX_FROM_SCRATCH 			= "updateModeWeeklyForexFromScratch";
	
	const DAILY		= "D";
	const WEEKLY	= "W";
	const DATALOOKBACKPERIOD = '-6 month';
	public static function downloadFile($__file_url, $__save_to)
	{
		
		if(DEBUG_MODE) echo "<p>".__METHOD__." : "."<a href=".$__file_url.">".$__file_url."</a></p>";
		// if(DEBUG_MODE) echo "<p>".__METHOD__." : ". $__file_url."</p>";
		$__fp = fopen($__save_to, 'w');
		$__ch = curl_init($__file_url);
		curl_setopt($__ch, CURLOPT_FILE, $__fp);
		$__data = curl_exec($__ch);
		if(!curl_errno($__ch))
		{
			$info = curl_getinfo($__ch);
			// if(DEBUG_MODE) echo '<p>Took ' . $info['total_time'] . ' to download csv</p>';
		}
		curl_close($__ch);
		fclose($__fp);
	}
	public static function getCsvUrlStooq($__name, $__fromDay = "1", $__fromMonth = "7", $__fromYear = "2015", $__interval = CloudUtility::DAILY, $__toDay = "", $__toMonth = "", $__toYear = "")
	{
		if(empty($__toDay)) $__toDay = date("d");
		if(empty($__toMonth)) $__toMonth = date("m");
		if(empty($__toYear)) $__toYear = date("Y"); 
		return HISTORICAL_URL_STOOQ.strtolower($__name)."&d1=".$__fromYear.$__fromMonth.$__fromDay."&d2=".$__toYear.$__toMonth.$__toDay."&i=".strtolower($__interval);
	}
	//This is a dated function to retrieve yahoo data in 2015.
	public static function getCsvUrlYahooFinanceOLD($__name, $__fromDay = "1", $__fromMonth = "7", $__fromYear = "2015", $__interval = CloudUtility::DAILY, $__toDay = "", $__toMonth = "", $__toYear = "") 
	{
		if(!empty($__fromMonth)) $__fromMonth -= 1;
		if(!empty($__toMonth)) $__toMonth -= 1;
		return HISTORICAL_URL_YAHOO_FINANCE.$__name."&a=".$__fromMonth."&b=".$__fromDay."&c=".$__fromYear."&g=".strtolower($__interval)."&d=".$__toMonth."&e=".$__toDay."&f=".$__toYear."&ignore=.csv";
	}
	public static function getCsvUrlYahooFinance($__name, $__fromDay = "1", $__fromMonth = "5", $__fromYear = "2021", $__interval = CloudUtility::DAILY, $__toDay = "", $__toMonth = "", $__toYear = "")
	{
		if(!empty($__fromMonth)) $__fromMonth -= 1;
		if(!empty($__toMonth)) $__toMonth -= 1;
		
		// $date = "2021-06-26"; //REMOVE DATE AFTER TESTING
		$date = $__fromDay."-".$__fromMonth."-".$__fromYear;
		$timestampPeriod1 = strtotime($date);

		//Period 2
		// $timestampPeriod2 = strtotime('today');//05:00 unix time
		$timestampPeriod2 = time();//current unix time

		if($__interval == CloudUtility::DAILY) $__interval = "d"; else $__interval = "wk";
		return HISTORICAL_URL_YAHOO_FINANCE.$__name."?period1=".$timestampPeriod1."&period2=".$timestampPeriod2."&interval=1".$__interval."&events=history&includeAdjustedClose=true";
	}	
	public static function getCsvSaveToPath($__name, $__period = CloudUtility::DAILY)
	{
		return DATA_PATH."{$__name}_{$__period}.csv";
	}
	public static function getTmpCsvSaveToPath($__name, $__period = CloudUtility::DAILY)
	{
		if (!file_exists(DATA_PATH."tmp/")) {
			mkdir(DATA_PATH."tmp/", 0777, true);
		}
		return DATA_PATH."tmp/{$__name}_{$__period}.csv";
	}
	public static function getLastValidDateFromExistingCSV($__OHLCSeries)
	{
		if(empty($__OHLCSeries->arrayOHLC)) return null;
		$__i=1;
		//The following is commented out because the dates have been sorted decendingly 
		/* for($__i; $__i<count($__OHLCSeries->arrayOHLC); $__i++)
		{
			if(empty($__OHLCSeries->arrayOHLC[$__i]->date))
			{
				return $__OHLCSeries->arrayOHLC[$__i-1]->date;
			}
		} */
		return $__OHLCSeries -> arrayOHLC[$__i] -> date;
	}
	
	public static function isFileExist($__xmlPath)
	{
		if(!file_exists($__xmlPath))
		{
			if(DEBUG_MODE) echo "<p>".__METHOD__." : ". $__xmlPath." is missing"."</p>";
			return false;
		}
		else 
		{
			// if(DEBUG_MODE) echo "<br>".__METHOD__." : ". $__xmlPath." exists";
			return true;
		}
	}
	public static function processCSV($__tickerSymbol, $_tickerName, $__file_url, $__OHLCSeries, $__bFlipSorting=true, $__bPopulateFutureDates=true,$__tickerInterval)
	{
		$__tempArray = CloudUtility::parseCSVToArray($__tickerSymbol, $_tickerName, $__file_url, $__OHLCSeries);
		if($__tempArray) 
		{	
			$__saveToTmpPath 	= CloudUtility::getTmpCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval));
			$__saveToPath		= CloudUtility::getCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval));
			echo "<p>".__METHOD__.":".$__saveToTmpPath."</p>";
			//I need to comment out populating future dates for debugging.
			// if($__bPopulateFutureDates) $__tempArray = CloudUtility::createFutureCloudDates($__tempArray);
			rename($__saveToTmpPath,$__saveToPath);//copy tmp to data folder
			//Disable flip data for debugging.
			if($__bFlipSorting) 		$__tempArray = CloudUtility::flipDateSorting($__tempArray);
			$__OHLCSeries -> arrayOHLC = $__tempArray;
		}
	}
	public static function parseCSVToArray($__tickerSymbol, $_tickerName, $__file_url, $__OHLCSeries)
	{
		if(!CloudUtility::isFileExist($__file_url)) return;
		$__file = fopen($__file_url,"r");
		$__tempArray = array();
		try
		{
			while(! feof($__file))
			{
				$__array_split = fgetcsv($__file);
				if (empty($__array_split)==false)//ignore emply lines in csv if there is any
				{
					if(count($__array_split)<=1)
					{
						echo "<p> Error opening: ",$__file_url, "; array size:".count($__array_split)."</p>";
						fclose($__file);
						return null;
					}
					
					$__OHLC = new Ichimoku();
					$__OHLC -> tickerSymbol = $__tickerSymbol;
					$__OHLC -> tickerName 	= $_tickerName;
					$__OHLC -> date 		= $__array_split[0];
					$__OHLC -> open  		= $__array_split[1];
					$__OHLC -> high  		= $__array_split[2];
					$__OHLC -> low			= $__array_split[3];
					$__OHLC -> close 		= $__array_split[4];
					$__tempArray[] 	= $__OHLC;
				}
			}
		}
		catch (Exception $e) 
		{
			if(DEBUG_MODE) echo 'Caught exception: ',  $e -> getMessage(), "\n";
		}
		fclose($__file);
		return $__tempArray;
	}
	public static function flipDateSorting($__tempArray)
	{
		$__tempArray = array_reverse($__tempArray);
		array_unshift($__tempArray,$__tempArray[count($__tempArray)-1]);
		array_pop($__tempArray);
		return $__tempArray;
	}
	public static function createFutureCloudDates($__tempArray, $__noOfEntryRows = 26)
	{
		for($__i=0;$__i<$__noOfEntryRows;$__i++)//Future Cloud
		{
			$__tempArray[] = new Ichimoku();
		}
		return $__tempArray;
	}
	public static function getDiffBetweenDates($__dataTimeFrom,$__dataTimeTo)
	{
		return date_diff($__dataTimeFrom,$__dataTimeTo,false);
	}
	public static function isBetween($__checkNumber, $__beginNumber, $__endNumber)
	{
		$__min = min($__beginNumber, $__endNumber);
		$__max = max($__beginNumber, $__endNumber);
		if($__checkNumber>=$__min && $__checkNumber<=$__max) return true;
		return false;
	}
	public static function getMidPointOHLC($__arrayOHLC, $__index, $__period = 9)
	{
		// echo "<p>".__METHOD__.": ".$__index."</p>";
		$__tempArray = array_slice($__arrayOHLC,$__index,abs($__period));
		// print_r($__tempArray);
		$__maxOHLC = CloudUtility::getMaxOHLC($__tempArray);
		$__minOHLC = CloudUtility::getMinOHLC($__tempArray);
		if (isset($__maxOHLC) && is_numeric($__maxOHLC) && isset($__minOHLC) && is_numeric($__minOHLC)) 
		{
			$__midPoint = ($__maxOHLC + $__minOHLC)/2;
		} else {
			$__midPoint=null; 
		}
		// echo "<p>".__METHOD__.": ".$__midPoint."</p>";
		return $__midPoint;
	}
	public static function getMidPointSpanA($__tenkansen,$__kijunsen)
	{
		return ($__tenkansen+$__kijunsen)/2;
	}
	public static function getMaxOHLC($__arrayOHLC)
	{
		$__tempArray = array();
		foreach($__arrayOHLC as $__tempHigh)
		{
			if(isset($__tempHigh -> high) && is_numeric($__tempHigh -> high))
			{
				$__tempArray[] =$__tempHigh -> high;
			}
		}
		return max($__tempArray);
	}
	public static function getMinOHLC($__arrayOHLC)
	{
		$__tempArray = array();
		foreach($__arrayOHLC as $__tempLow)
		{
			if(isset($__tempLow -> low) && is_numeric($__tempLow -> low))
			{
				$__tempArray[] =$__tempLow -> low;
			}
		}
		return min($__tempArray);
	}
}
?>