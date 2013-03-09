<?php
require_once('/inc/database.php'); 
if ( isset($_GET) && isset($_GET['srch_for']) )
{
    $effectsWhereClause = '';

    if ( ! empty($_GET['side effect']) )
    {
        $effectsToSearch = is_array($_GET['side effect']) ;
		    foreach ( $effectsToSearch as &$effect )
        {
                // prevent sql injection
            $effect = mysql_real_escape_string($effect);
        }
        // add all values to an 'IN' clause
        $effectsWhereClause = "sourceDrug IN ('" . implode("', '", $effectsToSearch) . "')";
    }

    if ( empty($effectsWhereClause) )
    {
        $effectsWhereClause = '1';
    }

    $found = array();
    // build the final query
    $sql = 'SELECT * FROM drugeffect WHERE ' . $effectsWhereClause;
    $result = mysql_query($sql);

    while ( $row = mysql_fetch_assoc($result) )
    {
        $found[] = $row;
    }

    var_dump($found);
}


?>