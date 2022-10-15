<?php
//define('HISTORICAL_URL_YAHOO_FINANCE', 'https://real-chart.finance.yahoo.com/table.csv?s=');
define('HISTORICAL_URL_YAHOO_FINANCE', 'https://query1.finance.yahoo.com/v7/finance/download/');
define('HISTORICAL_URL_STOOQ', 'https://stooq.com/q/d/l/?s=');
define('ALL','all');
define('BULLISH','bullish');
define('BEARISH','bearish');
define('NEUTRAL','neutral');
define('DAILY','daily');
define('WEEKLY','weekly');
define('MULTITIMEFRAME','multitimeframe');//TODO:CORRECT NAME
define('SYNERGY','synergy');
require 'class/OOP.php';
require "class/CSVDateChecker.php";
require "class/SignalCore.php";
require "class/CSVVersionControl.php";
require "class/CloudUtility.php";
require "class/OutputPanel.php";

class CloudSignalMain
{
	private $title;
	private $subtitle;
	
	// private $_csvDateChecker;
	private $_signalCore;
	private $_outputPanel;
	
	private $_arrayOHLCSeriesDaily = array();
	private $_arrayOHLCSeriesWeekly = array();
	
	public function __construct($__title, $__subtitle)
	{
		$this->title = $__title;
		$this->subtitle = $__subtitle;
	}
	
	public function init($__mode)
	{
		// $_csvDateChecker = new CSVDateChecker();
		$_signalCore = new SignalCore();
		$_outputPanel = new OutputPanel();
		
		if($__mode == CloudUtility::UPDATE_MODE)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE"."</h2>";
			$_signalCore -> updateCSVDataFromServer(CloudUtility::DAILY);
			$_signalCore -> updateCSVDataFromServer(CloudUtility::WEEKLY);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_FTSE100_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_FTSE100_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_FTSE100_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_FTSE100_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_FTSE100_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_FTSE100_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_DOWJONES_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_DOWJONES_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_DOWJONES_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_DOWJONES_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_DOWJONES_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_DOWJONES_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_NASDAQ100_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_NASDAQ100_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_NASDAQ100_FROM_SCRATCH);
		}	
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_NASDAQ100_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_NASDAQ100_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_NASDAQ100_FROM_SCRATCH);
		}		
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_ESTOXX_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_ESTOXX_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_ESTOXX_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_ESTOXX_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_ESTOXX_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_ESTOXX_FROM_SCRATCH);
		}	
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_INDICES_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_INDICES_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_INDICES_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_INDICES_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_INDICES_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_INDICES_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_FUTURES_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_FUTURES_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_FUTURES_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_FUTURES_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_FUTURES_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_FUTURES_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART1_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_SPX500_PART1_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_SPX500_PART1_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART1_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_SPX500_PART1_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART1_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART2_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_SPX500_PART2_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_SPX500_PART2_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART2_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_SPX500_PART2_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART2_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART3_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_SPX500_PART3_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_SPX500_PART3_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART3_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_SPX500_PART3_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART3_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART4_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_SPX500_PART4_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_SPX500_PART4_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART4_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_SPX500_PART4_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART4_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_SPX500_PART5_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_DAILY_SPX500_PART5_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY, CloudUtility::UPDATE_MODE_DAILY_SPX500_PART5_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART5_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_WEEKLY_SPX500_PART5_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY, CloudUtility::UPDATE_MODE_WEEKLY_SPX500_PART5_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::UPDATE_MODE_DAILY_FOREX_FROM_SCRATCH)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : UPDATE_MODE_FOREX_FROM_SCRATCH"."</h2>";
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::DAILY,$__mode, CloudUtility::UPDATE_MODE_DAILY_FOREX_FROM_SCRATCH);
			$_signalCore -> updateCSVDataFromServerFromScratch(CloudUtility::WEEKLY,$__mode, CloudUtility::UPDATE_MODE_WEEKLY_FOREX_FROM_SCRATCH);
		}
		else if($__mode == CloudUtility::DISPLAY_MODE)
		{
			if(DEBUG_MODE) echo "<h2>".__METHOD__." : DISPLAY_MODE"."</h2>";
			$_signalCore -> init();
			
			//TODO: FEED CONSOLIDATED DATA INTO THE ARRAY TO SAVE UP LOADING TIME
			$this -> _arrayOHLCSeriesDaily 	= $_signalCore -> getArrayOHLCSeriesDaily();
			$this -> _arrayOHLCSeriesWeekly 	= $_signalCore -> getArrayOHLCSeriesWeekly();
			// $_outputPanel -> outputSummaryTable($_outputPanel -> getFilterTimeFrame(),$_outputPanel -> getFilterDirection(),$this -> title,$this -> subtitle,$this -> _arrayOHLCSeriesDaily,$this -> _arrayOHLCSeriesWeekly);
			$_outputPanel -> outputSummaryTable($this -> title,$this -> subtitle,$this -> _arrayOHLCSeriesDaily,$this -> _arrayOHLCSeriesWeekly);
		}
		// $_csvDateChecker -> checkCSVDate();
	}
}
?>