<?php
require_once('database.php');

function getLanguage() {
	global $database;	
	global $conndb;
	
	$sql = "SELECT * FROM languages ORDER BY name ASC";
	mysql_select_db($database,$conndb);
	$rs = mysql_query($sql,$conndb) or die(mysql_error());
	$rows = mysql_fetch_assoc($rs);
	$tot_rows = mysql_num_rows($rs);
	if($tot_rows > 0) {
		echo "<select name=\"srch_language\" id=\"srch_language\">\n";
		echo "<option value=\"\">Any language&hellip;</option>\n";
		do {
			echo "<option value=\"".$rows['id']."\"";
			getSticky(2,'srch_language',$rows['id']);
			echo ">".$rows['name']."</option>";
		} while($rows = mysql_fetch_assoc($rs));
		echo "</select>";
	}
	mysql_free_result($rs);
}

function getAuthors() {
	global $database;	
	global $conndb;
	
	$sql = "SELECT * FROM authors ORDER BY name ASC";
	mysql_select_db($database,$conndb);
	$rs = mysql_query($sql,$conndb) or die(mysql_error());
	$rows = mysql_fetch_assoc($rs);
	$tot_rows = mysql_num_rows($rs);
	if($tot_rows > 0) {
		echo "<select name=\"srch_author\" id=\"srch_author\">\n";
		echo "<option value=\"\">Any author&hellip;</option>\n";
		do {
			echo "<option value=\"".$rows['id']."\"";
			getSticky(2,'srch_author',$rows['id']);
			echo ">".$rows['name']."</option>";
		} while($rows = mysql_fetch_assoc($rs));
		echo "</select>";
	}
	mysql_free_result($rs);
}

function getCategories() {
	global $database;	
	global $conndb;
	
	$sql = "SELECT * FROM categories ORDER BY name ASC";
	mysql_select_db($database,$conndb);
	$rs = mysql_query($sql,$conndb) or die(mysql_error());
	$rows = mysql_fetch_assoc($rs);
	$tot_rows = mysql_num_rows($rs);
	if($tot_rows > 0) {
		echo "<select name=\"srch_category\" id=\"srch_category\">\n";
		echo "<option value=\"\">Any category&hellip;</option>\n";
		do {
			echo "<option value=\"".$rows['id']."\"";
			getSticky(2,'srch_category',$rows['id']);
			echo ">".$rows['name']."</option>";
		} while($rows = mysql_fetch_assoc($rs));
		echo "</select>";
	}
	mysql_free_result($rs);
}

function getYears() {
	global $database;	
	global $conndb;
	
	$sql = "SELECT DISTINCT YEAR(date_released) AS year FROM books ORDER BY date_released ASC";
	mysql_select_db($database,$conndb);
	$rs = mysql_query($sql,$conndb) or die(mysql_error());
	$rows = mysql_fetch_assoc($rs);
	$tot_rows = mysql_num_rows($rs);
	if($tot_rows > 0) {
		echo "<select name=\"srch_year\" id=\"srch_year\">\n";
		echo "<option value=\"\">Any year&hellip;</option>\n";
		do {
			echo "<option value=\"".$rows['year']."\"";
			getSticky(2,'srch_year',$rows['year']);
			echo ">".$rows['year']."</option>";
		} while($rows = mysql_fetch_assoc($rs));
		echo "</select>";
	}
	mysql_free_result($rs);
}

function getCover() {
	global $database;	
	global $conndb;
	
	$sql = "SELECT * FROM covers ORDER BY name ASC";
	mysql_select_db($database,$conndb);
	$rs = mysql_query($sql,$conndb) or die(mysql_error());
	$rows = mysql_fetch_assoc($rs);
	$tot_rows = mysql_num_rows($rs);
	if($tot_rows > 0) {
		echo "<label for=\"srch_cover-0\">";
		echo "<input type=\"radio\" name=\"srch_cover\" id=\"srch_cover-0\" value=\"0\"";
		getSticky(4,'srch_cover',0,1);
		echo "/>\nAny</label>";		
		do {
			echo "<label for=\"srch_cover-".$rows['id']."\">";
			echo "<input type=\"radio\" name=\"srch_cover\" id=\"srch_cover-".$rows['id']."\" value=\"".$rows['id']."\"";
			getSticky(4,'srch_cover',$rows['id']);
			echo "/>\n".$rows['name']."</label>";
		} while($rows = mysql_fetch_assoc($rs));
	}
	mysql_free_result($rs);
}

function getLocation() {
	global $database;	
	global $conndb;
	
	$sql = "SELECT * FROM locations ORDER BY name ASC";
	mysql_select_db($database,$conndb);
	$rs = mysql_query($sql,$conndb) or die(mysql_error());
	$rows = mysql_fetch_assoc($rs);
	$tot_rows = mysql_num_rows($rs);
	if($tot_rows > 0) {
		echo "<ul class=\"chkbx\">";
		do {
			echo "<li>";
			echo "<input type=\"checkbox\" name=\"srch_locations-".$rows['id']."\" id=\"srch_locations-".$rows['id']."\" value=\"".$rows['id']."\"";
			getSticky(3,"srch_locations-".$rows['id'],$rows['id']);			
			echo "/><label for=\"srch_locations-".$rows['id']."\">".$rows['name']."</label>";
			echo "</li>";
		} while($rows = mysql_fetch_assoc($rs));
		echo "</ul>";
	}
	mysql_free_result($rs);
}

function getSticky($case,$par,$value="",$initial="") {
	switch($case) {
		case 1: // text field
		if (isset($_GET[$par]) && $_GET[$par] !="") {
			echo stripslashes($_GET[$par]);	
		}
		break;
		case 2: // select
		if (isset($_GET[$par]) && $_GET[$par] == $value) {
			echo " selected=\"selected\"";
		}
		break;
		case 3: // checkbox group
		if (isset($_GET[$par]) && $_GET[$par] !="") {
			echo " checked=\"checked\"";	
		}
		break;
		case 4: // radio buttons
		if (isset($_GET[$par]) && $_GET[$par] == $value) {
			echo " checked=\"checked\"";	
		} else {
			if ($initial !="") {
				echo " checked=\"checked\"";	
			}
		}
		break;
	}
}
?>