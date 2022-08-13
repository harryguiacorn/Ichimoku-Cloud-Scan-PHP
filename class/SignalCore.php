<?php
class SignalCore
{
	private $_arrayOHLCSeriesDaily = array();
	private $_arrayOHLCSeriesWeekly = array();
	private $_bGetLatestCSV;//refactor to $isLatestCSV
	private $_cSVVersionControl;

	public function __construct()
	{
		$this->_cSVVersionControl = new CSVVersionControl();
	}
	public function getArrayOHLCSeriesDaily() { return $this->_arrayOHLCSeriesDaily;}
	public function getArrayOHLCSeriesWeekly() { return $this->_arrayOHLCSeriesWeekly;}
	public function init()
	{
		$this->_parseSignalByXMLList();
	}
	//public function getCSVVersionControl() { return $this->$_cSVVersionControl; }
	
	public function updateCSVDataFromServerFromScratch($__tickerInterval = CloudUtility::DAILY, $__mode = CloudUtility::UPDATE_MODE_DAILY_FTSE100_FROM_SCRATCH)
	{
		if(!CloudUtility::isFileExist(XML_PATH_STOCK_LIST)) return;
		$__xml = simplexml_load_file(XML_PATH_STOCK_LIST) or die("Error: Cannot create object");
		$__nodeCount = 0;
		$json = json_encode($__xml);
		$aXML = json_decode($json,TRUE); //parse XML to array to avoid Fatal error: Maximum execution time of 300 seconds exceeded
		// print_r($aXML);

		$__arrlength=count($aXML['instrument']);
		for($__x=0;$__x<$__arrlength;$__x++)
		{
			$__tickerSymbol = $aXML['instrument'][$__x]['symbol'];
			$__tickerName = $aXML['instrument'][$__x]['name'];
			
			$__nodeCount++;
			// echo $__xml-> count() ."::::::". $__nodeCount;
			if(	$__mode == CloudUtility::UPDATE_MODE_DAILY_FTSE100_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_WEEKLY_FTSE100_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_DAILY_NASDAQ100_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_WEEKLY_NASDAQ100_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_DAILY_FUTURES_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_WEEKLY_FUTURES_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_DAILY_INDICES_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_WEEKLY_INDICES_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_DAILY_DOWJONES_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_WEEKLY_DOWJONES_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_DAILY_ESTOXX_FROM_SCRATCH || 
				$__mode == CloudUtility::UPDATE_MODE_WEEKLY_ESTOXX_FROM_SCRATCH
				) 
			{			
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART1_FROM_SCRATCH && $__x >=0 && $__x < 100) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART2_FROM_SCRATCH && $__x >=100 && $__x < 200) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART3_FROM_SCRATCH && $__x >=200 && $__x < 300) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART4_FROM_SCRATCH && $__x >=300 && $__x < 400) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART5_FROM_SCRATCH && $__x >=400 && $__x < 600) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART1_FROM_SCRATCH && $__x >=0 && $__x < 100) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART2_FROM_SCRATCH && $__x >=100 && $__x < 200) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART3_FROM_SCRATCH && $__x >=200 && $__x < 300) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART4_FROM_SCRATCH && $__x >=300 && $__x < 400) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART5_FROM_SCRATCH && $__x >=400 && $__x < 600) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				echo "<h2> Count: ".$__nodeCount."/".$__xml-> count()."</h2>";
			}
			else if($__mode == CloudUtility::UPDATE_MODE_DAILY_FOREX_FROM_SCRATCH) 
			{
				if(DEBUG_MODE) echo "<h2>". $__tickerInterval."::".$__tickerSymbol."::".$__mode."</h2>";
				$this->_downloadAndProcessRawCSVForex($__tickerSymbol,$__tickerName,$__tickerInterval);
			}
		}
		if($__tickerInterval=="D") echo "<h2>Daily date updated</h2>";
		else if($__tickerInterval=="W") echo "<h2>Weekly date updated</h2>";
	}
	public function updateCSVDataFromServer($__tickerInterval = CloudUtility::DAILY)
	{
		if(!CloudUtility::isFileExist(XML_PATH_STOCK_LIST)) return;
		$__xml = simplexml_load_file(XML_PATH_STOCK_LIST) or die("Error: Cannot create object");
		foreach($__xml->children() as $__instrument)
		{
			$__tickerSymbol = $__instrument->symbol;
			$__tickerName 	= $__instrument->name;
			
			if(!CloudUtility::isFileExist(CloudUtility::getCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval))))//get a copy from server if there is no such csv file locally
			{
				if(DEBUG_MODE) echo "<p>".__METHOD__." : <h2>". $__tickerInterval."::".$__tickerSymbol."</h2></p>";
				$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
			}
			else
			{
				if($this->_cSVVersionControl->isLatestCSV($__tickerSymbol,$__tickerInterval))//file exists and is latest
				{
					if(DEBUG_MODE) echo "<p>".__METHOD__." : ". "Data exists and is up-to-date: ". $__tickerInterval."::".$__tickerSymbol."</p>";
				}
				else //file exists but out of date
				{
					if(DEBUG_MODE) echo "<p>".__METHOD__." : ". "Data exists but out of date, downloading latest date: ". $__tickerInterval."::".$__tickerSymbol."</p>";
					$this->_downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval);
				}
			}
		}
		echo "<h2>".$__tickerInterval." date is updated</h2>";
	}
	private function _downloadAndProcessRawCSVForex($__tickerSymbol,$__tickerName,$__tickerInterval)
	{
		$__signalCollector = new SignalCollector();
		$__fileValidity = $this->_cSVVersionControl->downloadCSVFromServerForex($__tickerSymbol,$__tickerInterval);
		
		if(!$__fileValidity) return; //stooq daily limit hits
		
		$__OHLCSeries = $this->_processRawData($__tickerSymbol,$__tickerName,$__tickerInterval,false,true);//process raw data
		$__signalCollector = $this->_processCloudComponents($__OHLCSeries,$__tickerInterval);
		$this->_cSVVersionControl->updateXMLStockListLatestDate($__tickerSymbol,$__OHLCSeries,$__tickerInterval,$__signalCollector);
	}
	private function _downloadAndProcessRawCSV($__tickerSymbol,$__tickerName,$__tickerInterval)
	{
		$__signalCollector = new SignalCollector();
		// $this->_cSVVersionControl->downloadCSVFromServer($__tickerSymbol,$__tickerInterval);
		// $__OHLCSeries = $this->_processRawData($__tickerSymbol,$__tickerName,$__tickerInterval);//process raw data
		$__countRetry = 0;
		do
		{
			$this->_cSVVersionControl->downloadCSVFromServer($__tickerSymbol,$__tickerInterval);
			$__OHLCSeries = $this->_processRawData($__tickerSymbol,$__tickerName,$__tickerInterval);//process raw data
			
			$__countRetry ++;
			// echo "<h2> ERROR -> TRYING AGAIN -> ".$__countRetry." Array Size: ".sizeof($__OHLCSeries->arrayOHLC)."</h2>";
		} while(sizeof($__OHLCSeries->arrayOHLC) <=1 && $__countRetry = 3);
		
		$__signalCollector = $this->_processCloudComponents($__OHLCSeries,$__tickerInterval);
		
		$this->_cSVVersionControl->updateXMLStockListLatestDate($__tickerSymbol,$__OHLCSeries,$__tickerInterval,$__signalCollector);
	}
	private function _processCloudComponents($__OHLCSeries,$__tickerInterval)
	{
		$__signalCollector = new SignalCollector();
		
		$this->_getTenkansen($__OHLCSeries);
		$this->_getKijunsen($__OHLCSeries);
		$this->_getsenkouspanA($__OHLCSeries);
		$this->_getsenkouspanB($__OHLCSeries); 
		
		$this->_createCloudDirectionSignal($__OHLCSeries,$__signalCollector); 
		$this->_createKijunArrowDirectionSignal($__OHLCSeries,$__signalCollector); 
		// $this->_outputTable($__OHLCSeries,$__signalCollector,true,false);
		$this->_saveArrayToCSV($__OHLCSeries,$__tickerInterval);
		return $__signalCollector;
	}
	private function _parseSignalByXMLList()
	{
		if(!CloudUtility::isFileExist(XML_PATH_STOCK_LIST)) return;
		$__xml = simplexml_load_file(XML_PATH_STOCK_LIST) or die("Error: Cannot create object");
		foreach($__xml->children() as $__instrument)
		{
			// $this->_parseCompleteCSVToArrayOHLCSeries($__instrument->symbol,$__instrument->name,CloudUtility::DAILY);
			// $this->_parseCompleteCSVToArrayOHLCSeries($__instrument->symbol,$__instrument->name,CloudUtility::WEEKLY);
			
			$this->_parseConsolidatedXMLToArrayOHLCSeries($__instrument->symbol,CloudUtility::DAILY);
			$this->_parseConsolidatedXMLToArrayOHLCSeries($__instrument->symbol,CloudUtility::WEEKLY);
		}
	}
	private function _parseConsolidatedXMLToArrayOHLCSeries($__tickerSymbol,$__tickerInterval=CloudUtility::DAILY)
	{
		if(!CloudUtility::isFileExist(XML_PATH_STOCK_LIST)) return;
		$__xml = simplexml_load_file(XML_PATH_STOCK_LIST) or die("Error: Cannot create object");
		
		foreach($__xml->children() as $__instrument)
		{
			if(strcmp($__instrument->symbol,$__tickerSymbol)==0)//found symbol in xml
			{
				$__signalCollector = new SignalCollector();
				if(isset($__instrument->tickerSymbol)) 	$__signalCollector->tickerSymbol 	= $__instrument->symbol;
				if(isset($__instrument->tickerName)) 	$__signalCollector->tickerName 		= $__instrument->name;
				$__OHLC = new Ichimoku();
				$__OHLC->tickerSymbol	= $__signalCollector->tickerSymbol 	= $__instrument->symbol;
				$__OHLC->tickerName		= $__signalCollector->tickerName 	= $__instrument->name;
				
				if(strcmp($__tickerInterval,CloudUtility::DAILY)==0)
				{
					if(isset($__instrument->LatestDateDaily))	
					{
						$__OHLC->date = $__instrument->LatestDateDaily;
					}
					if(isset($__instrument->LatestSignalDaily)) 
					{
						$__OHLC->signalCloud = $__instrument->LatestSignalDaily;
					}
					if(isset($__instrument->LatestKSignalDaily)) 
					{
						$__OHLC->signalKijunDirection = $__instrument->LatestKSignalDaily;
					}
					$__signalCollector->OHLCIchimokuData[] = $__OHLC;
					$this->_arrayOHLCSeriesDaily[] = $__signalCollector;
				}
				else if(strcmp($__tickerInterval,CloudUtility::WEEKLY)==0)
				{
					if(isset($__instrument->LatestDateWeekly))	
					{
						$__OHLC->date = $__instrument->LatestDateWeekly;
					}
					if(isset($__instrument->LatestSignalWeekly)) 
					{
						$__OHLC->signalCloud = $__instrument->LatestSignalWeekly;
					}
					if(isset($__instrument->LatestKSignalWeekly)) 
					{
						$__OHLC->signalKijunDirection = $__instrument->LatestKSignalWeekly;
					}
					$__signalCollector->OHLCIchimokuData[] = $__OHLC;
					$this->_arrayOHLCSeriesWeekly[] = $__signalCollector;
				}
			}
		}
	}
	private function _parseCompleteCSVToArrayOHLCSeries($__tickerSymbol,$__tickerName,$__tickerInterval=CloudUtility::DAILY)
	{
		//TODO: this function should let download_process function do all the calculations
		//TODO: this function is supposed to bring data to output class ONLY!!!
		$__OHLCSeries = new IchimokuSeries(); 
		$__OHLCSeries->tickerSymbol = $__tickerSymbol;
		$__signalCollector = new SignalCollector();
		
		//-- check date between existing and yahoo finance,disable it due to slow performance --
		// $__bHasLatestCSV = $this->_checkCSVDataStatue($__tickerSymbol,$__tickerInterval=CloudUtility::DAILY);
		// $this->_bGetLatestCSV = !$__bHasLatestCSV; // end of comment
		
		if(!CloudUtility::isFileExist(CloudUtility::getCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval)))) return;

		$this->_mapCSVToArray($__tickerSymbol,$__tickerName,$__tickerInterval,$__OHLCSeries);

		//TODO:BELOW IS TO BE REMOVED
		$this->_getTenkansen($__OHLCSeries);
		$this->_getKijunsen($__OHLCSeries);
		$this->_getsenkouspanA($__OHLCSeries);
		$this->_getsenkouspanB($__OHLCSeries);
		$this->_createCloudDirectionSignal($__OHLCSeries,$__signalCollector);
		
		// $this->_outputTable($__OHLCSeries,$__signalCollector,true,false);
		if(strcmp($__tickerInterval,CloudUtility::DAILY)==0) $this->_arrayOHLCSeriesDaily[] = $__signalCollector;
		else $this->_arrayOHLCSeriesWeekly[] = $__signalCollector;
	}
	private function _mapCSVToArray($__tickerSymbol,$__tickerName,$__tickerInterval = CloudUtility::DAILY,$__OHLCSeries,$__bFlipSorting=true, $__bPopulateFutureDates=true)
	{	
		CloudUtility::processCSV($__tickerSymbol, $__tickerName,CloudUtility::getTmpCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval)),$__OHLCSeries,$__bFlipSorting,$__bPopulateFutureDates,$__tickerInterval);
	}
	private function _processRawData($__tickerSymbol,$__tickerName,$__tickerInterval = CloudUtility::DAILY,$__bFlipSorting=true, $__bPopulateFutureDates=true)
	{
		if(!CloudUtility::isFileExist(CloudUtility::getTmpCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval)))) return;
		
		$__OHLCSeries = new IchimokuSeries(); 
		$__OHLCSeries -> tickerSymbol = $__tickerSymbol;
		$this -> _mapCSVToArray($__tickerSymbol,$__tickerName,$__tickerInterval,$__OHLCSeries,$__bFlipSorting,
		$__bPopulateFutureDates);
		return $__OHLCSeries;
	}
	private function _createCloudDirectionSignal($__OHLCSeries,$__signalCollector)
	{
		for($__i=0; $__i < count($__OHLCSeries -> arrayOHLC); $__i++)
		{
			$__OHLC = $__OHLCSeries -> arrayOHLC[$__i];
			
			if($__i==0) $__OHLC -> signalCloud = "CloudDirection";
			else if(!empty($__OHLC -> close)&&!empty($__OHLC -> senkouspanA)&&!empty($__OHLC -> senkouspanB))
			{
				if($__OHLC -> close>$__OHLC -> senkouspanA&&$__OHLC -> close>$__OHLC -> senkouspanB)
				{
					$__OHLC -> signalCloud = "Bullish";
				}
				else if($__OHLC -> close<$__OHLC -> senkouspanA&&$__OHLC -> close<$__OHLC -> senkouspanB)
				{
					$__OHLC -> signalCloud = "Bearish";
				}
				else if(CloudUtility::isBetween($__OHLC -> close,$__OHLC -> senkouspanA,$__OHLC -> senkouspanB))
				{
					$__OHLC -> signalCloud = "Neutral";
				}
				if(!empty($__OHLC -> date)) 
				{
					$__signalCollector -> OHLCIchimokuData[] = $__OHLC;//push valid signals to aXML
					$__signalCollector -> tickerSymbol = $__OHLCSeries -> tickerSymbol;
					$__signalCollector -> tickerName = $__OHLCSeries -> tickerSymbol;
				}
				// var_dump($__OHLC);
			}
		}
	}

	private function _createKijunArrowDirectionSignal($__OHLCSeries, $__signalCollector)
	{
		for($__i=count($__OHLCSeries -> arrayOHLC)-1; $__i >= 0; $__i--)
		{
			$__OHLCNext =  new Ichimoku();
			$__OHLC = $__OHLCSeries -> arrayOHLC[$__i];
			
			if($__i < count($__OHLCSeries -> arrayOHLC)-1) 
			{
				$__OHLCNext = $__OHLCSeries -> arrayOHLC[$__i+1];
			}
			
			if($__i==0)
			{
				$__OHLC -> signalKijunDirection = "KijunArrowDirection";
			} 
			else if($__i > 0 && $__i < count($__OHLCSeries -> arrayOHLC)-1 ) 
			{
				$__OHLCNext = $__OHLCSeries -> arrayOHLC[$__i+1];
			
				if(!empty($__OHLC -> kijunsen) && !empty($__OHLCNext -> kijunsen))
				{
					if($__OHLCNext -> kijunsen > $__OHLC -> kijunsen)
					{
						$__OHLC -> signalKijunCurrent = "-";//DOWN
						$__OHLC -> signalKijunDirection = "-";//DOWN
						// echo "<p>".$__OHLC ->date." ARROW DOWN</p>";
					}
					else if($__OHLCNext -> kijunsen < $__OHLC -> kijunsen)
					{
						$__OHLC -> signalKijunCurrent = "+";//UP
						$__OHLC -> signalKijunDirection = "+";//UP
						
					}
					else if($__OHLCNext -> kijunsen == $__OHLC -> kijunsen)
					{
						if(!isset($__OHLC -> signalKijunCurrent))
						{
							$__OHLC -> signalKijunCurrent = "FLAT";
						}
						if(empty($__OHLC -> signalKijunDirection))
						{
							// if(!isset($__OHLCNext -> signalKijunDirection)) $__OHLCNext -> signalKijunDirection = "NA";
							$__OHLC -> signalKijunDirection = $__OHLCNext -> signalKijunDirection;
						}
						// echo "<p>".$__OHLC ->date." ARROW FLAT</p>";
					}

					// if(!isset($__OHLCNext -> signalKijunDirection)) $__OHLCNext -> signalKijunDirection = "";
					if ($__OHLC -> signalKijunDirection == $__OHLCNext -> signalKijunDirection)
					{
						if (!isset($__OHLCNext -> signalKijunCurrentConsecutive)) 
						{
							$__OHLC -> signalKijunCurrentConsecutive = 1;
						}
						else
						{
							$__OHLC -> signalKijunCurrentConsecutive = $__OHLCNext -> signalKijunCurrentConsecutive + 1;
						}
						// echo "<p>".$__OHLC ->date." ARROW ". $__OHLC -> signalKijunDirection. $__OHLC -> signalKijunCurrentConsecutive."</p>";
					}
					else
					{
						$__OHLC -> signalKijunCurrentConsecutive = 0;
						// echo "<p>".$__OHLC ->date." ARROW ". $__OHLC -> signalKijunDirection. $__OHLC -> signalKijunCurrentConsecutive."</p>";
					}
					if(!empty($__OHLC -> date)) 
					{
						$__signalCollector -> OHLCSignalArrayByKijun[] = $__OHLC;//push valid signals to aXML
						$__signalCollector -> tickerSymbol = $__OHLCSeries -> tickerSymbol;
						$__signalCollector -> tickerName = $__OHLCSeries -> tickerSymbol;
					}
				}
				// var_dump($__OHLC);
			}			
		}
	}
	
	private function _getsenkouspanA($__OHLCSeries)
	{
		$__shift = 26;
		for($__i=0; $__i < count($__OHLCSeries -> arrayOHLC); $__i++)
		{
			$__OHLC = $__OHLCSeries -> arrayOHLC[$__i];
			if($__i==0) $__OHLC -> senkouspanA = "SenkouSpanA";
			else if($__i>$__shift&&!empty($__OHLC -> tenkansen)&&!empty($__OHLC -> kijunsen))
			{
				$__OHLCFuture = $__OHLCSeries -> arrayOHLC[$__i-abs($__shift)];// shift 26 periods to future
				$__OHLCFuture -> senkouspanA = CloudUtility::getMidPointSpanA($__OHLC -> tenkansen,$__OHLC -> kijunsen);
			}
		}	
	}
	private function _getsenkouspanB($__OHLCSeries)
	{
		$__period = 52;
		$__shift = 26;
		for($__i=0; $__i < count($__OHLCSeries -> arrayOHLC); $__i++)
		{
			$__OHLC = $__OHLCSeries -> arrayOHLC[$__i];
			if($__i==0) $__OHLC -> senkouspanB = "SenkouSpanB";
			else if($__i>$__shift)
			{
				// if($__i==1) {print_r($__OHLCSeries);}
				$__OHLCFuture = $__OHLCSeries -> arrayOHLC[$__i-abs($__shift)];
				$__OHLCFuture -> senkouspanB = CloudUtility::getMidPointOHLC($__OHLCSeries -> arrayOHLC,$__i,$__period);
			}
		}	
	}
	private function _getTenkansen($__OHLCSeries)
	{
		$__period = 9;
		for($__i=0; $__i < count($__OHLCSeries -> arrayOHLC); $__i++)
		{
			$__OHLC = $__OHLCSeries -> arrayOHLC[$__i];
			if($__i==0) $__OHLC -> tenkansen = "Tenkansen";
			else if($__i>=1&&!empty($__OHLC -> date)&&$__i<count($__OHLCSeries -> arrayOHLC) - $__period)
			{
				// echo "<p>".$__OHLC -> date." _getKijunsen count: ".count($__OHLCSeries -> arrayOHLC)."</p>";
				$__OHLC -> tenkansen = CloudUtility::getMidPointOHLC($__OHLCSeries -> arrayOHLC,$__i,$__period);
				// print_r($__OHLCSeries -> arrayOHLC);
			}
		}
	}
	private function _getKijunsen($__OHLCSeries)
	{
		$__period = 26;
		
		for($__i=0; $__i < count($__OHLCSeries -> arrayOHLC); $__i++)
		{
			$__OHLC = $__OHLCSeries -> arrayOHLC[$__i];
			if($__i==0) $__OHLC -> kijunsen = "Kijunsen";
			else if($__i>=1&&!empty($__OHLC -> date)&&$__i<count($__OHLCSeries -> arrayOHLC) - $__period)
			{
				$__OHLC -> kijunsen = CloudUtility::getMidPointOHLC($__OHLCSeries -> arrayOHLC,$__i,$__period);
			}
		}
	}

	private function _saveArrayToCSV($__OHLCSeries,$__tickerInterval)
	{
		$__arrayCSV = array();
		for($__i=0; $__i < count($__OHLCSeries -> arrayOHLC); $__i++)
		{
			$__OHLC = $__OHLCSeries -> arrayOHLC[$__i];
			$__row = array(
							$__OHLC -> date,
							$__OHLC -> open,
							$__OHLC -> high,
							$__OHLC -> low,
							$__OHLC -> close,
							$__OHLC -> tenkansen,
							$__OHLC -> kijunsen,
							$__OHLC -> senkouspanA,
							$__OHLC -> senkouspanB,
							$__OHLC -> signalCloud,
							$__OHLC -> signalKijunDirection . (string) $__OHLC -> signalKijunCurrentConsecutive
							);
			$__arrayCSV[] = $__row;
		}
		$__fp = fopen(CloudUtility::getCsvSaveToPath($__OHLCSeries -> tickerSymbol,$__tickerInterval), 'w');
		foreach ($__arrayCSV as $__row) {fputcsv($__fp, $__row);}
		fclose($__fp);
	}
}
?>