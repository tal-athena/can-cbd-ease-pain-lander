<?php

//Includes
//require_once('settings.php');
require_once('../settings.php');
require_once('functions.php');

$amt = $_POST['pptotal'];

if(isset($_GET['get_paypal_provider']) && $_GET['get_paypal_provider'] == 1) {

    $query_string               = '?'.$_SERVER['QUERY_STRING'];
    $next_page_query_string     = str_replace('get_paypal_provider=1','get_paypal_provider=2',$query_string);
    $campaign_id                = $site->order->product_pp_campaign_id;
    $next_page                  = $_SERVER['SCRIPT_URI'].$next_page_query_string;
    $this_page                  = 'https://'.$_SERVER['HTTP_HOST'].'/'.$site->order->this_page.$query_string;
//    $amount                     = $site->order->paypal_total; 
	$amount                     = $amt;
    $products                   = $site->order->product_product_id;
    $product_qty                = '1';
    
    $response = GetAlternativeProviderLimelight(
                    'paypal',
                    $campaign_id,
                    $next_page,
                    $this_page,
                    $amount,
                    $products,
                    $product_qty);
    
    //echo "<pre>"; print_r($_SERVER); die();
    
    header("Location: ".urldecode($response['redirect_url']));
    exit();
    die('done with pp');
    
} else if(isset($_GET['get_paypal_provider']) && $_GET['get_paypal_provider'] == 2) {
    
    $pp_response = GetExpressCheckoutDetailsPaypal($_GET['token']);
    
    //Define variables
    global $site; 
    $stepNumber = '';
	$AFID = ''; 
    $AFFID = ''; 
    $SID = ''; 
    $C1 = ''; 
    $C2 = ''; 
    $C3 = ''; 
    $AID = ''; 
    $OPT = ''; 
    $CLICK_ID = '';

    //Set variables with post data
    if(!empty($_GET['step_number'])) {
		$stepNumber = $_GET['step_number'];
	}
    else {
        $stepNumber = '1';
    }
	if(!empty($_GET['AFID'])) {
		$AFID = $_GET['AFID'];
	}
	if(!empty($_GET['SID'])) {
		$SID = $_GET['SID'];
	}
	if(!empty($_GET['AFFID'])) {
		$AFFID = $_GET['AFFID'];
	}
	if(!empty($_GET['C1'])) {
		$C1 = $_GET['C1'];
	}
	if(!empty($_GET['C2'])) {
		$C2 = $_GET['C2'];
	}
	if(!empty($_GET['C3'])) {
		$C3 = $_GET['C3'];
	}
	if(!empty($_GET['AID'])) {
		$AID = $_GET['AID'];
	}
	if(!empty($_GET['OPT'])) {
		$OPT = $_GET['OPT'];
	}
	else if(!empty($_GET['click_id'])) {
		$CLICK_ID = $_GET['click_id'];
	}
    if(!empty($_GET['CLICK_ID'])) {
		$CLICK_ID = $_GET['CLICK_ID'];
	}
    
	$notes = json_encode($pp_response);
    
    $campaign_id                = $site->order->product_pp_campaign_id;
    $prospectId                 = $_GET['prospect_id'];
    $alt_pay_token              = $pp_response['TOKEN'];
    $alt_pay_payer_id           = $pp_response['PAYERID'];
    $productId                  = $site->order->product_product_id;
    $shippingId                 = $site->order->product_shipping_id;
    $upsellCount                = 0; //0 if all orders are initial sales. 1 if there are bonafied upsells
    $product_qty                = 1;
    $custom_product_price       = $site->order->product_price;
    
    
    $order = NewPPOrderWithProspectLimelight(
                                           $campaign_id,
                                           $prospectId,
                                           $alt_pay_token,
                                           $alt_pay_payer_id,
                                           $productId,
                                           $shippingId,
                                           $upsellCount,
                                           $product_qty,
                                           $custom_product_price,
                                           $AFID,
                                           $SID,
                                           $AFFID,
                                           $C1,
                                           $C2,
                                           $C3,
                                           $AID,
                                           $OPT,
                                           $CLICK_ID,
                                           $notes);
    
    //echo "<pre>"; print_r($order); die();
    
    $ret = explode('&',$order);
	//Get the decline reason
	$decline = explode("=",$ret[2]);
	//Check if a prepaid card was declined
	$pppos = strpos($decline[1], "Prepaid");
    
    //Determine how to proceed
    if( !empty($ret[1]) && $ret[1] == 'responseCode=100' ) {

		$exp = explode("=",$ret[5]);
		$data = array();
		foreach($ret AS $key => $value){
			$newValues = @explode('=',$value);
			$data[$newValues[0]] = $newValues[1];
		}
        //Save the order id 
        $_SESSION['step'.$stepNumber.'_orderId'] = $data['orderId'];
        setcookie('order_id', $data['orderId'], time() + 2592000, "/");
        
        //Success. Proceed to the next page
        $query_string = '?'
            .'order_id='.$data['orderId']
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3;
        
        header('Location: /'.$site->order->next_page.$query_string);
        exit();
	} else {
        $data = array();
        foreach($ret AS $key => $value){
            $newValues = @explode('=',$value);
            $data[$newValues[0]] = $newValues[1];
        }
        $errorMessage = urldecode($data['errorMessage']);
        
        $query_string = '?'
            .'prospectId='.$prospectId
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&error='.urlencode($errorMessage);
        
        header('Location: /'.$site->order->this_page.$query_string);
        exit();
    }
    /*
    echo "<pre>";
    print_r($response);
    die('done with pp2');
    */
    
} else if( !empty($_POST['prospect_id']) || !empty($_POST['card_number']) || !empty($_SESSION['prospect_id']) || !empty($_COOKIE['prospect_id'])) {
    
    //Define order ids. Loop through existing ones to continously append to querystring
    /*
    $orderIds = array();
    foreach($steps as $step => $object) {
        if(isset($_SESSION[$step.'_orderId']) && $_SESSION[$step.'_orderId']!='') {
            $orderIds[$step] = $_SESSION[$step.'_orderId'];
        }
    }
    */
    
    //Define variables
    global $site; 
    $stepNumber = '';
	$AFID = ''; 
    $AFFID = ''; 
    $SID = ''; 
    $C1 = ''; 
    $C2 = ''; 
    $C3 = ''; 
    $AID = ''; 
    $OPT = ''; 
    $CLICK_ID = '';

    //Set variables with post data
    if(!empty($_POST['step_number'])) {
		$stepNumber = $_POST['step_number'];
	}
    else {
        $stepNumber = '1';
    }
	if(!empty($_POST['AFID'])) {
		$AFID = $_POST['AFID'];
	}
	if(!empty($_POST['SID'])) {
		$SID = $_POST['SID'];
	}
	if(!empty($_POST['AFFID'])) {
		$AFFID = $_POST['AFFID'];
	}
	if(!empty($_POST['C1'])) {
		$C1 = $_POST['C1'];
	}
	if(!empty($_POST['C2'])) {
		$C2 = $_POST['C2'];
	}
	if(!empty($_POST['C3'])) {
		$C3 = $_POST['C3'];
	}
	if(!empty($_POST['AID'])) {
		$AID = $_POST['AID'];
	}
	if(!empty($_POST['OPT'])) {
		$OPT = $_POST['OPT'];
	}
	else if(!empty($_POST['click_id'])) {
		$CLICK_ID = $_POST['click_id'];
	}
    if(!empty($_POST['CLICK_ID'])) {
		$CLICK_ID = $_POST['CLICK_ID'];
	}
	if(!empty($_POST['notes'])) {
		$notes = $_POST['notes'];
	}
    
    $firstName                  = (isset($_POST['firstName']) ? $_POST['firstName'] : '');
    $lastName                   = (isset($_POST['lastName']) ? $_POST['lastName'] : '');
    $firstName                  = (isset($_POST['firstName']) ? $_POST['firstName'] : '');
    $address1                   = (isset($_POST['address1']) ? $_POST['address1'] : '');
    $address2                   = (isset($_POST['address2']) ? $_POST['address2'] : '');
    $city                       = (isset($_POST['city']) ? $_POST['city'] : '');
    $state                      = (isset($_POST['state']) ? $_POST['state'] : '');
    $country                    = (isset($_POST['country']) ? $_POST['country'] : '');
    $zip                        = (isset($_POST['zip']) ? $_POST['zip'] : '');
    $phone                      = (isset($_POST['phone']) ? $_POST['phone'] : '');
    $email                      = (isset($_POST['email']) ? $_POST['email'] : '');
    $phone                      = (isset($_POST['phone']) ? $_POST['phone'] : '');
    $cc_type                    = (isset($_POST['card_type']) ? $_POST['card_type'] : '');
    $cc_number                  = (isset($_POST['card_number']) ? $_POST['card_number'] : '');
    $cc_cvv                     = (isset($_POST['cvv']) ? $_POST['cvv'] : '');
    $expirationDate             = (isset($_POST['exp_month']) ? $_POST['exp_month'].$_POST['exp_year'] : '');
    $notes                      = (isset($_POST['notes']) ? $_POST['notes'] : '');
    $sessionId					= (isset($_POST['sessionId'])) ? $_POST['sessionId'] : '';

    $prospectId                 = $_POST['prospect_id'];
    $campaign_id                = $_POST['campaign_id'];
    $prepaid_campaign_id        = 0; //$site->order->product_prepaid_campaign_id
    $productId                  = $_POST['product_id'];
    $custom_product_price       = $_POST['product_price'];
    $shippingId                 = $_POST['shipping_id'];
    $fields_expmonth            = $_POST['exp_month'];
    $fields_expyear             = $_POST['exp_year'];
    $billingSameAsShipping      = $_POST['billingSameAsShipping'];
    $product_qty                = 1;
    $upsellCount                = 0; //0 if all orders are initial sales. 1 if there are bonafied upsells
    $upsellId                   = 0; 
    $next_page 					= $_POST['next_page'];
    $this_page 					= $_POST['this_page'];
    
    
    //Billing Address Logic
    if($billingSameAsShipping == 'NO') {
        $billing_first_name = $_POST['billing_first_name'];
        $billing_last_name  = $_POST['billing_last_name'];
        $billing_address    = $_POST['billing_address'];
        $billing_city       = $_POST['billing_city'];
        $billing_state      = $_POST['billing_state'];
        $billing_zip        = $_POST['billing_zip'];
        $billing_country    = $_POST['billing_country'];
        $_SESSION['billingSameAsShipping'] = 'NO';
        $_SESSION['billing_first_name'] = $_POST['billing_first_name'];
        $_SESSION['billing_last_name']  = $_POST['billing_last_name'];
        $_SESSION['billing_address']    = $_POST['billing_address'];
        $_SESSION['billing_city']       = $_POST['billing_city'];
        $_SESSION['billing_state']      = $_POST['billing_state'];
        $_SESSION['billing_zip']        = $_POST['billing_zip'];
        $_SESSION['billing_country']    = $_POST['billing_country'];
    }
    else {
        $billing_first_name = '';
        $billing_last_name  = '';
        $billing_address    = '';
        $billing_city       = '';
        $billing_state      = '';
        $billing_zip        = '';
        $billing_country    = '';
    }
    
    
    //Submit the order to Limelight
    if(isset($_POST['prospect_id']) && $stepNumber == '1') {
	    //die('order from prospect - '.$_POST['prospect_id']);
    $order = NewOrderWithProspectLimelight(
                                           $campaign_id,
                                           $prospectId,
                                           $cc_type,
                                           $cc_number,
                                           $expirationDate,
                                           $cc_cvv,
                                           $productId,
                                           $shippingId,
                                           $upsellCount,
                                           $billingSameAsShipping,
                                           $product_qty,
                                           $custom_product_price,
                                           $AFID,
                                           $SID,
                                           $AFFID,
                                           $C1,
                                           $C2,
                                           $C3,
                                           $AID,
                                           $OPT,
                                           $CLICK_ID,
                                           $sessionId,
                                           $notes,
                                           $billing_address,
                                           $billing_city,
                                           $billing_state,
                                           $billing_zip,
                                           $billing_country,
                                           $billing_first_name,
                                           $billing_last_name);
    }
    else {
        /*
    $CLICK_ID = getClickId($stepNumber, 
                           $site->order->tracking_sid,
                           $site->order->landing_page_id, 
                           $hitpath_instance, 
                           $_POST);
                           */
    $firstName                  = $_COOKIE['first_name'];
    $lastName                   = $_COOKIE['last_name'];
    $address1                   = $_COOKIE['address'];
    $address2                   = $_COOKIE['address2'];
    $city                       = $_COOKIE['city'];
    $state                      = $_COOKIE['state'];
    $country                    = $_COOKIE['country'];
    $zip                        = $_COOKIE['zip'];
    $phone                      = $_COOKIE['phone'];
    $email                      = $_COOKIE['email'];
    $phone                      = $_COOKIE['phone'];  
    
        
    //UPDATE TO DO: SAVE THE SAME AS BILLING IN COOKIE
        
    $order = NewOrderLimelight($campaign_id,
                           $firstName,
                           $lastName,
                           $address1,
                           $city,
                           $state,
                           $zip,
                           $country,
                           $phone,
                           $email,
                           $cc_type,
                           $cc_number,
                           $expirationDate,
                           $cc_cvv,
                           $productId,
                           $product_qty,
                           $custom_product_price,
                           $shippingId,
                           $upsellCount,
                           $upsellId,
                           $billingSameAsShipping,
                           $AFID,
                           $SID,
                           $AFFID,
                           $C1,
                           $C2,
                           $C3,
                           $AID,
                           $OPT,
                           $CLICK_ID,
                           $sessionId,
                           $notes,
                           $billing_address,
                           $billing_city,
                           $billing_state,
                           $billing_zip,
                           $billing_country,
                           $billing_first_name,
                           $billing_last_name);
    }

    $ret = explode('&',$order);
    //echo '<pre>'; print_r($ret); die();
	//Get the decline reason
	$decline = explode("=",$ret[2]);
	//Check if a prepaid card was declined
	$pppos = strpos($decline[1], "Prepaid");
    
    //Determine how to proceed
    if( !empty($ret[1]) && $ret[1] == 'responseCode=100' ) {

		$exp = explode("=",$ret[5]);
		$data = array();
		foreach($ret AS $key => $value){
			$newValues = @explode('=',$value);
			$data[$newValues[0]] = $newValues[1];
		}
        //Save the order id 
        $_SESSION['step'.$stepNumber.'_orderId'] = $data['orderId'];
        setcookie('order_id', $data['orderId'], time() + 2592000, "/");
        
        //Compile a list of order ids to include in the get stream
        /*
        $orderIdsQuerystring = '';
        foreach($steps as $step => $object) {
            if(isset($_SESSION['step'.$step.'_orderId']) && $_SESSION['step'.$step.'_orderId']!='') {
                $orderIdsQuerystring .= '&step'.$step.'_orderId='.$_SESSION['step'.$step.'_orderId'];
            }
        }
        */
        $_SESSION['step1_orderId'] = $data['orderId'];
        //Success. Proceed to the next page
        $query_string = '?'
            .'order_id='.$data['orderId']
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3;
        
        header('Location: /'.$_POST['next_page'].$query_string);
        exit();
	}
    /*
	else if ($pppos !== false){
        
        
        //Reattempt to submit the order to Limelight
        $orderPrepaid = NewOrderWithProspectLimelightPrepaid(
                                                      $site->order->prepaid_campaign_id,
                                                    $prospectId,
                                                    $cc_type,
                                                    $cc_number,
                                                    $expirationDate,
                                                    $cc_cvv,
                                                    $site->order->prepaid_product_id,
                                                    $site->order->prepaid_shipping_id,
                                                    $upsellCount,
                                                    $billingSameAsShipping,
                                                    $product_qty,
                                                    $site->order->prepaid_product_price,
                                                    $AFID,
                                                    $SID,
                                                    $AFFID,
                                                    $C1,
                                                    $C2,
                                                    $C3,
                                                    $AID,
                                                    $OPT,
                                                    $CLICK_ID,
                                                    $notes,
                                                    $billing_address,
                                                    $billing_city,
                                                    $billing_state,
                                                    $billing_zip,
                                                    $billing_country,
                                                    $billing_first_name,
                                                    $billing_last_name);
        $retPrepaid = explode('&',$orderPrepaid);

        if( !empty($retPrepaid[1]) && $retPrepaid[1] == 'responseCode=100' ) {
            $exp = explode("=",$retPrepaid[5]);
            $data = array();
            foreach($retPrepaid AS $key => $value){
                $newValues = @explode('=',$value);
                $data[$newValues[0]] = $newValues[1];
            }
            
            //Save the order id 
            $_SESSION['step'.$stepNumber.'_orderId'] = $data['orderId'];
            
            //Compile a list of order ids to include in the get stream
            $orderIdsQuerystring = '';
            foreach($steps as $step => $object) {
                if(isset($_SESSION[$step.'_orderId']) && $_SESSION[$step.'_orderId']!='') {
                    $orderIdsQuerystring .= '&'.$step.'_orderId='.$_SESSION[$step.'_orderId'];
                }
            }
            
            //Success. Proceed to the next page and declare this a prepaid order
            $query_string = '?'
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            .$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&PREPAID=1';
        
            header('Location:'.$site->order->next_page.$query_string);
            exit();
        
        }
        else {
            $data = array();
            foreach($retPrepaid AS $key => $value){
                $newValues = @explode('=',$value);
                $data[$newValues[0]] = $newValues[1];
            }
            $errorMessage = urldecode($data['errorMessage']);
            
            //echo urldecode($errorMessage.'<br> <a href="shipping.php'. $querystring .'">Click here</a> to edit your billing information');
            $query_string = '?'
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            .$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&error='.urlencode($errorMessage);
        
            header('Location: /'.$site->order->this_page.$query_string);
            exit();
        }
        
    } */
    else {
        $data = array();
        foreach($ret AS $key => $value){
            $newValues = @explode('=',$value);
            $data[$newValues[0]] = $newValues[1];
        }
        $errorMessage = urldecode($data['errorMessage']);
        //echo urldecode($errorMessage.'<br> <a href="shipping.php'. $querystring .'">Click here</a> to edit your billing information');
        
        $query_string = '?'
            .'prospectId='.$prospectId
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&error='.urlencode($errorMessage);
        
        header('Location: /'.$_POST['this_page'].$query_string);
        exit();
    }
    exit();
    
} 
else {
		$errorMessage = urldecode('Blank Fields');
		//echo urldecode($errorMessage1.'<br> <a href="shipping.php'. $querystring .'">Click here</a> to edit your billing information');
    
        $query_string = '?'
            .'prospectId='.$prospectId
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&error='.urlencode($errorMessage);
        
        header('Location: /'.$_POST['this_page'].$query_string);
        exit();
}
?>