<?php

	require('conf.php');
	global $api_request_count;
	global $api_request_limit;
	//=========================================================
	function get_url_content($url, $post, $kernal = false){
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);
		curl_close ($ch);
		
		// 如果 API Token 過期，更新 Token 
		if ($kernal == false){
			if (check_api_result($result) == false){
				user_get_token();
				//$result = get_url_content($url, $post);
			}
		}
		
		
		return $result;
	}	
	
	function check_api_result($result){
		
		if(isset($result)){
			$result = json_decode($result);
			
			if ($result->message == 'token invalid or expire')	return false;
			
			return true;
		}
		
		return true;
	}
	
	//=========================================================
	
	/*
		=======================================================
		USER
		=======================================================
	*/

	function user_get_token(){
		
		$url = SER_API_URL . 'user/get_token';
	
		$post = array(
			'id' 			=> API_CODE_ID,
			'secret_key' 	=> SECRET_ID
		);
		
		$result = get_url_content($url, $post, true);
		$token = '';
		//var_dump($result);
		if($result){
			$decode_obj = json_decode($result);
			$token = $decode_obj->result->token;
		}
		
		//echo 'token=' . $token;
		
		$fp = fopen('./api/token.php', 'w');
		fwrite($fp, "<?php define('SER_TOKEN', '$token');?>");
		fclose($fp);
		
		include('./api/token.php');
		
		return 'cannot fetch token';

	}

	/*
		=======================================================
		TOP Article 熱門文章
		=======================================================
		
	*/
	
	// PTT
	// PTT 看板列表：http://api.ser.ideas.iii.org.tw/docs/ptt_board_list.html
	function top_article_ptt($board = '', $period = 30, $limit = '100'){
		$url = SER_API_URL . 'top_article/ptt';
	
		$post = array(
			'period' 	=> $period,
			'limit' 	=> $limit,
			'board'		=> $board,
			'token'		=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);

		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// Facebook
	// type = like, comments, share
	function top_article_facebook($page_id_name = '', $type = 'likes', $period = '30', $limit = '100'){
		$url = SER_API_URL . 'top_article/facebook';
	
		$post = array(
			'type' 			=> $type,
			'period' 		=> $period,
			'limit'			=> $limit,
			'page_id_name'	=> $page_id_name,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// 論壇
	// 論壇列表：http://api.ser.ideas.iii.org.tw/docs/forum_list.html
	function top_article_forum($forum = '', $period = '30', $limit = 100){
		$url = SER_API_URL . 'top_article/forum';
	
		$post = array(
			'forum' 		=> $forum,
			'period' 		=> $period,
			'limit'			=> $limit,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	/*
		=======================================================
		關鍵字搜尋
		
		排序：
			time_desc : 最新文章在前
			time_asc : 最舊文章在前
			board : 依照看板排序
			title : 依照標題排序
			push : 依照推文數排序
		=======================================================
	*/
	
	// PTT 標題
	function kw_ptt_title($keyword = '', $limit = 100, $page = 1, $push = 0, $sort='time_desc'){
		$url = SER_API_URL . 'keyword_search/ptt/title';
	
		$post = array(
			'keyword' 		=> $keyword,
			'page'			=> $page,
			'limit'			=> $limit,
			'push'			=> $push,
			'sort'			=> $sort,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// PTT 內容
	function kw_ptt_content($keyword = '', $limit = 100, $page = 1, $push = 0, $sort='time_desc'){
		$url = SER_API_URL . 'keyword_search/ptt/content';
	
		$post = array(
			'keyword' 		=> $keyword,
			'page'			=> $page,
			'limit'			=> $limit,
			'push'			=> $push,
			'sort'			=> $sort,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// 論壇文章標題
	function kw_forum_title($keyword = '', $limit = 100, $page = 1, $reply = 0, $sort='time_desc'){
		$url = SER_API_URL . 'keyword_search/forum/title';
	
		$post = array(
			'keyword' 		=> $keyword,
			'page'			=> $page,
			'limit'			=> $limit,
			'reply'			=> $reply,
			'sort'			=> $sort,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// 論壇文章內容
	function kw_forum_content($keyword = '', $limit = 100, $page = 1, $reply = 0, $sort='time_desc'){
		$url = SER_API_URL . 'keyword_search/forum/content';
	
		$post = array(
			'keyword' 		=> $keyword,
			'page'			=> $page,
			'limit'			=> $limit,
			'reply'			=> $reply,
			'sort'			=> $sort,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// FB 塗鴉牆
	function kw_facebook($keyword = '', $limit = 100, $page = 1, $comments = 0, $likes = 0, $shares = 0, $sort='time_desc'){
		$url = SER_API_URL . 'keyword_search/facebook';
	
		$post = array(
			'keyword' 		=> $keyword,
			'limit'			=> $limit,
			'page'			=> $page,
			'comments'		=> $comments,
			'likes'			=> $likes,
			'shares'		=> $shares,
			'sort'			=> $sort,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// 新聞標題
	function kw_news_title($keyword = '', $limit = 100, $page = 1, $reply = 0, $sort='time_desc'){
		$url = SER_API_URL . 'keyword_search/news/title';
	
		$post = array(
			'keyword' 		=> $keyword,
			'page'			=> $page,
			'limit'			=> $limit,
			'reply'			=> $reply,
			'sort'			=> $sort,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// 新聞內容
	function kw_news_content($keyword = '', $limit = 100, $page = 1, $reply = 0, $sort='time_desc'){
		$url = SER_API_URL . 'keyword_search/news/content';
	
		$post = array(
			'keyword' 		=> $keyword,
			'page'			=> $page,
			'limit'			=> $limit,
			'reply'			=> $reply,
			'sort'			=> $sort,
			'token'			=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	/*
		=======================================================
		taobao : 淘寶食品類商品分析
		=======================================================
	*/
	
	// 查詢熱門分類產品
	function taobao_topitem($datestr, $cat){
		$url = SER_API_URL . 'taobao/topitem';
	
		$post = array(
			'date' 	=> $datestr,
			'cat'	=> $cat,
			'token'	=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	
	}
	
	// 查詢熱門分類產品
	function taobao_topcat($datestr){
		$url = SER_API_URL . 'taobao/topcat';
	
		$post = array(
			'date' 	=> $datestr,
			'token'	=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	// 淘寶 5 日商品銷售數字
	function taobao_item_daily_sell($item_id){
		$url = SER_API_URL . 'taobao/item_daily';
	
		$post = array(
			'item_id' 	=> $item_id,
			'token'		=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
	
	
	// 淘寶農產品關鍵字搜尋
	function taobao_keyword($keyword){
		$url = SER_API_URL . 'taobao/keyword_search';
	
		$post = array(
			'keyword' 	=> $keyword,
			'token'		=> SER_TOKEN
		);
		
		$result = get_url_content($url, $post);
		//var_dump($result);
		
		if($result){
			$decode_obj = json_decode($result);
			return $decode_obj->result;
		}
		
		return 'cannot fetch result';
	}
?>