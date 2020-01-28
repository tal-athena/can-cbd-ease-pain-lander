<?php
	
$mobile = false;
$refererinfo = explode('/',$_SERVER['HTTP_REFERER']);
$pageinfo = explode('?',$refererinfo[(count($refererinfo)-1)]);
if ($pageinfo[0] == 'order-m.php'){
	//echo 'yep its mobile'; die();
	$mobile = true;
}
//Make it or break it
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//echo '<pre>'; print_r($_POST); 
//die();

//Includes
require_once('../includes/functions.php');

if( !empty($_POST['card_number']) || isset($_POST['nonce'])) {
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
    //echo '<pre>'; print_r($_POST); print_r($_GET); die();
    //Define variables
    global $site; 
    $stepNumber = '';
	$AFID = ''; 
    $AFFID = $_GET['AFFID']; 
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

    if(isset($_POST['nonce'])){
	    $campaign_id                = $site->products[$_POST['product']]->campaign_id_square;
	} else {
	    $campaign_id                = $site->products[$_POST['product']]->campaign_id;
	}
    $offer_id                   = $site->products[$_POST['product']]->offer_id;
    if($site->products[$_POST['product']]->billing_model == 'radio'){
	    if($_POST['autoship'] == 1){
		    $billingModel               = $site->products[$_POST['product']]->billing_model_selected;
	    } else {
		    $billingModel               = $site->products[$_POST['product']]->billing_model_not_selected;
	    }
	    
    } else {
	    $billingModel               = $site->products[$_POST['product']]->billing_model;
    }
    //die(($site->products[$_POST['product']]->tracking === 0 ? $site->products[$_POST['product']]->tracking.' - avoidTracking - true' : $site->products[$_POST['product']]->tracking.' - avoidTracking - false'));
    $avoidTracking              = ($site->products[$_POST['product']]->tracking === 0 ? true : false);
    
    $prospectId                 = $_POST['prospect_id'];
    $productId                  = $site->products[$_POST['product']]->product_id;
    $creditCardType             = $_POST['cardtype'];
    $creditCardNumber           = $_POST['card_number'];
    $custom_product_price       = (isset($site->products[$_POST['product']]->qty)?$site->products[$_POST['product']]->price_per_qty:false);//$site->products[$_POST['product']]->price;//$site->discount->downsell_product_price;
    $shippingId                 = $site->products[$_POST['product']]->shipping_id;
    //$billingSameAsShipping      = ($_POST['billingcheck']?1:0);
    //$billingSameAsShipping      = ($_POST['billingcheck']?0:1);
    $product_qty                = (isset($site->products[$_POST['product']]->qty)?$site->products[$_POST['product']]->qty:1);
    $upsellCount                = 0; //0 if all orders are intial sales. 1 if there are bonafied upsells
    $upsellId                   = 0; 
    
        
    //Billing Address Logic
        $billing_first_name = '';
        $billing_last_name  = '';
        $billing_address    = '';
        $billing_city       = '';
        $billing_state      = '';
        $billing_zip        = '';
        $billing_country    = '';
    
    // override for square
    
    if(isset($_POST['nonce'])){
	    $nonce                      = (isset($_POST['nonce'])? $_POST['nonce'] : '');    
	    $creditCardNumber = '444433332222'.$_POST['card-last4'];
	    $expirationDate = $_POST['card-exp'];
	    $creditCardType = strtolower($_POST['card-type']);
	    $billingzip = $_POST['card-zip'];
	    $cc_cvv = 'OVERRIDE';
	    $notes = 'Ordered though Square with '.$_POST['card-type'].' - ***'.$_POST['card-last4'].' - exp:'.$_POST['card-exp'];
    
		$updated = updateProspectShippingAddress($prospectId,'','','','','',$billingzip);
	} else {
		$nonce = '';
	}
    
    $content = updateProspectShippingAddress($prospectId,
                                    str_replace( ',', '', $_POST['shipping_address']),
                                    str_replace( ',', '', $_POST['shipping_city']),
                                    $_POST['shipping_state'],
                                    $_POST['shipping_country'],
                                    str_replace( ',', '', $_POST['shipping_zipcode'])
                                    );

    //Submit the order to Limelight
    if(true){//isset($_POST['campaign_id']) && $stepNumber == '1') {
	    $order = NewOrderWithProspectLimelight(
					$campaign_id,
					$offer_id,
					$billingModel,
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
					$billinglanme,
					'',
					$nonce);
					
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
	    // STA track outcome 1
	    $id=2;
	    $outcome=1;
	    $sta_amt=$custom_product_price;

//		$exp = explode("=",$ret[5]);
//		$data = array();
//		foreach($ret AS $key => $value){
//			$newValues = @explode('=',$value);
//			$data[$newValues[0]] = $newValues[1];
//		}
        //Save the order id 
        $_SESSION['step'.$stepNumber.'_orderId'] = $order->order_id;
        setcookie('order_id', $order->order_id, time() + 2592000, "/");

        $cus = customerView($order->customerId);
        
        $_SESSION['order_id'] = $order->order_id;
        $_SESSION['order_total'] = $order->orderTotal;
        $_SESSION['product_id'] = $productId;
        $_SESSION['customer_id'] = $order->customerId;
        $_SESSION['customer_fname'] = $cus->first_name;
        $_SESSION['customer_lname'] = $cus->last_name;
        $_SESSION['customer_email'] = $cus->email;
        $_SESSION['customer_phone'] = $cus->phone;
        
        if(isset($_POST['charge_insurance'])){
	        
	        $insureProduct = 4; //index in settings file 

    if(isset($_POST['nonce'])){
			$campaign_id2                = $site->products[$insureProduct]->campaign_id_square;
	} else {
			$campaign_id2                = $site->products[$insureProduct]->campaign_id;
	}	
			$offer_id                   = $site->products[$insureProduct]->offer_id;
			$billingModel               = $site->products[$insureProduct]->billing_model;
			$productId2                 = $site->products[$insureProduct]->product_id; 
			$custom_product_price       = ($_POST['finsure']==1)?'0.00':false;//$site->products[$insureProduct]->price;
			$shippingId                 = $site->products[$insureProduct]->shipping_id;
			$product_qty                = 1;
			$upsellCount                = 0; //0 if all orders are intial sales. 1 if there are bonafied upsells
			$insure = NewOrderCardOnFile(
				$order->order_id,
				$campaign_id2, 
				$offer_id,
				$billingModel,
				$productId2, 
				$shippingId, 
				$product_qty, 
				$custom_product_price, 
				array());
			//echo '<pre>'; print_r($insure); die();
			if( $insure->response_code == '100' ) {
				//make a call to insureship
				$insureShipArray['first_name'] = $firstName;
				$insureShipArray['last_name'] = $lastName;
				$insureShipArray['product_id'] = $productId;
				$insureShipArray['product_price'] = $custom_product_price;
				$insureShipArray['coverage_price'] = $custom_product_price;
				$insureShipArray['order_id'] = $order->order_id;
				$insureShipArray['campaign_id'] = $campaign_id;
				$insureShipArray['email'] = $email;
				$insureShipArray['phone'] = $phone;
				$insureShipArray['shipping_id'] = $shippingId;
				$insureShipArray['address'] = $address1;
				$insureShipArray['address2'] = $address2;
				$insureShipArray['city'] = $city;
				$insureShipArray['state'] = $state;
				$insureShipArray['zip'] = $zip;
				$insureShipArray['country'] = $country;
				
				SendInfoToInsureShip($insureShipArray);

			}



        }
                
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
            .'&C3='.$C3
            .'&tr='.$_GET['tr']
            .'&total='.$order->orderTotal
            .($avoidTracking?'&at=1':'')
            .($mobile?'&ism=1':'');
            
        
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
        
        //echo '<pre>'; print_r($order); die();
        
        //echo '<pre>'; print_r($_SERVER); die();
        //foreach($ret AS $key => $value){
        //    $newValues = @explode('=',$value);
        //    $data[$newValues[0]] = $newValues[1];
        //}
        $errorMessage = (!is_array($order->error_message)?$order->error_message:'An Error Has Occurred - Please Check Your Card And Try Again.');
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
		$AFFID = $_GET['AFFID']; 
   
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