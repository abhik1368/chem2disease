<?php

require_once('database.php');

$content = mysql_real_escape_string(addslashes($_POST['content']));
$query = "SELECT drugname from chemdisease.drugs WHERE drugname LIKE '$content%'";
$result = mysql_query($query) or die(mysql_error());

function boldThat($con,$realValue){
	//$con = A
	//$realValue =Aus
	$length = strlen($con);
	$length2 = strlen($realValue);
	$mainlength = $length-$length2;
	$notBold = substr($realValue,0,$mainlength);
	$bolded  = substr($realValue,$mainlength);
	
	return $notBold."<strong>" .$bolded ."</strong>";
	
	
	}
//echo $result;
while($row = mysql_fetch_assoc($result)){
      echo "<div id = 'link' onClick='addText(\"". $row['drugname']."\");'>".boldThat($content,$row['drugname'])."</div>";

}

?>
