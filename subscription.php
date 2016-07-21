<?php
   /* Work Flow
    * 1. Check if the subscription exists.
    * 2a. If if does exist, retrieve subscription_id.
    * 2b. If it does NOT exist, skip.
    * 3a. Edit the subscription and add to the new list.
    * 3b. Add new subscription to list.
    */

    include "request_rest.php";
   
    $request_url = "http://api.trumpia.com/rest/v1/vuskeedoo/subscription"; // replace {username} (case sensitive)
    
    // Add a subscription
    $request_data = array(
		"list_name" => "listname0001",
		"subscriptions" => array(
			array(
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "email" => $_POST['email'],
                "mobile" => array("number" => $_POST['mobile_number'], "country_code" => "1"),
                "voice_device" => "mobile"
                /*"customdata" => array( // include this array to add custom data fields
                    array(
                        "customdata_id" => "987987987989",
                        "value" => "Customdata value",
                    )
                )*/
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
    
   
   
   
   /*  //subscription search GET


    $request_url = "http://api.trumpia.com/rest/v1/{username}/subscription/search?"; // replace {username} (case sensitive)
    $search_type = "1";
    $search_data = $_POST["mobile_number"]; // search mobile number
    $search_data = "subscriber_email0001@trumpia.com";
    $list_id = "987987987980";
    $request_url =    $request_url . "search_type=" . $search_type . "&search_data=" . $subscription_id . "&list_id=" . $list_id;

    $request_rest = new RestRequest();

    $request_rest->setRequestURL($request_url);
    $request_rest->setAPIKey("{apikey}"); // replace {apikey} with assigned API key
    $request_rest->setMethod("GET");
    $result = $request_rest->execute();

    $response_status = $result[0];
    $json_response_data = $result[1];

    // creates text file and logs the API response
    $file = "ResponseLog.txt";
    $stringToLog =  $json_response_data . " " . date("m/d/Y h:i:sa") . "\r\n" ;
    
    if ($response_status == "200") {    //success
        $stringToLog = "GET Search Subscription " . $stringToLog;
    } else {
        $stringToLog = "Connection failure " . $stringToLog;
    }
    
    echo $json_response_data;
    $fh = file_put_contents($file, $stringToLog, FILE_APPEND);
    fclose($fh); */
?>
