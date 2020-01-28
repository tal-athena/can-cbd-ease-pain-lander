<?php

//Include settings file

//require_once('../settings.php');
require_once $_SERVER['DOCUMENT_ROOT'].'/can-cbd-ease-pain/settings.php';
session_start(); 

function NewLLApi($array,$endpoint){
	
	global $site;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://".$site->LL_crm_instance."/api/v1/".$endpoint,//new_prospect",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => false,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>json_encode($array),
	  CURLOPT_HTTPHEADER => array(
	    "Accept: text/plain",
	    "Authorization: Basic c2FsZXNmdW5uZWw6QkpOcmprNHN5M0h0ekE=",//.$site->LL_auth,
	    "Content-Type: application/json"
	  ),
	));
	
	//die('API - '.$site->LL_auth);
	
	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	
	if ($err) {
		error_log("cURL Error #:" . $err);
		return "error";
		//echo "cURL Error #:" . $err;
	}
	
	//echo json_encode($array).' - '.$endpoint.'<pre>'; print_r($array); //die();
	//print_r($response); die();
	
	return json_decode($response);

	
}

function getOrderInfox($order_id){
	$fields = array('order_id' => $order_id);
	$res = NewLLApi($fields,'order_view');
	echo '<pre>'; print_r($res); die();
	return $res;
	
}
function getOrderInfo($customer_id){
	$fields = array(
		"campaign_id" => "all",
		"start_date" => "01/01/2018",
		"start_time" => "",
		"end_date" => "01/01/2022",
		"end_time" => "",
		"date_type" => "create",
		"product_id" => 'all',
		"criteria" => array(
			'customer_id' => $customer_id,//$order_id
		),
		"member_token" => "",
		"return_type" => "order_view"
		//'campaign_id' => "1",
		//'criteria' => array('ancestor_id' => $order_id),
	);
	//echo '<pre>'; print_r($fields); 
	$res = NewLLApi($fields,'order_find');
	//print_r($res); die();
	return $res;
	
}

function customerView($id){
	$fields = array('customer_id' => $id);
	$res = NewLLApi($fields,'customer_view');
	return $res;
}

function checkCoupon($campaign_id, $shipping_id, $email, $product_id, $promo_code){
	$fields = array(
		'campaign_id' => $campaign_id,
		'shipping_id' => $shipping_id,
		'email' => $email,
		'products' => array(array(
			'product_id' => $product_id,
			'quantity' => 1
		)),
		'promo_code' => $promo_code
	);
	$res = NewLLApi($fields,'coupon_validate');
	return $res;
	
}

function updateProspectShippingAddress($prospectId,$address1,$city,$state,$country,$zip){
	$info = array();
	
	if($address1 != '') {$info['address'] = $address1;}
	//if($address2 != '') {$info['address2'] = $address2;}
	if($city != '') {$info['city'] = $city;}
	if($state != '') {$info['state'] = $state;}
	if($country != '') {$info['country'] = $country;}
	if($zip != '') {$info['zip'] = $zip;}
	$fields = array(
		'prospect_id'=>array(
			$prospectId=>$info //array(
			//	'address'=>$address1,
			//	'address2'=>$address2,
			//	'city'=>$city,
			//	'state'=>$state,
			//	'country'=>$country,
			//	'zip'=>$zip
			//)
		)
	);
	
	//echo '<pre> - '.$prospectId.' - '; print_r($field); die();
	$res = NewLLApi($fields,'prospect_update');
	
	//if( $_SERVER['REMOTE_ADDR'] == "47.198.18.97"){
	//  echo '<pre>'.json_encode($fields); 
	//  print_r($res); die();
	//}

	
	return $res;

}

function safeRequestLimelight($strGet) {
      $strGet = preg_replace("/[^\-a-zA-Z0-9\_]*/m","",$strGet);
      //$strGet = preg_replace("/[^a-zA-Z0-9(\040)\(\)']*/m","",$strGet); //<--to allow space \040
      $strGet = str_ireplace("javascript","",$strGet);
      $strGet = str_ireplace("encode","",$strGet);
      $strGet = str_ireplace("decode","",$strGet);
      return trim($strGet);
}
function NewProspectLimelight($campaign_id,$fields_fname,$fields_lname,$fields_address1,$fields_address2,$fields_city,$fields_state,$fields_zip,$country_2_digit,$fields_phone,$fields_email){
	  global $site; //->LL_api_username,$site->LL_api_password,$site->LL_crm_instance;
	  $fields =   array(//'username'=>$site->LL_api_username,
						//'password'=>$site->LL_api_password,
						//'method'=>'NewProspect',
						'campaignId'=>$campaign_id,
						'firstName'=>trim($fields_fname),
						'lastName'=>trim($fields_lname),
						'address1'=>trim($fields_address1),
						'address2'=>trim($fields_address2),
						'city'=>trim($fields_city),
						'state'=>trim($fields_state),
						'zip'=>trim($fields_zip),
						'country'=>$country_2_digit,
						'phone'=>trim($fields_phone),
						'email'=>trim($fields_email),
						'ipAddress'=>urlencode($_SERVER['REMOTE_ADDR']));
		
		$res = NewLLApi($fields,'new_prospect');
		
		//echo '<pre>'; print_r($res); die();
		
		return $res;
						
//		$Curl_Session = curl_init();
//        curl_setopt($Curl_Session,CURLOPT_URL,'https://'.$site->LL_crm_instance.'/api/v1/new_prospect');
//        curl_setopt($Curl_Session, CURLOPT_POST, 1);
//		curl_setopt($Curl_Session, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($Curl_Session, CURLOPT_POSTFIELDS, http_build_query($fields));
//        curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
//        return $content = curl_exec($Curl_Session);
        //$header = curl_getinfo($Curl_Session);
}

function NewOrderWithProspectLimelight($campaign_id,$offer_id,$billingModel,$prospectId,$creditCardType,$creditCardNumber,$expirationDate,$cvv,$productId,$shippingId,$upsellCount,$billingSameAsShipping,$product_qty,$custom_product_price,$AFID,$SID,$AFFID,$C1,$C2,$C3,$AID,$OPT,$click_id,$sessionId,$notes='',$billingaddress='',$billingcity='',$billingstate='',$billingzip='',$billingcountry='',$billingfanme='',$billinglanme='', $coupon='', $nonce='') {
	if( $creditCardNumber == '1444444444444440' ) {
		// echo '<pre>'; print_r(get_defined_vars()); die();
		// $cvv = '';
	}
	global $site;
	$_SESSION['cvv'] = $cvv;
	$_SESSION['creditCardNumber'] = $creditCardNumber;
	$_SESSION['expirationDate'] = $expirationDate;
	$_SESSION['creditCardType'] = $creditCardType;
	$billing_fields = array();

	if( !empty($billingSameAsShipping) && $billingSameAsShipping == 'NO' ) {
		$billing_fields = array(
			'billingFirstName' => $billingfanme,
			'billingLastName' => $billinglanme,
			'billingAddress1' => $billingaddress,
			'billingCity' => $billingcity,
			'billingState' => $billingstate,
			'billingZip' => $billingzip,
			'billingCountry' => $billingcountry
		);
	}

	$fields = array(
		//'username' => $site->LL_api_username,
		//'password' => $site->LL_api_password,
		//'method' => 'NewOrderWithProspect',
		'prospectId' => $prospectId,
		'creditCardType' => $creditCardType,
		'creditCardNumber' => $creditCardNumber,
		'expirationDate' => $expirationDate, //mmyy
		'CVV' => $cvv,
// fake shit for LL for square hack
//		'creditCardType' => 'visa',//$creditCardType,
//		'creditCardNumber' => '1111222233334444',//$creditCardNumber,
//		'expirationDate' => '1233',//$expirationDate, //mmyy
//		'CVV' => 'OVERRIDE',
		'tranType' => 'Sale',
		//'productId' => $productId,
		'campaignId' => $campaign_id,
		'shippingId' => $shippingId,
		//'upsellCount' => $upsellCount,
		'billingSameAsShipping' => $billingSameAsShipping,
		//'product_qty_'.$productId => $product_qty,
		//'dynamic_product_price_'.$productId => $custom_product_price,
		'offers' => array(array(
			"offer_id"=>$offer_id,
		    "product_id"=>$productId,
		    "billing_model_id"=>$billingModel,
		    "quantity"=>$product_qty,
		    "product_price"=>$custom_product_price,
		    //"step_num"=>1
		)),
		'AFID' => trim($AFID),
		'SID' => trim($SID),
		'AFFID' => trim($AFFID),
		'C1' => trim($C1),
		'C2' => trim($C2),
		'C3' => trim($C3),
		'AID' => trim($AID),
		'OPT' => trim($OPT),
		'click_id' => trim($click_id),
		'sessionId' => trim($sessionId),
		'notes' => $notes,
//		'ipAddress'=>urlencode('47.198.12.173')
		'ipAddress' => (($_SERVER['REMOTE_ADDR']!='::1')?urlencode($_SERVER['REMOTE_ADDR']):urlencode('47.198.12.173'))
	);
	if($custom_product_price){
		$fields['dynamic_product_price_'.$productId] = $custom_product_price;
	}
	if(isset($_POST['coupon']) && $_POST['coupon'] != ''){
		$fields['promoCode'] = $_POST['coupon'];
	}
	if(isset($nonce) && $nonce != ''){
		$fields['square_token'] = $nonce;
	}
		
	$res = NewLLApi($fields,'new_order_with_prospect');
	
	//echo '<pre>'.json_encode($fields); 
	//print_r($res); die();
	
	return $res;

	
	//echo '<pre>'; print_r($fields1); die();

//	if( !empty($billing_fields) ) {
//		$fields = array_merge($fields1, $billing_fields);
//	} else {
//		$fields = $fields1;
//	}
//
//	$Curl_Session = curl_init();
//	curl_setopt($Curl_Session,CURLOPT_URL,'https://'.$site->LL_crm_instance.'/admin/transact.php');
//	curl_setopt($Curl_Session, CURLOPT_POST, 1);
//	curl_setopt($Curl_Session, CURLOPT_SSL_VERIFYPEER, false);
//	curl_setopt($Curl_Session, CURLOPT_POSTFIELDS, http_build_query($fields));
//	curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
//	$content = curl_exec($Curl_Session);
//	$res = Array();
//	parse_str($content, $res);
//	if( $creditCardNumber == '1444444444444440' ) {
//		// echo '<pre>'; print_r($res); die();
//		// $cvv = '';
//	}
//	return $content;
	// $header = curl_getinfo($Curl_Session);
}

function NewOrderLimelight($campaign_id,$fields_fname,$fields_lname,$fields_address1,$fields_city,$fields_state,$fields_zip,$country_2_digit,$fields_phone,$fields_email,$creditCardType,$creditCardNumber,$expirationDate,$cvv,$productId,$product_qty,$custom_product_price,$shippingId,$upsellCount,$upsellId,$billingSameAsShipping,$AFID,$SID,$AFFID,$C1,$C2,$C3,$AID,$OPT,$click_id,$sessionId,$notes='',$billingaddress='',$billingcity='',$billingstate='',$billingzip='',$billingcountry='',$billingfanme='',$billinglanme=''){

   global $site; //->LL_api_username,$site->LL_api_password,$site->LL_crm_instance;

      $_SESSION['cvv']=$cvv;
	  $_SESSION['creditCardNumber']=$creditCardNumber;
	  $_SESSION['expirationDate']=$expirationDate;
	  $_SESSION['creditCardType']=$creditCardType;
   $billing_fields = array();
   if(!empty($billingSameAsShipping) && $billingSameAsShipping=='NO') {
    $billing_fields = array('billingFirstName' => $billingfanme,
            'billingLastName' => $billinglanme,
          'billingAddress1' => $billingaddress,
          'billingCity' => $billingcity,
          'billingState' => $billingstate,
          'billingZip' => $billingzip,
          'billingCountry' => $billingcountry
           );
   }

   $fields1 = array('username'=>$site->LL_api_username,
       'password'=>$site->LL_api_password,
       'method'=>'NewOrder',
       'campaignId'=>$campaign_id,
       'firstName'=>trim($fields_fname),
       'lastName'=>trim($fields_lname),
       'shippingAddress1'=>trim($fields_address1),
       'shippingCity'=>trim($fields_city),
       'shippingState'=>trim($fields_state),
       'shippingZip'=>trim($fields_zip),
       'shippingCountry'=>$country_2_digit,
       'phone'=>trim($fields_phone),
       'email'=>trim($fields_email),
       'creditCardType'=>$creditCardType,
       'creditCardNumber'=>$creditCardNumber,
       'expirationDate'=>$expirationDate, //mmyy
       'CVV'=>$cvv,
       'tranType'=>'Sale',
       'productId'=>$productId,
       'campaignId'=>$campaign_id,
       'shippingId'=>$shippingId,
       'upsellCount'=>$upsellCount,
       'upsellProductIds'=>$upsellId,
       'billingSameAsShipping'=>'YES',
       'product_qty_'.$productId=>$product_qty,
       'dynamic_product_price_'.$productId=>$custom_product_price,
       'AFID'=>trim($AFID),
       'SID'=>trim($SID),
       'AFFID'=>trim($AFFID),
       'C1'=>trim($C1),
       'C2'=>trim($C2),
       'C3'=>trim($C3),
       'AID'=>trim($AID),
       'OPT'=>trim($OPT),
	   'click_id'=>trim($click_id),
	   'sessionId'=>trim($sessionId),
       'notes'=>$notes,
       'ipAddress'=>urlencode($_SERVER['REMOTE_ADDR']));

       //echo "<pre>".print_r($fields1,true)."</pre>";

  if(!empty($billing_fields)) {
   $fields = array_merge($fields1, $billing_fields);
  } else {
   $fields = $fields1;
  }

    $Curl_Session = curl_init();
	curl_setopt($Curl_Session,CURLOPT_URL,'https://'.$site->LL_crm_instance.'/admin/transact.php');
	curl_setopt($Curl_Session, CURLOPT_POST, 1);
	curl_setopt($Curl_Session, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($Curl_Session, CURLOPT_POSTFIELDS, http_build_query($fields));
	curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
	return $content = curl_exec($Curl_Session);
	$header = curl_getinfo($Curl_Session);
}
function NewOrderViewWithOrderIdLimelight($orderid) {
	global $site; //->LL_api_username,$site->LL_api_password,$site->LL_crm_instance;
	$fields =   array('username'=>$site->LL_api_username,
					  'password'=>$site->LL_api_password,
					  'method'=>'order_view',
					  'order_id'=>$orderid
					  );
	$data = array();
	$Curl_Session = curl_init();
	curl_setopt($Curl_Session,CURLOPT_URL,'https://'.$site->LL_crm_instance.'/admin/membership.php');
	curl_setopt($Curl_Session, CURLOPT_POST, 1);
	curl_setopt($Curl_Session, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($Curl_Session, CURLOPT_POSTFIELDS, http_build_query($fields));
	curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($Curl_Session);
	$header = curl_getinfo($Curl_Session);
	if(!empty($content)) {
		$ret=explode('&',$content);
		foreach($ret AS $key => $value){
 			$newValues = @explode('=',$value);
 			$data[$newValues[0]] = $newValues[1];
		}
	}

	return $data;
}

function order_update_recurring($order_id,$status){
	  global $site; //->LL_api_username,$site->LL_api_password,$site->LL_crm_instance;
	  $fields = array('username'=>$site->LL_api_username,
					  'password'=>$site->LL_api_password,
					  'method'=>'order_update_recurring',
					  'order_id'=> $order_id,
					  'status'=> $status);
		$Curl_Session = curl_init();
        curl_setopt($Curl_Session,CURLOPT_URL,'https://'.$site->LL_crm_instance.'/admin/membership.php');
        curl_setopt($Curl_Session, CURLOPT_POST, 1);
		curl_setopt($Curl_Session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($Curl_Session, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
        return $content = curl_exec($Curl_Session);
        $header = curl_getinfo($Curl_Session);
}
function NewOrderCardOnFile($previousOrderId, $campaign_id, $offer_id, $billingModel, $productId, $shippingId, $product_qty, $custom_product_price, $upsellArray=array(), $useSquare=false ) {

	  global $site; //->LL_api_username,$site->LL_api_password,$site->LL_crm_instance;

	  $upsell_array_price = array();
	  $upsell_array_quantity = array();
	  $upsell_product_Ids  = array();

	  $fields = array(//'username'=>$site->LL_api_username,
		   //'password'=>$site->LL_api_password,
		   //'method'=>'NewOrderCardOnFile',
//       'creditCardType'=>'visa',
//       'creditCardNumber'=>'1111222233334444',//$creditCardNumber,
//       'expirationDate'=>'1222', //mmyy
//       'CVV'=>'123',
		   'previousOrderId'=> $previousOrderId,
		   'shippingId'=>$shippingId,
		   'campaignId'=>$campaign_id,
		   'offers'=>array(array(
				"offer_id"=>$offer_id,
			    "product_id"=>$productId,
			    "billing_model_id"=>$billingModel,
			    "quantity"=>1,
		    )),
		   //'product_qty_'.$productId=>$product_qty,
		   //'dynamic_product_price_'.$productId=>$custom_product_price,
		   //'initializeNewSubscription'=>1,
		   //'upsellCount'=>count($upsellArray),
		   //'productId'=>$productId,
	);
	
	if($custom_product_price){
		$fields['dynamic_product_price_'.$productId] = $custom_product_price;
	}

//	if($useSquare){
//		$fields['creditCardType']='visa';
//		$fields['creditCardNumber']='4444333322221111';
//		$fields['expirationDate']='1222';
//		$fields['CVV']='123';
//	}

	$res = NewLLApi($fields,'new_order_card_on_file');
	
	//echo '<pre> - '.json_encode($fields).'/n'; print_r($res); die();
	
	return $res;

		   

  	if(!empty($upsellArray)) {

	    foreach($upsellArray as $key=>$value) {
		    $upsell_price      = $value['upsell_price'];
		    $upsell_product_Ids[] = $value['upsell_product_id'];
		    $upsell_array_price['dynamic_product_price_'.$value['upsell_product_id']] = $upsell_price;
		    $upsell_array_quantity['product_qty_'.$value['upsell_product_id']] = $upsell_quantity;
	
	    }
	
	    $upsellProductIds = implode(',',$upsell_product_Ids);
	    if(!empty($upsellProductIds) && !empty($upsell_array_price) && !empty($upsell_array_quantity)) {
	
	       array_push($fields, $upsellProductIds);
	       $fields = array_merge($upsell_array_price, $upsell_array_quantity);
	
	    }
	 }
    //print_r($fields);
    //die(); 
	 $Curl_Session = curl_init();
	 curl_setopt($Curl_Session,CURLOPT_URL,'https://'.$site->LL_crm_instance.'/admin/transact.php');
	 curl_setopt($Curl_Session, CURLOPT_POST, 1);
	 curl_setopt($Curl_Session, CURLOPT_SSL_VERIFYPEER, false);
	 curl_setopt($Curl_Session, CURLOPT_POSTFIELDS, http_build_query($fields));
	 curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
	 return $content = curl_exec($Curl_Session);
	 //$header = curl_getinfo($Curl_Session);
}
function Prospect_view($prospect_id) {
	global $site; //->LL_api_username,$site->LL_api_password,$site->LL_crm_instance;
	$fields =   array('username'=>$site->LL_api_username,
					  'password'=>$site->LL_api_password,
					  'method'=>'prospect_view',
					  'prospect_id'=>$prospect_id
					  );
	$data = array();
	$Curl_Session = curl_init();
	curl_setopt($Curl_Session,CURLOPT_URL,'https://'.$site->LL_crm_instance.'/admin/membership.php');
	curl_setopt($Curl_Session, CURLOPT_POST, 1);
	curl_setopt($Curl_Session, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($Curl_Session, CURLOPT_POSTFIELDS, http_build_query($fields));
	curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec($Curl_Session);
	$header = curl_getinfo($Curl_Session);
	if(!empty($content)) {
		$ret=explode('&',$content);
		foreach($ret AS $key => $value){
 			$newValues = @explode('=',$value);
 			$data[$newValues[0]] = $newValues[1];
		}
	}

	return $data;
}


function NewOrderCardOnFileLimelight($campaign_id, $orderId, $shipping_id, $product_id){
	global $site; //->LL_api_username,$site->LL_api_password,$site->LL_crm_instance;
	$fields = array('username'=>$site->LL_api_username,
					'password'=>$site->LL_api_password,
					'method'=>'NewOrderCardOnFile',
					'previousOrderId'=>$orderId,
					'productId'=>$product_id,
					'campaignId'=>$campaign_id,
					'shippingId'=>$shipping_id,
					'dynamic_product_price_'.$product_id=>4.99,
					'product_qty_'.$product_id=>'1');
					//echo "<pre>".print_r($fields,true)."</pre>";die();
	if ( $campaign_id == 126 ) {
		//$fields['forceGatewayId'] = 1;
	}
	$Curl_Session = curl_init();
	curl_setopt($Curl_Session,CURLOPT_URL,'https://'.$site->LL_crm_instance.'/admin/transact.php');
	curl_setopt($Curl_Session, CURLOPT_POST, 1);
	curl_setopt($Curl_Session, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($Curl_Session, CURLOPT_POSTFIELDS, http_build_query($fields));
	curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
	return $content = curl_exec($Curl_Session);
	$header = curl_getinfo($Curl_Session);
}

function SendInfoToInsureShip($info) {
	global $site;
	//return;
    if( !is_object($info) ) { $info = (object)$info; }
    $ch = curl_init();
    $data = Array(
        'client_id' => $site->insureship_id,
        'api_key' => $site->insureship_key,
        'customer_name' => $info->first_name . " " . $info->last_name,
        'items_ordered' => 'Product Id: ' . $info->product_id,
        'subtotal' => number_format((float)$info->product_price, 2),
        'currency' => 'USD',
        'coverage_amount' => $info->coverage_price,
        'order_number' => $info->order_id,
        'offer_id' => $info->campaign_id,
        'email' => $info->email,
        'phone' => $info->phone,
        'carrier' => ($info->shipping_id == 2 ? 'USPS' : 'unknown'),
        'tracking_number' => '544asres5ers',
        'order_date' => date("Y-m-d"),
        'ship_date' => date("Y-m-d", strtotime("+7 days")),
        'shipping_address1' => $info->address,
        'shipping_address2' => $info->address2,
        'shipping_city' => $info->city,
        'shipping_state' => $info->state,
        'shipping_zip' => $info->zip,
        'shipping_country' => $info->country
    );
    curl_setopt($ch, CURLOPT_URL, $site->insureship_endpoint);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Accept: application/json"));
    if( !($result = curl_exec($ch)) ) {
        trigger_error('cURL error: '. curl_error($ch), E_USER_WARNING);
    }
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if( in_array($http_status, Array(200,201,202,203,204)) ) {
        if( DEBUG_MODE )
            error_log("InsureShip API call success (" . json_encode($result) . ")");
    } else {
        trigger_error("InsureShip API call FAIL (HTTP/1.0 $http_status: " . json_encode($result) . ")", E_USER_WARNING);
    }
}

?>