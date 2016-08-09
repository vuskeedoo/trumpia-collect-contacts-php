<?php
   /* Work Flow
    * 1. Check if the subscription exists.
    * 2a. If if does exist, retrieve subscription_id.
    * 2b. If it does NOT exist, skip.
    * 3a. Edit the subscription and add to the new list.
    * 3b. Add new subscription to list.
    */
include "request_rest.php";
    
function subscription($firstName, $lastName, $mobileNumber, $email) {
    	
	$getSubscriptionReturn = getSubscription($firstName, $lastName, $mobileNumber, $email);    
	$subscription_id = $getSubscriptionReturn['subscription_id_list'][0];
	$error_message = $getSubscriptionReturn['error_message'];
	
	error_log($subscription_id);
	error_log("subscription_id");
	error_log($error_message);
	error_log("error message");
	
	// it exists, post subscription
	if(!is_null($subscription_id) && !empty($subscription_id)) {
		$postSubscriptionReturn = postSubscription($firstName, $lastName, $mobileNumber, $email, $subscription_id);
		error_log("postsub");
		return $error_message = NULL;
	}
	
	// doesnt exist, put subscription
    if(!is_null($error_message) && !empty($error_message)) {
		putSubscription($firstName, $lastName, $mobileNumber, $email);
		error_log("putsub");
		return;
	}
	return;
}
    
function getSubscription($firstName, $lastName, $mobileNumber, $email) {
	$request_url = "http://api.trumpia.com/rest/v1/vuskeedoo/subscription/search?"; // replace {username} (case sensitive)
	$search_type = "2";
	$search_data = $mobileNumber;
	$list_id = "1623799";
	$request_url =    $request_url . "search_type=" . $search_type . "&search_data=" . $search_data . "&list_id=" . $list_id;

	$request_rest = new RestRequest();
	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey("7f5a72d074cff3222bfa0b079af236fc"); // replace {apikey} with assigned API key
	$request_rest->setMethod("GET");
	$result = $request_rest->execute();

	$response_status = $result[0];
	$json_response_data = $result[1];
	    
	// decode json
	$json_data = json_decode($json_response_data, true);
	
	error_log($request_url);
	error_log("get subscription");
	
	return $json_data;
}


function putSubscription($firstName, $lastName, $mobileNumber, $email) {
	$request_url = "http://api.trumpia.com/rest/v1/vuskeedoo/subscription"; // replace {username} (case sensitive)
	    
	// Add a subscription
	$request_data = array(
		"list_name" => "Heroku",
		"subscriptions" => array(
			array(
		"first_name" => $firstName,
		"last_name" => $lastName,
		"email" => $email,	
			"mobile" => array("number" => $mobileNumber, "country_code" => "1"),
	        "voice_device" => "mobile"
	        )
		)
	);
	    
	$request_rest = new RestRequest();

	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey("7f5a72d074cff3222bfa0b079af236fc"); // replace {apikey} with assigned API key
	$request_rest->setRequestBody(json_encode($request_data));
	$request_rest->setMethod("PUT");
	$result = $request_rest->execute();

	$response_status = $result[0];
	$json_response_data = $result[1];
	    
	//decode json into string
	$json_data = json_decode($json_response_data, true);
	$request_id = $json_data['request_id'];
	$error_message = $json_data['error_message'];
	
	error_log("put error");
	error_log($error_message);
	error_log("put id");
	error_log($request_id);
	    
	getReport($request_id);
	    
}
	    
function postSubscription($firstName, $lastName, $mobileNumber, $subscription_id) {
	$request_url = "http://api.trumpia.com/rest/v1/vuskeedoo/subscription"; // replace {username} (case sensitive)
	$request_url = $request_url. "/". $subscription_id;
	
	$request_data = array(
		"list_name" => "Heroku",
		"subscriptions" => array(
			array(
				"first_name" => $firstName,
				"last_name" => $lastName,
				"email" => "$email",
				"mobile" => array($mobileNumber, "country_code" => "1"),
				"voice_device" => "mobile"
			)
		)
);
	    
	$request_rest = new RestRequest();
	    
	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey("7f5a72d074cff3222bfa0b079af236fc"); // replace {api_key} with assigned API Key
	$request_rest->setRequestBody(json_encode($request_data));
	$request_rest->setMethod("POST");
	$result = $request_rest->execute();
	    
	$response_status = $result[0];
	$json_response_data = $result[1];
}
	    
function getReport($request_id) {
	$request_url = "http://api.trumpia.com/rest/v1/vuskeedoo/report"; // replace {username} (case sensitive)
	$request_url =    $request_url . "/" . $request_id;
		
	$request_rest = new RestRequest();
		
	$request_rest->setRequestURL($request_url);
	$request_rest->setAPIKey("7f5a72d074cff3222bfa0b079af236fc"); // replace {apikey} with assigned API key
	$request_rest->setMethod("GET");
	$result = $request_rest->execute();
		
	$response_status = $result[0];
	$json_response_data = $result[1];
		    
	// decode json into string
	$json_data = json_decode($json_response_data, true);
	$error_message = $json_data['error_message'];
	$subscription_id = $json_data['subscription_id'];
		
	error_log("get report error");
	error_log($error_message);
}
?>
