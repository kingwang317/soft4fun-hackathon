<?php
  $BASE_URL = "https://query.yahooapis.com/v1/public/yql";

     
    // Form YQL query and build URI to YQL Web service
    //$yql_query = "select * from upcoming.events where location='$location' and search_text='$query'";
	$yql_query = "SELECT * FROM yahoo.taiwan.search.ec (1, 100) WHERE keyword='zenfone 6' and property='shopping' and sortBy='price' and sortOrder='asc' and filters='ship_fast'";
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";

    // Make call with cURL
	//echo $yql_query_url;      
	
	$result = file_get_contents ($yql_query_url, "r");
	$phpObj =  json_decode($result);

	var_dump($phpObj);
	
 
?>