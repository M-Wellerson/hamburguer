<?php
 
    $user = "upsitenetbr";
    $pass = "up@004krd";
    $secret = "2X7VKCZOT646VPIEJBS92JJG2UDNOV25"; 
    $base_url  = 'https://upsite.net.br:2083';
    $login_url = $base_url . '/login';
    $cookie_jar = 'cookie.txt';

    $params = array(
        'user' => $user,
        'pass' => $pass,
    );
    
    $login_request = curl_init();                               
    curl_setopt($login_request, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($login_request, CURLOPT_SSL_VERIFYHOST, false); 
    curl_setopt($login_request, CURLOPT_HEADER, true);          
    curl_setopt($login_request, CURLOPT_RETURNTRANSFER, true);  
    curl_setopt($login_request, CURLOPT_POST, true);            
    curl_setopt($login_request, CURLOPT_POSTFIELDS, $params);   
    curl_setopt($login_request, CURLOPT_COOKIEJAR, $cookie_jar);
    curl_setopt($login_request, CURLOPT_URL, $login_url);       
    $result = curl_exec($login_request);
    if (!$result) {
        error_log("curl_exec threw error \"" . curl_error($login_request) . "\" for $login_url");
    }
    curl_close($login_request);
    
    $found_location = preg_match("/cpsess\d+/i", $result, $matches);
    if (!$found_location) {
        error_log("Could not find the security token.");
        die;
    }

    $addDominio = $_REQUEST['dominio'] ?? 'sos';
    
    $endPoints = [
        "/execute/Email/list_pops",
        "/execute/DomainInfo/list_domains",
        "/execute/SubDomain/addsubdomain?domain={$addDominio}&rootdomain=upsite.net.br&dir=/home/upsitenetbr/public_html&disallowdot=1"
    ];

    if( !empty( $_REQUEST['dominio'] ) ) {
        $security_token = $matches[1];
    }else {
        $security_token = $matches[0];
    }


    $api_url = $base_url . '/' . $security_token . $endPoints[1];
    
    $api_request = curl_init();
    curl_setopt($api_request, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($api_request, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($api_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api_request, CURLOPT_POST, true);
    curl_setopt($api_request, CURLOPT_COOKIEFILE, $cookie_jar); // Send the cookie file with our request
    curl_setopt($api_request, CURLOPT_URL, $api_url);
    $api_result = curl_exec($api_request);
    if (!$api_result) {
        error_log("curl_exec threw error \"" . curl_error($api_request) . "\" for $api_url");
    }
    curl_close($api_request);
    
    print $api_result;
