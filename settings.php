<?php 

ini_set('display_errors', 0);

session_start();

/*
** SITE SETTINGS
*/

$site = new stdClass(); 
$support = new stdClass();

/*
** GENERAL 
*/


$site->LL_crm_instance                          = 'mbpremiumhealthlabs.limelightcrm.com'; //format: domainname.limelightcrm.com
$site->LL_api_username                          = 'salesfunnel';
$site->LL_api_password                          = 'BJNrjk4sy3HtzA';
$site->LL_auth                                  = 'c2FsZXNmdW5uZWw6QkpOcmprNHN5M0h0ekE=';
//base64_encode($site->LL_api_username.':'.$site->LL_api_password);

//die($site->LL_auth);

$site->insureship_id                            = '';
$site->insureship_key                           = '';
$site->insureship_endpoint                      = 'https://api.insureship.com/new_policy';

$site->product_name                             = '';
$site->upsell_name                              = '';

$support->phone                                 = '';
$support->email                                 = '';

$site->shipping_id[5] = 0.00;

$site->descriptor = 'VerifiedOffer442037463200';

$site->thanks_page_location = 'can-cbd-ease-pain/thank-you.php'; 

$site->products = array();
$site->products[0] = new stdClass();
$site->products[0]->next = 2;

$site->products[1]->qty = 1;
$site->products[1]->product_id = 4;
$site->products[1]->qty = 1;
$site->products[1]->price_per_qty = 47.95;
$site->products[1]->campaign_id = 8;
$site->products[1]->offer_id = 7;
$site->products[1]->billing_model = 2;
$site->products[1]->shipping_id = 2;

$site->products[2] = new stdClass();
$site->products[2]->product_id = 4;
$site->products[2]->qty = 1;
$site->products[2]->price_per_qty = 47.95;
$site->products[2]->campaign_id = 8;
$site->products[2]->billing_model = 2;
$site->products[2]->shipping_id = 2;

$site->step = array();
$site->step[2] = new stdClass();
$site->step[2]->page_location = 'can-cbd-ease-pain/upsell.php';


$site->step[2] = new stdClass();
$site->step[2]->page_location = 'can-cbd-ease-pain/upsell.php'; 
$site->step[2]->product_id = 4;
$site->step[2]->campaign_id = 2;
$site->step[2]->offer_id = 2;
$site->step[2]->shipping_id = 2;
$site->step[2]->billing_model = 2;
$site->step[2]->next = 3;

$site->step[3] = new stdClass();
$site->step[3]->page_location = 'can-cbd-ease-pain/upsell2.php'; 
$site->step[3]->product_id = 5;
$site->step[3]->campaign_id = 2;
$site->step[3]->offer_id = 2;
$site->step[3]->shipping_id = 2;
$site->step[3]->billing_model = 2;
$site->step[3]->next = 'thanks';//4;



?>