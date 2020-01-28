<?php

//echo '<pre>'; print_r($_GET); die();

//Make it or break it
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//Includes
require_once('../includes/functions.php');

$_SESSION['shipping_email'] = $_POST['shipping_email'];

$_SESSION['shipping_address'] = $_POST['shipping_address'];
$_SESSION['shipping_address2'] = $_POST['shipping_address2'];
$_SESSION['shipping_city'] = $_POST['shipping_city'];
$_SESSION['shipping_state'] = $_POST['shipping_state'];
$_SESSION['shipping_country'] = $_POST['shipping_country'];
$_SESSION['shipping_zipcode'] = $_POST['shipping_zipcode'];

//die('email - '.$_SESSION['email']);

//Define the list of POST variables
$vars = array(); //array('AFFID','C1','C2','C3','CLICK_ID','tr'); 

$next_page = $POST['next_page'];
$this_page = $POST['this_page'];

//If the campaign ID and email is set, attempt to add a prospect
if( true ){//!empty($_POST['campaign_id']) && !empty($_POST['email']) ) {

    /*foreach($vars as $var) {
        if(!empty($_GET[$var])) {
            $DATA[$var]     = $_GET[$var]; 
            $_SESSION[$var] = $_GET[$var];
        }
        else {
            $DATA[$var] = '';   
        }
    }*/
    
    // Process full-name to name and surname
    $shipping_firstname = $_POST['shipping_firstname'];

    $arr = explode(' ', $shipping_firstname);
    $num = count($arr);

     if ($num == 2) {
        $shipping_firstname = $arr[0];
        $_SESSION['shipping_firstname'] = $shipping_firstname;
        $shipping_lastname = $arr[1];
        $_SESSION['shipping_lastname'] = $shipping_lastname; 

    } else {
        $shipping_firstname = $arr[0];
        $_SESSION['shipping_firstname'] = $shipping_firstname;
        if ($num < 1) {
            $shipping_lastname = $arr[$num-1];
            $_SESSION['shipping_lastname'] = $shipping_lastname;
        }
    };


	//Save the customer info
	$customer_fields = array('first_name', 'last_name', 'address', 'address2', 'city', 'state', 'zip', 'country', 'phone', 'email', 'notes');
	foreach($customer_fields as $field) {
        if(!isset($_POST[$field])) {
            $_POST[$field] = '';
        }
		$_SESSION[$field] = $_POST[$field];
		setcookie($field, $_POST[$field], time()+60*60*24*30, '/');
        
	}

	//POST data from the prospect form
	//echo $site->index->product_campaign_id.' - '.$_POST['shipping_firstname'].' - '.$_POST['shipping_lastname'].' - '.$_POST['shipping_address'].' - '.$_POST['shipping_address2'].' - '.$_POST['shipping_city'].' - '.$_POST['shipping_state'].' - '.$_POST['shipping_zipcode'].' - '.$_POST['shipping_country'].' - '.$_POST['shipping_phone'].' - '.$_POST['shipping_email'];
	
	//die('stopped');
                                    
	$content = NewProspectLimelight($site->products[2]->campaign_id,
                                    $_SESSION['shipping_firstname'],
                                    $_SESSION['shipping_lastname'],
                                    $_POST['shipping_address'],
                                    $_POST['shipping_address2'],
                                    $_POST['shipping_city'],
                                    $_POST['shipping_state'],
                                    $_POST['shipping_zipcode'],
                                    $_POST['shipping_country'],
                                    $_POST['shipping_phone'],
                                    $_POST['shipping_email']);

	//$ret=explode('&',$content);
	


	//die($content);

    $details = $content;//Array();
//    parse_str($content, $details);
//    $ret=explode('&',$content);
//
//	foreach($ret as $r=>$value) {
//		$ret2 = @explode('=',$value);
//		$vars[] = $ret2[0];
//		$DATA[$ret2[0]] = $ret2[1];
//	}

	/*if( $ret[1] == 'response_code=100' ) {
		
        //Next page, derived from settings file
        $page = $_POST['next_page'];
        $prospect_id = $ret[2];
        $_SESSION['prospect_id'] = explode('=',$ret[2])[1];
        setcookie("prospect_id", explode('=',$ret[2])[1], time()+60*60*24*30, '/');

	} else {

        $page = $_POST['this_page'];
        $prospect_id = 'mode=failure';

	}*/

    if( $details->response_code == '100' ) {
        //Next page, derived from settings file
        $page = $_POST['next_page'];
        $_SESSION['prospect_id'] = $prospect_id = $details->prospectId;
        setcookie("prospect_id", $prospect_id, time()+60*60*24*30, '/');
    } else {
        $page = $_POST['this_page'];
        $prospect_id = 'mode=failure';
    }

	//$url_param = 'https://'.$_SERVER['SERVER_NAME'].'/'.$page."?".trim($prospect_id);

    $url_param = 'https://'.$_SERVER['SERVER_NAME'].'/'.$page."?prospectId=".trim($prospect_id);
    
    //Build url
    foreach($vars as $var) {
        $url_param .= "&".$var."=".$DATA[$var];
        
    }

	//header('Location:'.$url_param);
	header('Location:'.$url_param.'&product_id='.$_POST['product_id']);
	exit();

} else {
    header("Location: /".$this_page."?declineReason=The+campaign+id+or+the+email+address+was+empty.+Please+try+again.");
}

?>