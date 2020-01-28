<?php

//Make it or break it
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//Includes
require_once('../includes/functions.php');

if( !empty($_POST['card_number']) ) {
    //die('debug - 1 ');
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
    
    $firstName                  = (isset($_POST['first_name']) ? $_POST['first_name'] : '');
    $lastName                   = (isset($_POST['last_name']) ? $_POST['last_name'] : '');
    $address1                   = (isset($_POST['address']) ? $_POST['address'] : '');
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

    $campaign_id                = $site->products[$_POST['product']]->campaign_id;
    $prospectId                 = $_POST['prospect_id'];
    $productId                  = $site->products[$_POST['product']]->product_id;
    $creditCardType             = $_POST['cardtype'];
    $creditCardNumber           = $_POST['card_number'];
    $custom_product_price       = $site->products[$_POST['product']]->price;//$site->discount->downsell_product_price;
    $shippingId                 = $site->products[$_POST['product']]->shipping_id;
    //$billingSameAsShipping      = ($_POST['billingcheck']?1:0);
    $billingSameAsShipping      = ($_POST['billingcheck']?0:1);
    $product_qty                = 1;
    $upsellCount                = 0; //0 if all orders are intial sales. 1 if there are bonafied upsells
    $upsellId                   = 0; 
    
        
    //Billing Address Logic
    if($billingSameAsShipping == 'NO') {
        $billing_first_name = $_POST['billing_first_name'];
        $billing_last_name  = $_POST['billing_last_name'];
        $billing_address    = $_POST['billing_address'];
        $billing_city       = $_POST['billing_city'];
        $billing_state      = $_POST['billing_state'];
        $billing_zip        = $_POST['billing_zip'];
        $billing_country    = $_POST['billing_country'];
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
    if(true){//isset($_POST['campaign_id']) && $stepNumber == '1') {
	    $order = NewOrderWithProspectLimelight(
					$campaign_id,
					$prospectId,
					$creditCardType,
					$creditCardNumber,
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
					$click_id,
					$sessionId,
					$notes,
					$billingaddress,
					$billingcity,
					$billingstate,
					$billingzip,
					$billingcountry,
					$billingfanme,
					$billinglanme);
					
//		echo '<pre>'; print_r($order); die();
		//die('debug - res = '.$order);

//        $order = NewOrderLimelight( 
//                    $campaign_id,
//                    $firstName,
//                    $lastName,
//                    $address1,
//                    $city,
//                    $state,
//                    $zip,
//                    $country,
//                    $phone,
//                    $email,
//                    $cc_type,
//                    $cc_number,
//                    $expirationDate,
//                    $cc_cvv,
//                    $productId,
//                    $product_qty,
//                    $custom_product_price,
//                    $shippingId,
//                    $upsellCount,
//                    $upsellId,
//                    $billingSameAsShipping,
//                    $AFID,
//                    $SID,
//                    $AFFID,
//                    $C1,
//                    $C2,
//                    $C3,
//                    $AID,
//                    $OPT,
//                    $CLICK_ID,
//                    $notes,
//                    $billing_address,
//                    $billing_city,
//                    $billing_state,
//                    $billing_zip,
//                    $billing_country,
//                    $billing_first_name,
//                    $billing_last_name);
    } else {
        header('Location: /'.$site->discount->this_page
               ."?error=The+campaign+id+was+not+set+or+the+step+number+is+invalid.+Please+try+again+later.");
        exit();
    }

//    $ret = explode('&',$order);
//	//Get the decline reason
//	$decline = explode("=",$ret[2]);
//	//Check if a prepaid card was declined
//	$pppos = strpos($decline[1], "Prepaid");
    
    //Determine how to proceed
    if( $order->response_code == '100' ) {

//		$exp = explode("=",$ret[5]);
//		$data = array();
//		foreach($ret AS $key => $value){
//			$newValues = @explode('=',$value);
//			$data[$newValues[0]] = $newValues[1];
//		}
        //Save the order id 
        $_SESSION['step'.$stepNumber.'_orderId'] = $order->order_id;
        setcookie('order_id', $order->order_id, time() + 2592000, "/");
        
        //Compile a list of order ids to include in the get stream
        /*
        $orderIdsQuerystring = '';
        foreach($steps as $step => $object) {
            if(isset($_SESSION['step'.$step.'_orderId']) && $_SESSION['step'.$step.'_orderId']!='') {
                $orderIdsQuerystring .= '&step'.$step.'_orderId='.$_SESSION['step'.$step.'_orderId'];
            }
        }
        */
        
        //Success. Proceed to the next page
        $query_string = '?'
            .'order_id='.$order->order_id
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3;
        
        header('Location: /'.$site->step[$site->products[0]->next]->page_location.$query_string);
        exit();
	}
    /*
	else if ($pppos !== false){
        
        
        //Reattempt to submit the order to Limelight
        $orderPrepaid = NewOrderWithProspectLimelightPrepaid(
                                                      $site->discount->prepaid_campaign_id,
                                                    $prospectId,
                                                    $cc_type,
                                                    $cc_number,
                                                    $expirationDate,
                                                    $cc_cvv,
                                                    $site->discount->prepaid_product_id,
                                                    $site->discount->prepaid_shipping_id,
                                                    $upsellCount,
                                                    $billingSameAsShipping,
                                                    $product_qty,
                                                    $site->discount->prepaid_product_price,
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
        
            header('Location:'.$site->discount->next_page.$query_string);
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
        
            header('Location: /'.$site->discount->this_page.$query_string);
            exit();
        }
        
    } */
    else {
        $data = array();
        
        //echo '<pre>'; print_r($_SERVER); die();
        //foreach($ret AS $key => $value){
        //    $newValues = @explode('=',$value);
        //    $data[$newValues[0]] = $newValues[1];
        //}
        $errorMessage = $order->error_message;
//        $errorMessage = urldecode($data['errorMessage']);
        //echo urldecode($errorMessage.'<br> <a href="shipping.php'. $querystring .'">Click here</a> to edit your billing information');
        
        $query_string = '?'
            .'prospect_id='.$_POST['prospect_id']
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&error='.urlencode($errorMessage);
        
        header('Location: '.$_SERVER['HTTP_REFERER'].'&error='.urlencode($errorMessage));
        exit();
    }
    exit();
    
} 
else {
		$errorMessage = urldecode('Blank Fields. A Card Number was not received.');
    
        $query_string = '?'
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&error='.urlencode($errorMessage);
        
        header('Location: /'.$site->discount->this_page.$query_string);
        exit();
}
?>