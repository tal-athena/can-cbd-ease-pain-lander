<?php

require_once('../includes/functions.php');

//Ancestor order id 
if(!empty($_COOKIE['order_id'])) {
    $previousOrderId = $_COOKIE['order_id'];   
}
else if(!empty($_SESSION['order_id'])) {
    $previousOrderId = $_SESSION['order_id'];   
} 
else if(!empty($_POST['order_id'])) {
    $previousOrderId = $_POST['order_id'];   
} else {
    $previousOrderId = 0;    
}
//Step number
if(!empty($_POST['step_number'])) {
    $stepNumber = $_POST['step_number'];
}
else {
    $stepNumber = '2';
}

//Define variables
global $site; 
$AFID = ''; 
$AFFID = ''; 
$SID = ''; 
$C1 = ''; 
$C2 = ''; 
$C3 = ''; 
$AID = ''; 
$OPT = ''; 
$CLICK_ID = '';

//echo $site->upsell->product_product_id; 
//die(); 
if( isset($previousOrderId) && $previousOrderId > 0) {
    
    //Define order ids. Loop through existing ones to continously append to querystring
    /*
    $orderIds = array();
    foreach($steps as $step => $object) {
        if(isset($_SESSION[$step.'_orderId']) && $_SESSION[$step.'_orderId']!='') {
            $orderIds[$step] = $_SESSION[$step.'_orderId'];
        }
    }
    */
    
    $step = $_POST['step'];
    
    if($site->step[$step]->next == 'thanks'){
		$next_page = $site->thanks_page_location;
    }else{
		$next_page = $site->step[$site->step[$step]->next]->page_location;	    
    }
    
	//$next_page 				  = $site->step[$site->step[$step]->next]->page_location;

if($useSquare){
    $campaign_id                = $site->step[$step]->campaign_id_square;
} else {
    $campaign_id                = $site->step[$step]->campaign_id;
}

    $offer_id                   = $site->step[$step]->offer_id;
    $billingModel               = $site->step[$step]->billing_model;
    $productId                  = $site->step[$step]->product_id; 
    $custom_product_price       = false;//$site->step[$step]->price;
    $shippingId                 = $site->step[$step]->shipping_id;
    $product_qty                = 1;
    $upsellCount                = 0; //0 if all orders are intial sales. 1 if there are bonafied upsells
    
    
    //Submit the order to Limelight
    if(isset($previousOrderId) && $previousOrderId != '') {

        $order = NewOrderCardOnFile(
                                    $previousOrderId, 
                                    $campaign_id, 
                                    $offer_id,
                                    $billingModel,
                                    $productId, 
                                    $shippingId, 
                                    $product_qty, 
                                    $custom_product_price, 
                                    array());
    }
    else {
        
        $query_string = '?'
            .'order_id='.$previousOrderId
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&error=Ancestor+order+id+could+not+be+found';
        
        header('Location: /'.$next_page.$query_string);
        exit();
        
    }

//    $ret = explode('&',$order);
//	//Get the decline reason
//	$decline = explode("=",$ret[2]);
//	//Check if a prepaid card was declined
//	$pppos = strpos($decline[1], "Prepaid");
    
    //Determine how to proceed
    //echo '<pre>'; print_r($order); die();
    if( $order->response_code == '100' ) {
    //if( !empty($ret[1]) && $ret[1] == 'responseCode=100' ) {

//		$exp = explode("=",$ret[5]);
//		$data = array();
//		foreach($ret AS $key => $value){
//			$newValues = @explode('=',$value);
//			$data[$newValues[0]] = $newValues[1];
//		}
        //Save the order id 
        $_SESSION['step'.$stepNumber.'_orderId'] = $order->order_id;
        setcookie('order_id2', $order->order_id, time() + 2592000, "/");
        
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
        $_SESSION['step2_orderId'] = $order->order_id;
        
        $query_string = '?'
            .'order_id='.$previousOrderId
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .($_GET['ism']==1?'&ism=1':'');
        //die($next_page.$query_string);
        header('Location: /'.$next_page.$query_string);
        exit();
	}
    /*
	else if ($pppos !== false){
        
        
        //Reattempt to submit the order to Limelight
        $orderPrepaid = NewOrderWithProspectLimelightPrepaid(
                                                      $site->upsell->prepaid_campaign_id,
                                                    $prospectId,
                                                    $cc_type,
                                                    $cc_number,
                                                    $expirationDate,
                                                    $cc_cvv,
                                                    $site->upsell->prepaid_product_id,
                                                    $site->upsell->prepaid_shipping_id,
                                                    $upsellCount,
                                                    $billingSameAsShipping,
                                                    $product_qty,
                                                    $site->upsell->prepaid_product_price,
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
            .'order_id='.$previousOrderId
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            .$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&PREPAID=1';
        
            header('Location: /'.$site->upsell->next_page.$query_string);
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
        
            header('Location: /'.$site->upsell->this_page.$query_string);
            exit();
        }
        
    } */
    else {
        $data = array();
        //foreach($ret AS $key => $value){
        //    $newValues = @explode('=',$value);
        //    $data[$newValues[0]] = $newValues[1];
        //}
        $errorMessage = $order->error_message;
        //echo urldecode($errorMessage.'<br> <a href="shipping.php'. $querystring .'">Click here</a> to edit your billing information');
        
        $query_string = '?'
            .'order_id='.$previousOrderId
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&decline='.urlencode($order->error_message);
        
        header('Location: /'.$next_page.$query_string);
        //header('Location: /'.$this_page.$query_string);
        exit();
    }
    exit();
    
} 
else {
		$errorMessage = urldecode('Blank Fields');
		//echo urldecode($errorMessage1.'<br> <a href="shipping.php'. $querystring .'">Click here</a> to edit your billing information');
    
        $query_string = '?'
            .'order_id='.$previousOrderId
            .'&AFID='.$AFID
            .'&AFFID='.$AFFID
            //.$orderIdsQuerystring
            .'&SID='.$SID
            .'&CLICK_ID='.$CLICK_ID
            .'&C1='.$C1
            .'&C2='.$C2
            .'&C3='.$C3
            .'&error='.urlencode($errorMessage);
        
        header('Location: /'.$this_page.$query_string);
        exit();
}
?>