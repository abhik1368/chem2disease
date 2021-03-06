<?php
require_once('database.php'); 
mysql_select_db("semanticweb",$conndb);
//include_once("analyticstracking.php")
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Repurposing</title>
<meta name="description" content="Advanced Search Form" />
<meta name="keywords" content="Advanced Search Form" />
<meta http-equiv="imagetoolbar" content="no" />
<link href="style/core.css" rel="stylesheet" type="text/css" />


<script type ="text/javascript" src="jquery.js"></script>
<script type ="text/javascript" src="autosuggest.js"></script>
<script type ="text/javascript" src="analysis.js"></script>
<style type="text/css">

input#srch_for{
  width: 100%;	
}



#suggestions {
  text-align: left;
   padding-left: 3px;  	
	
	}

#link:hover{
	 background-color: #f0f0f0;
	 cursor: default; 
	
	}
</style>

</head>
<body>
<div id="out">
  <div id="ph">
    
    <div id="phin">
     <center>
      <h1>Drug Repurposing Explorer</h1>
      <h3>Integrative searching tool for Drug Repurposing and searching Similar Drugs</h3>
      </center>
      
    </div>
   </div>
  <div id="wr">
    <div id="hd"></div>
    <div id="cnt">
      <h2>Search for Similar Drugs</h2>
      <p>&nbsp;</p>
      <form id="Search_from" name="Search_from" method="post" action="process3.php">
        <table width="120%" height="194" border="0" cellpadding="2">
          <tr>
            <th width="40%" height="134" scope="row"><p><em>
              <label for ="srch_for"><strong>Search for Drugs:</strong></label>
                </em></p>
              <p> 
                <input name="srch_for" type="text" class="f_fld" id="srch_for" onblur = "setTimeout('removeSuggestions()',300);" autocomplete="on" value="" size="80" onkeyup="getSuggestions(this.value);" />
              </p>
              <div id ="suggestions"></div>
            </p></th>
            
            <th width="70%"><p>
              <label for = "srch_se">
                <br />
                <input type="checkbox" name="search[]" id="sideEffect" value="sideEffect"/>
                SIDE EFECT :</label>
              <select name="sideEffect" size="1" id="select">
                <option value="select">select</option>
                <option value="0.1">0.1</option>
                <option value="0.2">0.2</option>
                <option value="0.3">0.3</option>
                <option value="0.4">0.4</option>
                <option value="0.5">0.5</option>
                <option value="0.6">0.6</option>
                <option value="0.7">0.7</option>
                <option value="0.8">0.8</option>
                <option value="0.9">0.9</option>
              </select>  
              <label for ="srch_ecfp">
                <input type="checkbox" name="search[]" id="ECFP6" value="ECFP6"/>
                ECFP6 :</label> 
              <select name="ECFP6" size="1" id="select2">
                <option value="select">select</option>
                <option value="0.1">0.1</option>
                <option value="0.2">0.2</option>
                <option value="0.3">0.3</option>
                <option value="0.4">0.4</option>
                <option value="0.5">0.5</option>
                <option value="0.6">0.6</option>
                <option value="0.7">0.7</option>
                <option value="0.8">0.8</option>
                <option value="0.9">0.9</option>
              </select>    
              <label for ="srch_pub"> 
                <input type="checkbox" name="search[]" id="pubchem" value="pubchem"/>
                Pubchem :</label>
              <select name="pubchem" size="1" id="select3">
                <option value="select">select</option>
                <option value="0.1">0.1</option>
                <option value="0.2">0.2</option>
                <option value="0.3">0.3</option>
                <option value="0.4">0.4</option>
                <option value="0.5">0.5</option>
                <option value="0.6">0.6</option>
                <option value="0.7">0.7</option>
                <option value="0.8">0.8</option>
                <option value="0.9">0.9</option>
              </select>    
              <label for ="srch_prot">
                <br />
                <br />
                <input type="checkbox" name="search[]" id="protein" value="protein"/>
                Proteins:    </label>
              <select name="protein" size="1" id="select4">
                <option value="select">select</option>
                <option value="0.1">0.1</option>
                <option value="0.2">0.2</option>
                <option value="0.3">0.3</option>
                <option value="0.4">0.4</option>
                <option value="0.5">0.5</option> 
                <option value="0.6">0.6</option>
                <option value="0.7">0.7</option>
                <option value="0.8">0.8</option>
                <option value="0.9">0.9</option>
              </select>    
              <label for ="srch_rocs">  
                <input type="checkbox" name="search[]" id="rocs" value="rocs"/>
                ROCS(3D Shape and Color):</label>
              <select name="rocs" size="1" id="select5">
                <option value="select">select</option>
                <option value="0.1">0.1</option>
                <option value="0.2">0.2</option>
                <option value="0.3">0.3</option>
                <option value="0.4">0.4</option>
                <option value="0.5">0.5</option>
                <option value="0.6">0.6</option>
                <option value="0.7">0.7</option>
                <option value="0.8">0.8</option>
                <option value="0.9">0.9</option>
              </select>            
            </p>
              <p>
                <label>
                  <input type="checkbox" name="disease" id="disease" />
                  Disease</label>
              </p>
          </tr>
  <tr>
    <th colspan="2" align="center" bgcolor="#CCCCCC" scope="row"> <label for ="btn" class ="sbm fl_r">
      <input type ="submit" name ="submit" id ="btn" value ="search" />
      </label>
    </tr>
  </table>

    </form>
</div> 
  </div>
</div>     
  
<div id="ft">
  <div id="ftin">
   <center> <p>Drug Repurposing Explorer:</a> Designed and Implemented by <a href="http://mypage.iu.edu/~abseal/">Abhik Seal</a>,Sandip Nandi</p></center>
   <center>Project Members :Abhik Seal,Sandip Nandi,Patrick Ridout,Terrence Ellison,<a href="http://info.slis.indiana.edu/~dingying/">Ying Ding,<a href= "http://djwild.info">David J Wild</a></center>
   <p> 
   <center><a href="comment.html" style="text-decoration:underline" color="blue">Comments</a>
    <a href= "http://cheminfov.informatics.indiana.edu/chem2disease/Manual.pdf" style="text-decoration:underline" color="blue">Manual</a>
    </center>
</p> 
    <center>
   <img src=" ctd.png"  width="50" height="40"> 
   <img src="sider.png"  width="80" height="40"> 
   <img src="drugbank.jpg"  width="80" height="40">
   <img src="php.png" width="70" height="40">
   <img src="mysql-logo.jpg"  width="70" height="40">
   <img src ="openeye.jpg"  width="70" height="40" />
   <img src ="cdk.jpg" width="70" height="40"/>
   <h4><p>Note: If you have used Drug repurposing explorer for your research and have good results please cite the website link</p></h4>
  
  </center> 
  </div>
</div>      
</body>
</html>