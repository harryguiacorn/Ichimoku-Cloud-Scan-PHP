<?php
class CSVDateChecker
{
	private $_bGetLatestCSV;//refactor to $isLatestCSV
	private $_xmlPath = "";
	
	function __construct($__xmlPath="xml/csvHistory.xml")
	{
		$this->_xmlPath = $__xmlPath;
	}	
	
	public function getBooleanLatestCSV()
	{
		return $this->_bGetLatestCSV;
	}
	//TODO: 
	// 1.record last date in xml when downloading its csv
	// 2.update individual stocks accordingly
	function checkCSVDate()
	{
		//-- a simpler alternative,check date against a text file.
		if(!file_exists($this->_xmlPath))
		{
			// echo "<br>local xml not existed";
			$this->_bGetLatestCSV = true;
		}
		else
		{
			// echo "<br>local xml existed";
			$this->_createXMLCSVDownloadDate();
			$__xml = simplexml_load_file($this->_xmlPath) or die("Error: Cannot create object");
			$__strCSVDownloadDateLocalCopy = $__xml->LocalCopy->DownloadDate;
			$__cSVDownloadDateLocalCopy = DateTime::createFromFormat('Y-m-d', $__strCSVDownloadDateLocalCopy);
			$__strDateNow = date('Y-m-d');
			$__dateNow = DateTime::createFromFormat('Y-m-d', $__strDateNow);
			$__diffDays = $this->_getDiffBetweenDates($__cSVDownloadDateLocalCopy,$__dateNow);
			if($__diffDays->format('%R%a')>0)
			{
				$this->_bGetLatestCSV = true;
				// echo "<br> notified to get latest online";
			}
			else 
			{
				$this->_bGetLatestCSV = true;
				// $this->_bGetLatestCSV = false;
				// echo "<br> keep using local xml";
			}
			// echo "<br>local copy created date:", $__strCSVDownloadDateLocalCopy;
			// echo "<br>diff between today and created date:".$__diffDays->format('%R%a');
		}	
		
	}
	function _createXMLCSVDownloadDate()
	{
		$__xml = new SimpleXMLElement('<xml/>');
		$__nodeLocalCopy = $__xml->addChild('LocalCopy');
		$__nodeLocalCopy ->addChild( 'DownloadDate',date('Y-m-d'));
		$__nodeLocalCopy ->addChild( 'DownloadDateTime',date('Y-m-d h:i:s'));
		$__xmlCsvHistory = fopen($this->_xmlPath, "w") or die("Unable to open file!");
		fwrite($__xmlCsvHistory, $__xml->asXML());
		fclose($__xmlCsvHistory);
	}

}
?>