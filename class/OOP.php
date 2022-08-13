<?php
class OHLCSeries
{
	public $tickerSymbol 	= "";
	public $tickerName		= "";
	public $tickerFromDay 	= 0;
	public $tickerFromMonth = 0;
	public $tickerFromYear 	= 0;
	public $tickerToDay 	= 0;
	public $tickerToMonth 	= 0;
	public $tickerToYear 	= 0;
	public $arrayOHLC 		= array();
	public $rawData			= true;
}
class OHLC
{
	public $tickerSymbol 	= "";
	public $tickerName		= "";
	public $date 			= "";
	public $open 			= "";
	public $high 			= "";
	public $low 			= "";
	public $close 			= "";
	public $init			= false;
}
class IchimokuSeries extends OHLCSeries
{
	public $arrayIchimoku = array();
}
class Ichimoku extends OHLC
{
	public $tenkansen;
	public $kijunsen;
	public $senkouspanA;
	public $senkouspanB;
	public $chikouspan;
	public $signalCloud;
	
	public $signalKijunDirection = "";
	public $signalKijunCurrent = "";
	public $signalKijunCurrentConsecutive = null; //log period number of current direction
}
// class SignalKijun extends Ichimoku
// {
// }
class SignalCollector
{
	public $OHLCIchimokuData 		= array(); //type: OHLC or Ichimoku
	public $OHLCSignalArrayByKijun 		= array(); //type: SignalKijun
	public $tickerSymbol 	= "";
	public $tickerName		= "";
}
class OutputPanelObject
{
	public $OHLCDailyOutputArray 	= array(); 
	public $OHLCWeeklyOutputArray 	= array(); 
}

class OutputConsolidatedObject
{
	public $tickerSymbol 	= "";
	public $tickerName		= "";
	public $date 			= "";
	public $direction		= "";
}
class OutputConsolidatedDailyObject extends OutputConsolidatedObject
{
}
class OutputConsolidatedWeeklyObject extends OutputConsolidatedObject
{
}

?>