<?php
	
	// 搜尋 Yahoo 商城商品
	function yahoo_search_item($keyword='', $price_sort='asc',$num = 1){
		$yql_query = "SELECT * FROM yahoo.taiwan.search.ec (1, $num) WHERE keyword='$keyword' and 
						property='shopping' and sortBy='price' and sortOrder='$price_sort' and filters='ship_fast'";
		$yql_query_url = YQL_API_URL . "?q=" . urlencode($yql_query) . "&format=json";
		
		$result = file_get_contents ($yql_query_url, "r");
		$json_obj =  json_decode($result);
		
		return $json_obj;
	}
	
	// 取得 YAHOO EC 相關產品
	// match_type：相似產品(VV)、互補性or配件(bb)、相關性高(vb)
	function yahoo_get_relate_item($prod_id='', $match_type='vv'){
		$yql_query = "SELECT * FROM yahoo.taiwan.lyre-item WHERE prop='shopping' AND cid='$prod_id' AND model='$match_type'";
		$yql_query_url = YQL_API_URL . "?q=" . urlencode($yql_query) . "&format=json";
		
		$result = file_get_contents ($yql_query_url, "r");
		$json_obj =  json_decode($result);
		
		return $json_obj;
	}

?>