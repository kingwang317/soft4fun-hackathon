<?php  
function curl_download($Url,$encode="UTF-8"){
 
    // is cURL installed yet?
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
 
    // OK cool - then let's create a new cURL resource handle
    $ch = curl_init();
 
    // Now set some options (most are optional)
	$this_header = array(
	"content-type: application/x-www-form-urlencoded; 
	charset=$encode"
	);
	//$proxy_server = "220.130.119.253:443";
	//$proxy_server = " 218.210.199.254:80";
	//$proxy_server = "124.127.40.129:8080";
	//curl_setopt($ch, CURLOPT_PROXY, $proxy_server);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
    
    curl_setopt ( $ch, CURLOPT_COOKIEFILE, getcwd () . '/cookies_ptt.cookie' );
    curl_setopt ( $ch, CURLOPT_COOKIEJAR, getcwd () . '/cookies_ptt.cookie' );
    // Set a referer
    curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com.tw/");
 
    // User agent
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.6 (KHTML, like Gecko) Chrome/16.0.897.0 Safari/535.6');
 
    // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);
 
    // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	
	curl_setopt($ch, CURLOPT_ENCODING, $encode);


 
    // Download the given URL, and return output
    $output = curl_exec($ch);
	
	
 
    // Close the cURL resource, and free system resources
    curl_close($ch);
 
    return $output;
}
?>  
