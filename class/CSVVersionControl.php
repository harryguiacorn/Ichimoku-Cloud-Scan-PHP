<?php
class CSVVersionControl
{
	public function isLatestCSV($__tickerSymbol,$__tickerInterval=CloudUtility::DAILY)
	{
		$__bHasLatestCSV = $this->_checkCSVDataStatue($__tickerSymbol,$__tickerInterval=CloudUtility::DAILY);
		if(DEBUG_MODE) {echo "<br>".__METHOD__." : "; var_dump($__bHasLatestCSV);}
		return $__bHasLatestCSV;
	}
	public function downloadCSVFromServerForex($__tickerSymbol,$__tickerInterval=CloudUtility::DAILY)
	{
		if(strcmp($__tickerInterval,CloudUtility::DAILY)==0) 
		{
			$__fromDate 	= strtotime('-6 month');
			$__fromDay 		= date('d',$__fromDate);
			$__fromMonth 	= date('m',$__fromDate);
			$__fromYear 	= date('Y',$__fromDate);
		}
		else 
		{
			$__fromDate 	= strtotime('-3 year');
			$__fromDay 		= date('d',$__fromDate);
			$__fromMonth 	= date('m',$__fromDate);
			$__fromYear 	= date('Y',$__fromDate);
		}
		//tmp folder for downloaded stooq csv in case of exceeding daily limits,only valid csv files are moved to forex folder
		$__urlPath 		= CloudUtility::getCsvUrlStooq($__tickerSymbol,$__fromDay,$__fromMonth,$__fromYear,$__tickerInterval);
		$__saveToTmpPath 	= CloudUtility::getTmpCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval));
		$__saveToPath 	= CloudUtility::getCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval));
		
		CloudUtility::downloadFile($__urlPath, $__saveToTmpPath);
		
		$__csvValidity = $this -> _checkStooqCSVDownloadLimitValidity($__saveToTmpPath);
		
		if($__csvValidity)
		{
			copy($__saveToTmpPath,$__saveToPath);//copy tmp to data folder
		}
		return $__csvValidity;
	}
	
	private function _checkStooqCSVDownloadLimitValidity($__tmpCsvPath)//check csv for exceeding limits
	{
		if(!CloudUtility::isFileExist($__tmpCsvPath)) return;
		$__file = fopen($__tmpCsvPath,"r");
		$__tempArray = array();
		$__array_split = fgetcsv($__file);
		if($__array_split[0]=="Exceeded the daily hits limit")
		{
			if(DEBUG_MODE) echo "<p>".__METHOD__." : Error: ".$__array_split[0]."</p>";
			return false;
		}
		return true;
	}
	public function downloadCSVFromServer($__tickerSymbol,$__tickerInterval=CloudUtility::DAILY)
	{
		if(strcmp($__tickerInterval,CloudUtility::DAILY)==0) $__dateFrom = getdate(strtotime(CloudUtility::DATALOOKBACKPERIOD));
		else $__dateFrom = getdate(strtotime('-3 year'));
		
		CloudUtility::downloadFile(CloudUtility::getCsvUrlYahooFinance($__tickerSymbol,$__dateFrom["mday"],$__dateFrom["mon"],$__dateFrom["year"],$__tickerInterval), CloudUtility::getTmpCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval)));
	}
	public function updateXMLStockListLatestDate($__tickerSymbol,$__OHLCSeries,$__tickerInterval,$__signalCollector)
	{
		if(!CloudUtility::isFileExist(XML_PATH_STOCK_LIST)) return;
		$__xml = simplexml_load_file(XML_PATH_STOCK_LIST) or die("Error: Cannot create object");
		foreach($__xml -> children() as $__instrument)
		{
			if(strcmp($__instrument -> symbol,$__tickerSymbol)==0)//found symbol in xml
			{
				if(strcmp($__tickerInterval,CloudUtility::DAILY)==0)
				{
					if(isset($__instrument -> LatestDateDaily)) unset($__instrument -> LatestDateDaily);//remove existing date
					$__strLastValidDateFromExistingCSV = CloudUtility::getLastValidDateFromExistingCSV($__OHLCSeries);//put latest date
					if(isset($__strLastValidDateFromExistingCSV)) $__instrument -> addChild("LatestDateDaily",$__strLastValidDateFromExistingCSV);
					
					if(isset($__instrument -> LatestSignalDaily)) unset($__instrument -> LatestSignalDaily);//remove existing date
					if(empty($__signalCollector -> OHLCIchimokuData)) $__strLastValidSignalFromExistingCSV = "N/A";
					else $__strLastValidSignalFromExistingCSV = reset($__signalCollector -> OHLCIchimokuData) -> signalCloud;//put latest date
					if(isset($__strLastValidSignalFromExistingCSV)) $__instrument -> addChild("LatestSignalDaily",$__strLastValidSignalFromExistingCSV);

					if(isset($__instrument -> LatestKSignalDaily)) unset($__instrument -> LatestKSignalDaily);//remove existing date
					if(empty($__signalCollector -> OHLCIchimokuData)) $__strLastValidKSignalFromExistingCSV = "N/A";
					else $__strLastValidKSignalFromExistingCSV = reset($__signalCollector -> OHLCIchimokuData) -> signalKijunDirection.reset($__signalCollector -> OHLCIchimokuData) -> signalKijunCurrentConsecutive;//put latest date
					if(isset($__strLastValidKSignalFromExistingCSV)) $__instrument -> addChild("LatestKSignalDaily",$__strLastValidKSignalFromExistingCSV);	
				}
				else if(strcmp($__tickerInterval,CloudUtility::WEEKLY)==0)
				{
					if(isset($__instrument -> LatestDateWeekly)) unset($__instrument -> LatestDateWeekly);//remove existing date
					$__strLastValidDateFromExistingCSV = CloudUtility::getLastValidDateFromExistingCSV($__OHLCSeries);//put latest date
					if(isset($__strLastValidDateFromExistingCSV)) $__instrument -> addChild("LatestDateWeekly",$__strLastValidDateFromExistingCSV);	
					
					if(isset($__instrument -> LatestSignalWeekly)) unset($__instrument -> LatestSignalWeekly);//remove existing date
					if(empty($__signalCollector -> OHLCIchimokuData)) $__strLastValidSignalFromExistingCSV = "N/A";
					else $__strLastValidSignalFromExistingCSV = reset($__signalCollector -> OHLCIchimokuData) -> signalCloud;//put latest date
					if(isset($__strLastValidSignalFromExistingCSV)) $__instrument -> addChild("LatestSignalWeekly",$__strLastValidSignalFromExistingCSV);

					if(isset($__instrument -> LatestKSignalWeekly)) unset($__instrument -> LatestKSignalWeekly);//remove existing date
					if(empty($__signalCollector -> OHLCIchimokuData)) $__strLastValidKSignalFromExistingCSV = "N/A";
					else $__strLastValidKSignalFromExistingCSV = reset($__signalCollector -> OHLCIchimokuData) -> signalKijunDirection.reset($__signalCollector -> OHLCIchimokuData) -> signalKijunCurrentConsecutive;//put latest date
					if(isset($__strLastValidKSignalFromExistingCSV)) $__instrument -> addChild("LatestKSignalWeekly",$__strLastValidKSignalFromExistingCSV);	
				}
			}
		}
		$__xml -> asXML(XML_PATH_STOCK_LIST);//write back to xml
	}
	private function _checkCSVDataStatue($__tickerSymbol,$__tickerInterval=CloudUtility::DAILY)
	{
		//-- get latest date from yahoo finance --
		$__dateFrom = getdate(strtotime('-7 days'));
		$__file_url = CloudUtility::getCsvUrlYahooFinance($__tickerSymbol,$__dateFrom["mday"],$__dateFrom["mon"],$__dateFrom["year"],$__tickerInterval);
		$__csvOnline = array_map('str_getcsv', file($__file_url));
		$__lastValidDateFromOnlineCSV = new DateTime($__csvOnline[1][0]);//latest date on csv
		
		//-- Option 1: get latest date from each existing csv copy
		/* $__OHLCSeries = new IchimokuSeries(); 
		$__OHLCSeries -> tickerSymbol = $__tickerSymbol;
		CloudUtility::processCSV($__tickerSymbol, "",CloudUtility::getCsvSaveToPath($__tickerSymbol, strtoupper($__tickerInterval)),$__OHLCSeries,false);
		$__strLastValidDateFromExistingCSV = CloudUtility::getLastValidDateFromExistingCSV($__OHLCSeries);
		$__lastValidDateFromExistingRecord = DateTime::createFromFormat('Y-m-d', $__strLastValidDateFromExistingCSV); */
		
		//Option 2 alternative: get latest date from existing copy,check xml node for quick diff
		if(!CloudUtility::isFileExist(XML_PATH_STOCK_LIST)) return;
		$__xml = simplexml_load_file(XML_PATH_STOCK_LIST) or die("Error: Cannot create object");
		foreach($__xml -> children() as $__instrument)
		{
			if(strcmp($__instrument -> symbol,$__tickerSymbol)==0)//found symbol in xml
			{
				if(isset($__instrument -> LatestDateDaily))//remove existing date
				{
					if(DEBUG_MODE) echo "<p>".__METHOD__." : ". $__instrument -> symbol." : ".$__instrument -> LatestDateDaily."</p>";
					$__strXMLNodeLatestDateDaily = $__instrument -> LatestDateDaily;
					$__lastValidDateFromExistingRecord = DateTime::createFromFormat('Y-m-d', $__strXMLNodeLatestDateDaily);
				}
			}
		}
		if(empty($__lastValidDateFromExistingRecord)) return false;//LatestDateDaily  node is missing in xml
		
		$__diffDays = CloudUtility::getDiffBetweenDates($__lastValidDateFromExistingRecord,$__lastValidDateFromOnlineCSV);
		if(DEBUG_MODE) echo "<p>".__METHOD__." : ". "server version::".$__csvOnline[1][0]."</p>";
		if(DEBUG_MODE) echo "<p>".__METHOD__." : ". "existing version::",$__lastValidDateFromExistingRecord -> format('Y-m-d')."</p>";
		if(DEBUG_MODE) echo "<p>".__METHOD__." : ". $__diffDays -> format('%R%a days')."</p>";
		return $__diffDays -> d==0;
	}
}
?>