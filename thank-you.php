<?php

require_once('./includes/functions.php');

//die($_SESSION['customer_id']);

$_SESSION['shipping_address'];
$_SESSION['shipping_address2'];
$_SESSION['shipping_city'];
$_SESSION['shipping_state'];
$_SESSION['shipping_country'];
$_SESSION['shipping_zipcode'];

$orders = getOrderInfo($_SESSION['customer_id']);

//echo '<pre>'; print_r($orders); die();

$gateway = ($orders->data->{$orders->order_id[0]}->gateway_descriptor)!=''?$orders->data->{$orders->order_id[0]}->gateway_descriptor:'VERIFIED CBD';

$total = 0;
$shipping = 0;
$itemscount = 0;

$orderInfo = array();

foreach($orders->data as $order){
	$itemscount++;
	$orderInfo[$itemscount] = array();
	if(isset($site->shipping_id[$order->shipping_id])){
		$shipping += $site->shipping_id[$order->shipping_id];
		$price = $order->order_total - $shipping;
	} else {
		$price = $order->order_total;
	}
	$orderInfo[$itemscount]['name'] = $order->products[0]->name;
	$orderInfo[$itemscount]['price'] = $price;
	$total += floatval($price);

	//$price = (isset($site->shipping_id[$order->shipping_id]))?:$order->order_total;
	//echo $order->products[0]->name.' - '.$price.'<br>';
}
$totalws = $total+$shipping;

//echo ($shipping != '')?'shipping = '.$shipping.'<br>':'';
//die('total - '.($shipping+$total));


if($_GET['ism']==1){
	include('thank-you-m.php');
	die();
}

?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Thank You</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="icon" type="image/png" href="images/favicon-16x16.png">

		<style type="text/css">
			body {
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				color: #646464;
			}
			h1 {
				font-weight: 600;
    			color: #000;
    			margin-top: 50px;
    			margin-bottom: 25px;
			}
			h1 img {
				max-width: 45px;
    			vertical-align: top;
			}
			h3 {
				font-weight: 400;
    			letter-spacing: 0.5px;
    			margin-bottom: 25px;
			}
			h3 span {
				font-weight: 200;
			}
			header {
				background: #e4e4e4;
			}
			header img {
				max-width: 109px;
    			padding: 5px 0;
			}
			.container {
				max-width: 840px;
			}
			.yellow-div {
				background: #ffffec;
				margin-top: 15px;
			}
			.yellow-div img {
				width: 100%;
				max-width: 110px;
    			padding: 12px;
			}
			.yellow-div p {
				margin-bottom: 0;
				padding-top: 18px;
				color: #787100;
			}
			.yellow-div a {
				color: #787100;
				text-decoration: underline;
			}
			.contacts-div {
				margin-top: 30px;
				border-bottom: 1px solid #ddd;
			    padding-bottom: 40px;
			    margin-bottom: 20px;
			}
			.contacts .col-sm-3 {
				padding: 0;
			}
			.contacts .col-sm-9 {
				padding-top: 11px;
			}
			.contacts-div img {
				width: 100%;
				max-width: 69px;
			}
			.contacts p {
				margin-bottom: 0;
			}
			.contacts p a {
				color: #646464;
				font-size: 15px;
			}
			.headline {
				padding: 0;
    			background: #d7d7d7;
			}
			.headline p {
				margin-bottom: 0;
			    padding: 6px 10px;
			    font-size: 14px;
			}
			.price, .shipping {
				border-bottom: none !important;
			}
			.price, .shipping {
				border: 1px solid #ddd;
			    padding: 6px 10px;
			    font-size: 14px;
			}
			.total {
				font-size: 14px;
				background: #707070;
			    color: #fff;
			    padding: 6px 10px;
			}
			.price p, .shipping p, .total p {
				margin-bottom: 0;
			}
			.total-table {
				margin-bottom: 100px;
			}
			.logos {
				max-width: 279px !important;
				width: 100%;
			}
		</style>
	<?php include_once('includes/headaddons.php'); ?>
	</head>
	<body> 
		<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P788K96"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
		<header>
			<div class="container">
				<div class="row">
					<img src="images/verified-logo.png" alt="Verified CBD" />
				</div>
			</div>
		</header>
		<section>
			<div class="container">
				<div>
					<h1><img src="images/check2.png" /> Your Order is Confirmed</h1>
					<p>Thank You! Your order will be shipped within 1 business day! You can expect it to arrive in 3-5 days after shipment. We hope you enjoy the benefits of Verified CBD Oil.</p>
					<p>Your confirmation number is - <?php echo $_GET['order_id']; ?></p>
					<p>This order will appear on your credit card billing statement as <?php echo $site->descriptor; ?></p>
					
				</div>
				<div class="row yellow-div">
					<div class="col-sm-2">
						<img src="images/important.png" alt="Important" />
					</div>
					<div class="col-sm-10">
						<p><strong>IMPORTANT:</strong> If you do not see your email in your inbox, please check your spam folder. If you do not see an email within 60 minutes please contact us via email: <a href="mailto:info@verifiedcbdoil.com">info@verifiedcbdoil.com</a> or phone: <a href="tel:1 800-454-0472">+1 800-454-0472</a></p>
					</div>
				</div>
				<div class="row contacts-div">
					<div class="col-sm-12">
						<p>If you have any questions at all please contact:</p>
					</div>
					<div class="col-sm-4 contacts">
						<div class="row">
							<div class="col-sm-3">
								<img src="images/girl.png" />
							</div>
							<div class="col-sm-9">
								<p><strong>Jen Morgan</strong></p>
								<p class="email"><a href="mailto:Jen@verifiedcbdoil.com">Jen@verifiedcbdoil.com</a></p>
							</div>
						</div>
					</div>
					<div class="col-sm-4 contacts">
						<div class="row">
							<div class="col-sm-3">
								<img src="images/boy.png" />
							</div>
							<div class="col-sm-9">
								<p><strong>Mark Millwood</strong></p>
								<p class="email"><a href="mailto:Jen@verifiedcbdoil.com">Mark@verifiedcbdoil.com</a></p>							
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="row">
							<img class="logos" src="images/logos.png">
						</div>
					</div>
				</div>
				
				<div class="row total-table">
					<div class="col-sm-12 headline">
						<div class="row">
							<div class="col-sm-6">
						 		<p><strong>Product</strong></p>
						 	</div>
						 	<div class="col-sm-6">
						 		<p class="text-right">Price</p>
						 	</div>
						</div>
					</div>
						<?php
						foreach($orderInfo AS $item){
						?>
					<div class="col-sm-12 price">
						<div class="row">
							<div class="col-sm-8">
						 		<p><?php echo $item['name'];?></p>
						 	</div>
						 	<div class="col-sm-4">
						 		<p class="text-right">$<?php echo $item['price'];?></p>
						 	</div>
						</div>
					</div>
<?php
}
?>
					<div class="col-sm-12 shipping">
						<div class="row">
							<div class="col-sm-6">
						 		<p>Shipping & Handling</p>
						 	</div>
						 	<div class="col-sm-6">
						 		<p class="text-right">$<?php echo number_format((float)$shipping, 2, '.', ''); ?></p>
						 	</div>
						</div>
					</div>
					<div class="col-sm-12 total">
						<div class="row">
							<div class="col-sm-6">
						 		<p>TOTAL</p>
						 	</div>
						 	<div class="col-sm-6">
						 		<p class="text-right">$<?php echo number_format((float)$totalws, 2, '.', ''); ?></p>
						 	</div>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php include_once('includes/bodyaddons.php'); ?>
	</body>
</html>