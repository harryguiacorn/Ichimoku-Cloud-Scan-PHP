<?php
// require "class/CloudUtility.php";
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name    = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
	$name = $_POST["name"];
	
    if (empty($_POST["website"])) {
        $website = "";
    } else {
        $website = test_input($_POST["website"]);
        // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        if (!preg_match("/\b[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
            $websiteErr = "Invalid URL";
        }
    }
    _downloadFile('tmp/'.$name,$website);
}
// function _downloadFile($__filename="",$__fileurl="")
// {
	// file_put_contents('tmp/'.$__filename, file_get_contents($__fileurl));
	// CloudUtility::downloadFile($__fileurl,'tmp/'.$__filename);
// }
function _downloadFile($__save_to,$__file_url)
{
	// file_put_contents('tmp/'.$__save_to, file_get_contents($__file_url));
	$__fp = fopen($__save_to, 'w');
	$__ch = curl_init($__file_url);
	curl_setopt($__ch, CURLOPT_FILE, $__fp);
	$__data = curl_exec($__ch);
	if(!curl_errno($__ch))
	{
		$info = curl_getinfo($__ch);
	}
	curl_close($__ch);
	fclose($__fp);
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<h2>Download Helper</h2>
<form method="post" action="<?php
echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>"> 
	File Name: <input type="text" name="name" value="<?php
echo $name;
?>">
   <br><br>
   URL: <input type="text" name="website" value="<?php
echo $website;
?>">
   <br><br>
   
   <input type="submit" name="submit" value="Submit"> 
</form>

<?php
echo "<h2>Output:</h2>";
echo $name;
echo "<br>";
echo $website;
?>