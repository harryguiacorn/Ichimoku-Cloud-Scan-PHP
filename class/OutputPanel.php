<?php
class OutputPanel
{
	public function __construct()
	{
	}
	public function outputSummaryTable($__title,$__subtitle,$__arrayOHLCSeriesDaily,$__arrayOHLCSeriesWeekly)
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["filterTimeFrame"])) 
		{
			$__filterTimeFrame = $_POST["filterTimeFrame"];
			$_SESSION["filterTimeFrame"] = $__filterTimeFrame;
			if(DEBUG_MODE) echo "<p>".__METHOD__." : set filterTimeFrame : ".$_POST["filterTimeFrame"]."</p>";
		}
		if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["filterDirection"])) 
		{
			$__filterDirection = $_POST["filterDirection"];
			$_SESSION["filterDirection"] = $__filterDirection;	
			if(DEBUG_MODE) echo "<p>".__METHOD__." : set filterDirection : ".$_POST["filterDirection"]."</p>";
		}
		if (empty($__filterTimeFrame))
		{
			if(empty($_SESSION["filterTimeFrame"])) 
			{
				$__filterTimeFrame = DAILY;
				$_SESSION["filterTimeFrame"] = DAILY;
			}
			else $__filterTimeFrame = $_SESSION["filterTimeFrame"];
		}
		if (empty($__filterDirection))
		{
			if(empty($_SESSION["filterDirection"])) 
			{
				$__filterDirection = ALL;
				$_SESSION["filterDirection"] = ALL;
				
			}
			else $__filterDirection = $_SESSION["filterDirection"];
		}
		
		if(DEBUG_MODE) echo "<br>".__METHOD__." : filterTimeFrame : ".$_SESSION["filterTimeFrame"];
		if(DEBUG_MODE) echo "<br>".__METHOD__." : filterDirection : ".$_SESSION["filterDirection"];
		
?>

<h1 class = "title"><?php echo $__title ?></h1>
<h2><?php echo $__subtitle ?></h2>

<form id="cloudSerivce" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 

<!--Signal Filter:
<input type="radio" name="filterDirection"
<?php //if (isset($__filterDirection) && $__filterDirection=="all") echo "checked";?>
value="all">All
<input type="radio" name="filterDirection"
<?php //if (isset($__filterDirection) && $__filterDirection=="bullish") echo "checked";?>
value="bullish">Bullish
<input type="radio" name="filterDirection"
<?php //if (isset($__filterDirection) && $__filterDirection=="bearish") echo "checked";?>
value="bearish">Bearish
<input type="radio" name="filterDirection" 
<?php //if (isset($__filterDirection) && $__filterDirection=="in cloud") echo "checked";?>
value="in cloud">In Cloud-->
<!--
<input type="submit" name="submit" value="Show Results" class="pure-button pure-button-primary">
--> 

<div class="pure-g" id="div_button">
	<div class="pure-u-1 pure-u-md-1-5 pure-u-lg-1-5">
	</div>
	<div class="pure-u-1 pure-u-md-1-5 pure-u-lg-1-5">
		<input type="submit" name="filterTimeFrame" value="daily" class="btn btn-success btn-lg <?php if (strcmp($__filterTimeFrame, DAILY) != 0) echo "outline"; ?>" >
	</div>
	<div class="pure-u-1 pure-u-md-1-5 pure-u-lg-1-5">
		<input type="submit" name="filterTimeFrame" value="weekly" class="btn btn-success btn-lg <?php if (strcmp($__filterTimeFrame, WEEKLY) != 0) echo "outline"; ?>" >
	</div>
	<div class="pure-u-1 pure-u-md-1-5 pure-u-lg-1-5">
		<input type="submit" name="filterTimeFrame" value="synergy" class="btn btn-success btn-lg <?php if (strcmp($__filterTimeFrame, SYNERGY) != 0) echo "outline"; ?>" >
	</div>
	<div class="pure-u-1 pure-u-md-1-5 pure-u-lg-1-5">
	</div>
</div>
<br>
<div class="pure-g" id="div_button">
	<div class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-4 pure-u-lg-1-4">
	<input type="submit" name="filterDirection" value="all" class="btn btn-success btn-lg <?php if (strcmp($__filterDirection, ALL) != 0) echo "outline"; ?>" >
	</div>
	<div class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-4 pure-u-lg-1-4">
	<input type="submit" name="filterDirection" value="bullish" class="btn btn-success btn-lg <?php if (strcmp($__filterDirection, BULLISH) != 0) echo "outline"; ?>" >
	</div>
	<div class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-4 pure-u-lg-1-4">
	<input type="submit" name="filterDirection" value="bearish" class="btn btn-success btn-lg <?php if (strcmp($__filterDirection, BEARISH) != 0) echo "outline"; ?>" >
	</div>
	<div class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-4 pure-u-lg-1-4">
	<input type="submit" name="filterDirection" value="neutral" class="btn btn-success btn-lg <?php if (strcmp($__filterDirection, NEUTRAL) != 0) echo "outline"; ?>" >
	</div>
</div>
</form>
<table class="pure-table pure-table-bordered" id="myTable">
	<?php 
		$this -> _createTableHeader($__filterTimeFrame);
	?>
	<tbody>
	<?php
	$__toggleRowHighligh = true;
	// echo "-------------------------<br>";
	// print_r($__arrayOHLCSeriesDaily);
	// echo count($__arrayOHLCSeriesDaily[0] -> OHLCIchimokuData);
	// echo "<br>-------------------------";
	if(strcmp($__filterTimeFrame,DAILY)==0)
	{
		for($__i=0;$__i<count($__arrayOHLCSeriesDaily);$__i++)
		{
			$__signalCollector	= $__arrayOHLCSeriesDaily[$__i];
			if(!empty($__signalCollector -> OHLCIchimokuData))
			{
				$__tickerSymbol = $__signalCollector -> tickerSymbol;
				$__dailySignal 	= $this -> _getDirectionBySymbol($__tickerSymbol,$__arrayOHLCSeriesDaily);
				if($__filterDirection == ALL||strtolower($__filterDirection)==strtolower($__dailySignal))
				{
					echo "<tr";
						$__toggleRowHighligh = $this -> _createRowHighlight($__toggleRowHighligh); 
					echo ">"; 
					$this -> _createTableContentPartA($__signalCollector);
					$this -> _createTableContentDailyDirection($__dailySignal);
					$this -> _createTableContentTextKDirection($__signalCollector);
					echo "</tr>";
				}
			}
		}
	}
	else if(strcmp($__filterTimeFrame,WEEKLY)==0)
	{
		// _validateSignalByFilterCriteria
		for($__i=0;$__i<count($__arrayOHLCSeriesWeekly);$__i++)
		{
			$__signalCollector 	= $__arrayOHLCSeriesWeekly[$__i];
			if(!empty($__signalCollector -> OHLCIchimokuData))
			{
				$__tickerSymbol = $__signalCollector -> tickerSymbol;
				$__weeklySignal = $this -> _getDirectionBySymbol($__tickerSymbol,$__arrayOHLCSeriesWeekly);
				if($__filterDirection == ALL||strtolower($__filterDirection)==strtolower($__weeklySignal))
				{
					echo "<tr";
						$__toggleRowHighligh = $this -> _createRowHighlight($__toggleRowHighligh); 
					echo ">"; 
					$this -> _createTableContentPartA($__signalCollector);
					$this -> _createTableContentDailyDirection($__weeklySignal);
					$this -> _createTableContentTextKDirection($__signalCollector);
					echo "</tr>";
				}
			}
		}
	}
	else if(strcmp($__filterTimeFrame,SYNERGY)==0)
	{
		for($__i=0;$__i<count($__arrayOHLCSeriesDaily);$__i++)
		{
			for($__j=0;$__j<count($__arrayOHLCSeriesWeekly);$__j++)
			{
				$__signalCollectorDaily		= $__arrayOHLCSeriesDaily[$__i];
				$__signalCollectorWeekly 	= $__arrayOHLCSeriesWeekly[$__j];
				if(!empty($__signalCollectorDaily -> OHLCIchimokuData) && !empty($__signalCollectorWeekly -> OHLCIchimokuData))
				{
					$__tickerSymbolDaily 	= $__signalCollectorDaily -> tickerSymbol;
					$__tickerSymbolWeekly 	= $__signalCollectorWeekly -> tickerSymbol;
					$__dailySignal 	= $this -> _getDirectionBySymbol($__tickerSymbolDaily,$__arrayOHLCSeriesDaily);
					$__weeklySignal = $this -> _getDirectionBySymbol($__tickerSymbolWeekly,$__arrayOHLCSeriesWeekly);
					if(	$__filterDirection == ALL||
						(strtolower($__filterDirection)==strtolower($__weeklySignal)&&
						strtolower($__filterDirection)==strtolower($__dailySignal)))
					{
						if(strcmp($__tickerSymbolDaily,$__tickerSymbolWeekly)==0)
						{
							echo "<tr";
							$__toggleRowHighligh = $this -> _createRowHighlight($__toggleRowHighligh); 
							echo ">"; 
							$this -> _createTableContentPartA($__signalCollectorDaily);
							$this -> _createTableContentDailyDirection($__dailySignal);
							$this -> _createTableContentTextKDirection($__signalCollectorDaily);
							$this -> _createTableContentDailyDirection($__weeklySignal);
							$this -> _createTableContentTextKDirection($__signalCollectorWeekly);
							echo "</tr>";
						}
					}
				}
				
			}
		}
	}
	?>
	</tbody>
</table>
<br>
		
<?php
	}
	private function _validateSignalByFilterCriteria($__i,$__filterDirection,$__arrayOHLCSeriesDaily)
	{
		$__signalCollector	= $__arrayOHLCSeriesDaily[$__i];
		if(!empty($__signalCollector -> OHLCIchimokuData))
		{
			$__tickerSymbol = $__signalCollector -> tickerSymbol;
			$__dailySignal 	= $this -> _getDirectionBySymbol($__tickerSymbol,$__arrayOHLCSeriesDaily);
			if($__filterDirection == ALL||strtolower($__filterDirection)==strtolower($__dailySignal))
			{
				return true;
			}
		}
		return false;
	}
	private function _createRowHighlight($__toggleRowHighligh)
	{
		if($__toggleRowHighligh) 
		{
			$__toggleRowHighligh = !$__toggleRowHighligh; 
			echo "class='pure-table-odd'";
		}
		else $__toggleRowHighligh = !$__toggleRowHighligh;
		return $__toggleRowHighligh;
	}
	private function _getDirectionBySymbol($__tickerSymbol,$__arrayOHLCSeries)
	{
		$__OHLCSeries = $this -> _getObjectBySymbol($__tickerSymbol,$__arrayOHLCSeries);
		if($__OHLCSeries)
		{
			$__dailySignal = end($__OHLCSeries -> OHLCIchimokuData) -> signalCloud;
			$__currentDirection = $__dailySignal;
		}			
		else 
		{
			$__currentDirection = NEUTRAL;//no enough daily data
		}
		return $__currentDirection;
	}
	private function _getObjectBySymbol($__tickerSymbol,$__arrayOHLCSeries)
	{
		// if(DEBUG_MODE) echo "<br>".__METHOD__." : " ."daily symbol is::".$__tickerSymbol;
		foreach($__arrayOHLCSeries as $__OHLCSeries)
		{
			if(empty($__OHLCSeries -> OHLCIchimokuData)) return null;//no enough data
			// if(DEBUG_MODE) echo "<br>".__METHOD__." : "."find here:".end($__OHLCSeries -> OHLCIchimokuData) -> tickerSymbol;
			if(strcmp($__tickerSymbol,end($__OHLCSeries -> OHLCIchimokuData) -> tickerSymbol)==0)
			{
				return $__OHLCSeries;
			}
		}
		return null;
	}
	private function _createTableContentDailyDirection($__currentDirection)
	{
		$this -> _createTableContentTextDirection($__currentDirection); 		
	}
	private function _createTableContentWeeklyDirection($__currentDirection)
	{
		$this -> _createTableContentTextDirection($__currentDirection); 		
	}
	private function _createTableContentPartA($__signalCollector)
	{
		?>
		<td><?php echo end($__signalCollector -> OHLCIchimokuData) -> tickerSymbol; ?></td>
		<td><?php echo end($__signalCollector -> OHLCIchimokuData) -> tickerName; ?></td>
		<td><?php echo end($__signalCollector -> OHLCIchimokuData) -> date; ?></td>
		<?php 
	}
	private function _createTableHeader($__filterTimeFrame)
	{
		?>
		<thead>
			<tr>
				<th onclick="sortTableAlphabetical(0)"><?php echo "Symbol" ?></th>
				<th><?php echo "Name" ?></th>
				<th><?php echo "Date" ?></th>
				<?php
				if(strcmp($__filterTimeFrame,WEEKLY)!=0)
				{
					?><th><?php echo "Cloud(D)";?> </th>
					<th id="demo" onclick="sortTableNumerical(4)"><?php echo "K Arrow(D)" ?></th>
					<!-- <th id="demo"><?php echo "K Arrow(D)" ?></th> -->
					<?php
				}
				?>
				<?php
				if(strcmp($__filterTimeFrame,DAILY)!=0)
				{
					?><th><?php echo "Cloud(W)";?>  </th>
					<th id="demo" onclick="sortTableNumerical(6)"><?php echo "K Arrow(W)" ?></th>
					<!-- <th id="demo" ><?php echo "K Arrow(W)" ?></th> -->
					<?php
				}
				?>
			</tr>
		</thead>
		<script>
			function sortTableAlphabetical(n) {
				var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
				table = document.getElementById("myTable");
				switching = true;
				// Set the sorting direction to ascending:
				dir = "asc";

				/* Make a loop that will continue until
				no switching has been done: */
				while (switching) {
					// Start by saying: no switching is done:
					switching = false;
					rows = table.rows;
					/* Loop through all table rows (except the
					first, which contains table headers): */
					for (i = 1; i < (rows.length - 1); i++) {
						// Start by saying there should be no switching:
						shouldSwitch = false;
						
						/* Get the two elements you want to compare,
						one from current row and one from the next: */
						x = rows[i].getElementsByTagName("TD")[n];
						y = rows[i + 1].getElementsByTagName("TD")[n];
						
						var strX = x.innerHTML.toLowerCase();
						var strY = y.innerHTML.toLowerCase();
						/* Check if the two rows should switch place,
						based on the direction, asc or desc: */
						if (dir == "asc") {
							if (strX > strY) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						} else if (dir == "desc") {
							if (strX < strY) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						}
					}
					if (shouldSwitch) {
						/* If a switch has been marked, make the switch
						and mark that a switch has been done: */
						rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
						switching = true;
						// Each time a switch is done, increase this count by 1:
						switchcount ++;
						} else {
							/* If no switching has been done AND the direction is "asc",
							set the direction to "desc" and run the while loop again. */
							if (switchcount == 0 && dir == "asc") {
								dir = "desc";
								switching = true;
							}
						}
				}
			}
			function sortTableNumerical(n) {
				var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
				table = document.getElementById("myTable");
				switching = true;
				// Set the sorting direction to ascending:
				dir = "asc";

				/* Make a loop that will continue until
				no switching has been done: */
				while (switching) {
					// Start by saying: no switching is done:
					switching = false;
					rows = table.rows;
					/* Loop through all table rows (except the
					first, which contains table headers): */
					for (i = 1; i < (rows.length - 1); i++) {
						// Start by saying there should be no switching:
						shouldSwitch = false;
						
						/* Get the two elements you want to compare,
						one from current row and one from the next: */
						x = rows[i].getElementsByTagName("TD")[n];
						y = rows[i + 1].getElementsByTagName("TD")[n];
						
						var strX = Number(x.innerHTML);
						var strY = Number(y.innerHTML);
						/* Check if the two rows should switch place,
						based on the direction, asc or desc: */
						if (dir == "asc") {
							if (strX > strY) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						} else if (dir == "desc") {
							if (strX < strY) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						}
					}
					if (shouldSwitch) {
						/* If a switch has been marked, make the switch
						and mark that a switch has been done: */
						rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
						switching = true;
						// Each time a switch is done, increase this count by 1:
						switchcount ++;
						} else {
							/* If no switching has been done AND the direction is "asc",
							set the direction to "desc" and run the while loop again. */
							if (switchcount == 0 && dir == "asc") {
								dir = "desc";
								switching = true;
							}
						}
				}
			}
		</script>
		<?php
	}
	private function _createTableContentTextDirection($__strDirection)
	{
		if (is_null($__strDirection)) return;
		switch (strtolower($__strDirection))
		{
			case BULLISH:
				echo '<td id="txtDirectionBullish" <a title="Bullish"> &#8679;</a></td>';
				// echo '<td class="svgBullish"><img src="img/arrow-right.svg" alt="Bullish"></td>'; //svg arrow
			break;
			case BEARISH:
				echo '<td id="txtDirectionBearish" <a title="Bearish">&#8681;</a></td>';
			break;
			default:
				echo '<td id="txtDirectionNeutral" <a title="Neutral">&#8680;</a></td>';
		}
	}

	private function _createTableContentTextKDirection($__signalCollector)
	{
		$regex = "/\D+/g";
		$strX = reset($__signalCollector -> OHLCIchimokuData) -> signalKijunDirection;
		echo '<td id="txtDirectionK" <a title="KijunDirection">'.$strX;'</a></td>';
	}

	public function _outputTable($__OHLCSeries,$__signalCollector,$__showLatest=true,$__showHistory=false)
	{
		$__OHLC = $__OHLCSeries -> arrayOHLC[0];
		if($__showLatest)
		{
		?>
		<h1 class = "title">Latest Signal</h1>
		<table 
			<tr>
				<th><?php echo "Symbol" ?></th>
				<th><?php echo "Name" ?></th>
				<th><?php echo $__OHLC -> date; ?></th>
				<th><?php echo $__OHLC -> signalCloud; ?></th>
			</tr>
			<tr>
				<td><?php echo end($__signalCollector -> OHLCIchimokuData) -> tickerSymbol; ?></td>
				<td><?php echo end($__signalCollector -> OHLCIchimokuData) -> tickerName; ?></td>
				<td><?php echo end($__signalCollector -> OHLCIchimokuData) -> date; ?></td>
				<td><?php echo end($__signalCollector -> OHLCIchimokuData) -> signalCloud; ?></td>
			</tr>
		</table>
		<br>
		<?php }
		if($__showHistory)
		{
			echo "
			<h1 class = \"title\">Signal History</h1>
			<table ";
			for($__i=0; $__i < count($__OHLCSeries -> arrayOHLC); $__i++)
			{
				$__OHLC = $__OHLCSeries -> arrayOHLC[$__i];
				if($__i==0)
				{
					echo "
						<tr>
							<th>Index</th>
							<th>{$__OHLC -> date}</th>
							<th>{$__OHLC -> close}</th>
							<th>{$__OHLC -> tenkansen}</th>
							<th>{$__OHLC -> kijunsen}</th>
							<th>{$__OHLC -> senkouspanA}</th>
							<th>{$__OHLC -> senkouspanB}</th>
							<th>{$__OHLC -> signalCloud}</th>
						</tr>";
				}
				else
				{
					echo "
						<tr>
							<td>{$__i}</td>
							<td>{$__OHLC -> date}</td>
							<td>{$__OHLC -> close}</td>
							<td>{$__OHLC -> tenkansen}</td>
							<td>{$__OHLC -> kijunsen}</td>
							<td>{$__OHLC -> senkouspanA}</td>
							<td>{$__OHLC -> senkouspanB}</td>
							<td>{$__OHLC -> signalCloud}</td>
						</tr>";
				}
			}
			echo "</table>";
		}
	}
}
?>