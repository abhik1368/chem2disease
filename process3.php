<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Drug Similarity</title>
<link href="style/process1.css" rel="stylesheet" type="text/css" />
<script type ="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="html2csv.js" ></script>
<script type="text/javascript" src="tablesort.js"></script>
<script type="text/javascript" src="paginate.js"></script>
<style type="text/css">

input.right {
    float: right;
}
p
        {
        width:800px;
        margin:0 auto 1.6em auto;
        }
        
/* Pagination list styles */
ul.fdtablePaginater
        {
        display:table;
        list-style:none;
        padding:0;
        margin:0 auto;
        text-align:center;
        height:2em;
        width:auto;
        margin-bottom:2em;
        }
ul.fdtablePaginater li
        {
        display:table-cell;
        padding-right:4px;
        color:#666;
        list-style:none;
        
        -moz-user-select:none;
        -khtml-user-select:none;
        }
ul.fdtablePaginater li a.currentPage
        {
        border-color:#a84444 !important;
        color:#000;
        }
ul.fdtablePaginater li a:active
        {
        border-color:#222 !important;
        color:#222;
        }
ul.fdtablePaginater li a,
ul.fdtablePaginater li div
        {
        display:block;
        width:2em;
        font-size:1em;
        color:#666;
        padding:0;
        margin:0;
        text-decoration:none;
        outline:none;
        border:1px solid #ccc;
        font-family:georgia, serif;
        }
ul.fdtablePaginater li div
        {
        cursor:normal;
        opacity:.5;
        filter:alpha(opacity=50);
        }
ul.fdtablePaginater li a span,
ul.fdtablePaginater li div span
        {
        display:block;
        line-height:2em;
        border:1px solid #fff;
        background:#fff url(../media/gradient.gif) repeat-x 0 -20px;
        }
ul.fdtablePaginater li a
        {
        cursor:pointer;
        }
ul.fdtablePaginater li a:focus
        {
        color:#333;
        text-decoration:none;
        border-color:#aaa;
        }
.fdtablePaginaterWrap
        {
        text-align:center;
        clear:both;
        text-decoration:none;
        }
ul.fdtablePaginater li .next-page span,
ul.fdtablePaginater li .previous-page span,
ul.fdtablePaginater li .first-page span,
ul.fdtablePaginater li .last-page span
        {
        font-weight:bold !important;
        }
/* Keep the table columns an equal size during pagination */
td.sized1
        {
        width:16em;
        text-align:left;
        }
td.sized2
        {
        width:10em;
        text-align:left;
        }
td.sized3
        {
        width:7em;
        text-align:left;
        }
tfoot td
        {
        text-align:right;
        font-weight:bold;
        text-transform:uppercase;
        letter-spacing:1px;
        }
#visibleTotal
        {
        text-align:center;
        letter-spacing:auto;
        }
* html ul.fdtablePaginater li div span,
* html ul.fdtablePaginater li div span
        {
        background:#eee;
        }
tr.invisibleRow
        {
        display:none;
        visibility:hidden;
        }
p.paginationText
        {
        font-style:oblique;
        }
</style>
</head>
<body>
<?php
error_reporting (E_ALL ^ E_NOTICE);
require_once('database.php');
mysql_select_db("chemdisease", $conndb);
$keyword = $_POST['srch_for'];
if(isset($_POST['submit'])) {
    $checked = implode(',', $_POST['search']);
	$d = $_POST['disease'];
	//echo $chekced ;
//	print_r ($_POST['search']);
}
$check = $_POST['search'];
$arraycheckbox =array(
                        "sideEffect"=>0,
						"ECFP"=> 0,
						"Pubchem" => 0,
						"protein" => 0,
						"rocs" => 0
						 );

$arraydropdown = array (
                  "sideEffect"=>0,
				  "ECFP"=>0,
				  "Pubchem" =>0,
				  "protein"=>0,
				  "rocs" =>0 );
				  						
foreach(@$_POST['search'] as $checks){
	  $arraycheckbox[$checks] = 1;
	  //echo $checked;
	  }
  
if (empty($d) && empty($checked)){
	
      echo("<p>please select an option for similarity search .</p>\n");
	  
}

elseif (empty($d) && !empty($checked)){
	
               echo "<h2>Similarity of $keyword by $checked </h2>";
               echo "<TABLE id = 'mytable' class ='db-table sortable-onload-3 no-arrow rowstyle-alt colstyle-alt paginate-20 max-pages-5 paginationcallback-callbackTest-displayTextInfo' cell cellpadding='0' cell spacing='0' width='100%'>" ;
               echo "<thead>";
               echo "<tr>"; 
			   echo "<th width =2% > Rank </th>";
               echo "<th width=3% >Drug Name</th>"; 
			   echo "<th width = 5% >Chemical structure</th>";
               echo "<th width=3% >Similarity</th>"; 
			   echo "<th width =5% >ATC Code</th>";
			   echo "</tr>"; 
			   echo "</thead>";
			   $N = count($check);
	            // echo $N;
               if($N == 1){
			   
               if ($checked =='sideEffect'){
               $query= "delete from chemdisease.tmpone";	
               mysql_query($query) or die(mysql_error());
               $query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,sideEffect from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select    
		            sourceDrug,sideEffect from chemdisease.drugeffect where targetDrug = '$keyword') order by sideEffect desc limit 500";
                $query2 = "select t.sourceDrug ,t.similarityValue, a.atcCode from chemdisease.tmpone t , drugatc a where t.sourceDrug=a.sourceDrug && t.similarityValue > 0.1 limit 500";

              mysql_query($query1) or die(mysql_error());

         	$result = mysql_query($query2) or die(mysql_error());
	
	while ( $row = mysql_fetch_assoc($result) )
    { $n++;
  echo "<tr>";
  echo "<td>".$n."</td>";
  $p=$row['sourceDrug'];
  
echo "<td>"."<a href =http://en.wikipedia.org/wiki/$p>".$row['sourceDrug']."</a>"."</td>";
$hreftag="<a href=\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\">";
$d = $hreftag."<img src =\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\" height=\"150\" width=\"150\"/>"."</a>";
echo "<td>".$d."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['atcCode']."</td>";
echo "<tr>";
    }

}

elseif ($checked =='ECFP6'){
$query= "delete from chemdisease.tmpone";	
mysql_query($query) or die(mysql_error());
$query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,ECFP6 from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select sourceDrug,ECFP6 from chemdisease.drugeffect where targetDrug = '$keyword') order by ECFP6 desc limit 20";
$query2 = "select t.sourceDrug ,t.similarityValue, a.atcCode from chemdisease.tmpone t , drugatc a where t.sourceDrug=a.sourceDrug && t.similarityValue > 0.1 limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
     
   $n++;
  echo "<tr>";
  echo "<td>".$n."</td>";
$p=$row['sourceDrug'];
echo "<td>"."<a href =http://en.wikipedia.org/wiki/$p>".$row['sourceDrug']."</a>"."</td>";
$hreftag="<a href=\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\">";
$d = $hreftag."<img src =\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\" height=\"150\" width=\"150\"/>"."</a>";
echo "<td>".$d."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['atcCode']."</td>";
echo "<tr>";
    }
	
}
elseif ($checked =='pubchem'){
$query= "delete from chemdisease.tmpone";	
mysql_query($query) or die(mysql_error());
$query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,pubchem from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select sourceDrug,pubchem from chemdisease.drugeffect where targetDrug = '$keyword') order by pubchem desc limit 500";
$query2 =  "select t.sourceDrug ,t.similarityValue, a.atcCode from chemdisease.tmpone t , drugatc  a where t.sourceDrug=a.sourceDrug && t.similarityValue > 0.1  limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
       
 $n++;
  echo "<tr>";
  echo "<td>".$n."</td>";
$p=$row['sourceDrug'];
echo "<td>"."<a href =http://en.wikipedia.org/wiki/$p>".$row['sourceDrug']."</a>"."</td>";
$hreftag="<a href=\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\">";
$d = $hreftag."<img src =\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\" height=\"150\" width=\"150\"/>"."</a>";
echo "<td>".$d."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['atcCode']."</td>";
echo "<tr>";
    }
 
}

elseif ($checked =='protein'){
$query= "delete from chemdisease.tmpone";	
mysql_query($query) or die(mysql_error());
$query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,protein from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select sourceDrug,protein from chemdisease.drugeffect where targetDrug = '$keyword') order by protein desc limit 500";
$query2 =  "select t.sourceDrug ,t.similarityValue, a.atcCode from chemdisease.tmpone t , drugatc a where t.sourceDrug=a.sourceDrug && t.similarityValue > 0.1 limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
   $n++;
  echo "<tr>";
  echo "<td>".$n."</td>";
$p=$row['sourceDrug'];
echo "<td>"."<a href =http://en.wikipedia.org/wiki/$p>".$row['sourceDrug']."</a>"."</td>";
$hreftag="<a href=\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\">";
$d = $hreftag."<img src =\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\" height=\"150\" width=\"150\"/>"."</a>";
echo "<td>".$d."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['atcCode']."</td>";
echo "<tr>";
    }
 
}

elseif($checked =='rocs'){
$query= "delete from chemdisease.tmpone";	
mysql_query($query) or die(mysql_error());
$query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,rocs from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select sourceDrug,rocs from chemdisease.drugeffect where targetDrug = '$keyword') order by rocs desc limit 500";
$query2 =  "select t.sourceDrug ,t.similarityValue, a.atcCode from chemdisease.tmpone t , drugatc a where t.sourceDrug=a.sourceDrug && t.similarityValue > 0.1 limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    { $n++ ;
echo "<tr>";
echo "<td>".$n."</td>";
$p=$row['sourceDrug'];
echo "<td>"."<a href =http://en.wikipedia.org/wiki/$p>".$row['sourceDrug']."</a>"."</td>";
$hreftag="<a href=\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\">";
$d = $hreftag."<img src =\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\" height=\"150\" width=\"150\"/>"."</a>";
echo "<td>".$d."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['atcCode']."</td>";
echo "<tr>";
    }
}

} 
      elseif($N>1){
		  foreach($_POST as $key=>$value)
		{   if (preg_match('/^0.[0-9]$/', (string)$value))
			{
				
                $arraydropdown[$key]=1;
			}
         }
		 $value1=array_values($arraycheckbox);
         $value2=array_values($arraydropdown);
		 
		 $checkboxkeys = array_keys($arraycheckbox);
		 $dropdownkeys = array_keys($arraydropdown);
		  $querystring="";
		for ( $i = 0; $i < count($value1); $i++)
        {   //  echo $value1[$i]."=>".$value2[$i];   
          if ( $value1[$i] == 1 && $value2[$i] == 1 ) {
			//echo "key = " . $checkboxkeys[$i] . "  value = ". $_POST[$dropdownkeys[$i]] . "\n";
			$querystring .= $checkboxkeys[$i]."*".(string)$_POST[$dropdownkeys[$i]]."+";
		  } elseif ( $value1[$i] == 0 && $value2[$i] == 0 ){
			//echo ("<p>select right combination.</p>\n");
			//return;  
		  } else {
			  echo ("<p>select right combination.</p>\n");
			 return;
		  }
        }
	//	echo $querystring;
        $query= "delete from chemdisease.tmpone";         	
         mysql_query($query) or die(mysql_error()); 
		 $q=rtrim($querystring, "+");
		// echo $q;
		 $query1="insert into chemdisease.tmpone(sourceDrug , similarityValue) (select targetDrug,(".$q.") as summation from   
		          chemdisease.drugeffect where sourceDrug='$keyword')  union (select   sourceDrug,(".$q.")as summation from  
				  chemdisease.drugeffect where targetDrug='$keyword')order by summation desc limit 500";
				 mysql_query($query1) or die(mysql_error());
		  
        $query2 ="select t.sourceDrug ,t.similarityValue, a.atcCode from chemdisease.tmpone t , drugatc a where t.sourceDrug=a.sourceDrug limit 500" ;
		
		$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
           $n++;
           echo "<tr>";
           echo "<td>".$n."</td>";
          $p=$row['sourceDrug'];
          echo "<td>"."<a href =http://en.wikipedia.org/wiki/$p>".$row['sourceDrug']."</a>"."</td>";
		  $hreftag="<a href=\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\">";
          $d = $hreftag."<img src =\"http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/name/".$row['sourceDrug']."/PNG\" height=\"150\" width=\"150\"/>"."</a>";
          echo "<td>".$d."</td>";
          echo "<td>".$row['similarityValue']."</td>";
		  echo "<td>".$row['atcCode']."</td>";
          echo "<tr>";
    }
		  }
 
 }
  			   


else{


echo "<h2>Similarity of $keyword by $checked and its associated diseases </h2>";
echo "<TABLE id = 'mytable' class ='db-table sortable-onload-3 no-arrow rowstyle-alt colstyle-alt paginate-20 max-pages-5 paginationcallback-callbackTest-displayTextInfo' cell cellpadding='0' cell spacing='0'>" ;
echo "<thead>";
echo "<tr>"; 
echo "<th width=20% >Drug Name</th>"; 
echo "<th width=20%>Similarity</th>"; 
echo"<th width=50%> Disease Name</th>";
echo"<th width=50%> Pubmed ID</th>";
echo "</tr>"; 
echo "</thead>";
if(empty($checked)) 
        {
			echo("<p>You didn't select any options.</p>\n");
		} 

else{
       $N = count($check);
	  // echo $N;
     if($N == 1){
     if ($checked =='sideEffect'){
         $query= "delete from chemdisease.tmpone";	
          mysql_query($query) or die(mysql_error());
         $query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,sideEffect from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select    
		            sourceDrug,sideEffect from chemdisease.drugeffect where targetDrug = '$keyword') order by sideEffect desc limit 500";
         $query2 = "select t.sourceDrug , t.similarityValue , d.disease, d.pubmedid from chemdisease.tmpone t, drugdisease d where t.sourceDrug = d.sourceDrug && t.similarityValue > 0.1 limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	
	while ( $row = mysql_fetch_assoc($result) )
    {
echo "<tr>";
echo "<td>".$row['sourceDrug']."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['disease']."</td>";
echo "<td>".$row['pubmedid']."</td>";
echo "<tr>";
    }

}

elseif ($checked =='ECFP6'){
$query= "delete from chemdisease.tmpone";	
mysql_query($query) or die(mysql_error());
$query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,ECFP6 from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select sourceDrug,ECFP6 from chemdisease.drugeffect where targetDrug = '$keyword') order by ECFP6 desc limit 20";
$query2 = "select t.sourceDrug , t.similarityValue , d.disease, d.pubmedid from chemdisease.tmpone t, drugdisease d where t.sourceDrug = d.sourceDrug && t.similarityValue > 0.1 limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
     
echo "<tr>";
echo "<td>".$row['sourceDrug']."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['disease']."</td>";
echo "<td>".$row['pubmedid']."</td>";
echo "<tr>";
    }
	
}
elseif ($checked =='pubchem'){
$query= "delete from chemdisease.tmpone";	
mysql_query($query) or die(mysql_error());
$query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,pubchem from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select sourceDrug,pubchem from chemdisease.drugeffect where targetDrug = '$keyword') order by pubchem desc limit 500";
$query2 = "select t.sourceDrug , t.similarityValue , d.disease, d.pubmedid from chemdisease.tmpone t, drugdisease d where t.sourceDrug = d.sourceDrug && t.similarityValue > 0.1 limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
       
echo "<tr>";
echo "<td>".$row['sourceDrug']."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['disease']."</td>";
echo "<td>".$row['pubmedid']."</td>";
echo "<tr>";
    }
 
}

elseif ($checked =='protein'){
$query= "delete from chemdisease.tmpone";	
mysql_query($query) or die(mysql_error());
$query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,protein from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select sourceDrug,protein from chemdisease.drugeffect where targetDrug = '$keyword') order by protein desc limit 500";
$query2 = "select t.sourceDrug , t.similarityValue , d.disease, d.pubmedid from chemdisease.tmpone t, drugdisease d where t.sourceDrug = d.sourceDrug and t.similarityValue > 0.1 limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
echo "<tr>";
echo "<td>".$row['sourceDrug']."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['disease']."</td>";
echo "<td>".$row['pubmedid']."</td>";
echo "<tr>";
    }
 
}

elseif($checked =='rocs'){
$query= "delete from chemdisease.tmpone";	
mysql_query($query) or die(mysql_error());
$query1 ="insert into chemdisease.tmpone(sourceDrug,similarityValue) (select targetDrug,rocs from chemdisease.drugeffect where sourceDrug = '$keyword') union ( select sourceDrug,rocs from chemdisease.drugeffect where targetDrug = '$keyword') order by rocs desc limit 500";
$query2 = "select t.sourceDrug , t.similarityValue , d.disease, d.pubmedid from chemdisease.tmpone t, drugdisease d where t.sourceDrug = d.sourceDrug && t.similarityValue > 0.1 limit 500";

mysql_query($query1) or die(mysql_error());

	$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
echo "<tr>";
echo "<td>".$row['sourceDrug']."</td>";
echo "<td>".$row['similarityValue']."</td>";
echo "<td>".$row['disease']."</td>";
echo "<td>".$row['pubmedid']."</td>";
echo "<tr>";
    }
}
	 }
	 
	 elseif($N>1){
		 
	     foreach($_POST as $key=>$value)
		{   if (preg_match('/^0.[0-9]$/', (string)$value))
			{
				
                $arraydropdown[$key]=1;
			}
         }
		 $value1=array_values($arraycheckbox);
         $value2=array_values($arraydropdown);
		 
		 $checkboxkeys = array_keys($arraycheckbox);
		 $dropdownkeys = array_keys($arraydropdown);
		  $querystring="";
		for ( $i = 0; $i < count($value1); $i++)
        {   //  echo $value1[$i]."=>".$value2[$i];   
          if ( $value1[$i] == 1 && $value2[$i] == 1 ) {
			//echo "key = " . $checkboxkeys[$i] . "  value = ". $_POST[$dropdownkeys[$i]] . "\n";
			$querystring .= $checkboxkeys[$i]."*".(string)$_POST[$dropdownkeys[$i]]."+";
		  } elseif ( $value1[$i] == 0 && $value2[$i] == 0 ){
			//echo ("<p>select right combination.</p>\n");
			//return;  
		  } else {
			  echo ("<p>select right combination.</p>\n");
			 return;
		  }
        }
	//	echo $querystring;
        $query= "delete from chemdisease.tmpone";         	
         mysql_query($query) or die(mysql_error()); 
		 $q=rtrim($querystring, "+");
		// echo $q;
		 $query1="insert into chemdisease.tmpone(sourceDrug , similarityValue) (select targetDrug,(".$q.") as summation from   
		          chemdisease.drugeffect where sourceDrug='$keyword')  union (select   sourceDrug,(".$q.")as summation from  
				  chemdisease.drugeffect where targetDrug='$keyword')order by summation desc limit 500";
				 mysql_query($query1) or die(mysql_error());
		  
        $query2 ="select t.sourceDrug , t.similarityValue , d.disease , d.pubmedid from chemdisease.tmpone t, drugdisease d where t.sourceDrug = d.sourceDrug limit 500";
		
		$result = mysql_query($query2) or die(mysql_error());
	while ( $row = mysql_fetch_assoc($result) )
    {
          echo "<tr>";
          echo "<td>".$row['sourceDrug']."</td>";
          echo "<td>".$row['similarityValue']."</td>";
          echo "<td>".$row['disease']."</td>";
          echo "<td>".$row['pubmedid']."</td>";
          echo "<tr>";
    }
			  }

}
}
?>

<input value = "Export as CSV" type="button" class="right" onclick="$('#mytable').table2CSV({header:[]})">
</body>
</html>