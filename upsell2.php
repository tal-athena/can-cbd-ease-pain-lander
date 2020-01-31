<?php

include_once './includes/functions.php'; // function for order info
include_once 'settings.php';

$_SESSION['shipping_address'];
$_SESSION['shipping_address2'];
$_SESSION['shipping_city'];
$_SESSION['shipping_state'];
$_SESSION['shipping_country'];
$_SESSION['shipping_zipcode'];

$thisstep = 3;
$next_number = $site->step[$thisstep]->next;
if($next_number == 'thanks'){
	$next_location = $site->thanks_page_location;
} else {
	$next_location = $site->step[$next_number]->page_location;
}

$remove = array('decline');

$querystring = '';

foreach($_GET AS $key => $value){
	if(!in_array($key, $remove)){
		$querystring .= $key.'='.$value.'&';
	}
}
$declineLink = $next_location.'?'.$querystring;

?><!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <!--[if lt IE 9]>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <![endif]-->
	    <title>Verified CBD - Pain Relief</title>
	    <meta name="description" content="">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"/>
	    <meta name="googlebot" content="noindex"/>
	    <meta name="Slurp" content="noindex"/>
		<link rel="icon" type="image/png" href="images/favicon-16x16.png">
		
		<script src="js/jquery.min.js" type="text/javascript"></script>

		<link href="https://fonts.googleapis.com/css?family=Oswald:500,600,700&display=swap" rel="stylesheet">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style type="text/css">
			.modal-bg {
				position: fixed;
			    top: 0;
			    width: 100%;
			    height: 100%;
			    background-color: rgba(0,0,0,.5)
			}
			.modal-info {
				background: white;
			    width: 40%;
			    position: absolute;
			    top: 50%;
			    left: 50%;
			    transform: translate(-50%, -50%);
			    border-radius: 10px;
			    padding: 20px;
			    text-align: center;
			    color: #c00;
			}
			.upsell {
				background: rgb(230,230,230);
                background: linear-gradient(90deg, rgba(230,230,230,1) 0%, rgba(251,251,251,1) 20%, rgba(251,251,251,1) 30%, rgba(255,255,255,1) 50%, rgba(251,251,251,1) 70%, rgba(251,251,251,1) 80%, rgba(230,230,230,1) 100%);
                border-bottom: 2px solid #dfdfdf;
			}
			header {
				padding: 15px 0 0;
				position: relative;
			}
			header img {
				max-width: 300px;
				width: 100%;
			}
			.ribbon {
			  width: 150px;
			  height: 150px;
			  overflow: hidden;
			  position: absolute;
			}
			.ribbon::before,
			.ribbon::after {
			  position: absolute;
			  z-index: -1;
			  content: '';
			  display: block;
			  border: 5px solid #2980b9;
			}
			.ribbon span {
			  position: absolute;
			  display: block;
			  width: 225px;
			  padding: 13px 0;
			  background-color: #cc0000;
			  box-shadow: 0 5px 10px rgba(0,0,0,.1);
			  color: #fff;
			  font: 700 14px/1 'Lato', sans-serif;
			  text-shadow: 0 1px 1px rgba(0,0,0,.2);
			  text-transform: uppercase;
			  text-align: center;
			}
			/* top left*/
			.ribbon-top-left {
			  top: -10px;
			  left: -10px;
			}
			.ribbon-top-left::before,
			.ribbon-top-left::after {
			  border-top-color: transparent;
			  border-left-color: transparent;
			}
			.ribbon-top-left::before {
			  top: 0;
			  right: 0;
			}
			.ribbon-top-left::after {
			  bottom: 0;
			  left: 0;
			}
			.ribbon-top-left span {
			  right: -16px;
			  top: 32px;
			  transform: rotate(-45deg);
			}
			hr {
				margin-top: 10px;
			}
			.upsell .main {
				max-width: 750px;
				width: 100%;
				margin: 0 auto;
			}
			.main .expire {
			    font-weight: 500;
			    font-size: 14px;
			    color: #d10101;
			}
			h1 {
				font-weight: bold;
    			color: #000;
			}
			.subtitle {
				font-size: 19px;
			    line-height: 23px;
			    font-weight: 500;
			    color: #4b4b4b;
			    margin-top: 20px;
			}
			.prod-img {
				max-width: 600px;
				width: 100%;
			}
			.available {
				color: #d10101;
			    font-family: "Oswald", "Helvetica Neue", Helvetica, Arial, sans-serif;
			    font-size: 23px;
			    padding-top: 15px;
			}
			.up-btn { margin-bottom: 10px; }
			.up-btn img {
				max-width: 300px;
				width: 100%;
			}
			.no-btn img {
				max-width: 300px;
				width: 100%;
			}
			.no-btn { margin-bottom: 15px; }

			.decline {
				text-align: center;
			    margin-left: 40px;
			    padding-top: 15px;
			    font-size: 18px;
			    font-weight: 500;
			    color: #aaaaaa;
			    letter-spacing: -0.5px;
    			padding-bottom: 35px;
			}
			.decline span {
				background: #b4b4b4;
			    color: #eeeeee;
			    padding: 1px 3px;
			    border-radius: 50%;
			    font-size: 8px;
			}
			footer img {
				max-width: 170px;
    			padding: 30px 0 20px;
			}
			
			.copyright {
				text-align: center;
				font-size: 14px;
			}
			
			.pulse{
				animation-name: pulse;
				-webkit-animation-name: pulse;	
				animation-duration: 1.5s;	
				-webkit-animation-duration: 1.5s;
				animation-iteration-count: infinite;
				-webkit-animation-iteration-count: infinite;
			}
			
			@keyframes pulse {
				0% {
					transform: scale(0.9);
					opacity: 0.9;		
				}
			
				50% {
					transform: scale(1);
					opacity: 1;	
				}	
			
				100% {
					transform: scale(0.9);
					opacity: 0.9;	
				}			
			}
			
			@-webkit-keyframes pulse {
				0% {
					-webkit-transform: scale(0.95);
					opacity: 0.9;		
				}
			
				50% {
					-webkit-transform: scale(1);
					opacity: 1;	
				}	
			
				100% {
					-webkit-transform: scale(0.95);
					opacity: 0.9;	
				}			
			}

			
			.blinking {
				animation:blinkingText 0.9s infinite;
			}
			@keyframes blinkingText{
				0%{		color: #c00a2c;	}
				49%{	color: #c00a2c;	}
				50%{	color: transparent;	}
				99%{	color:#c00a2c;	}
				100%{	color: #c00a2c;	}
			}
			@media(max-width: 767px) {
				.upsell {
					background: #fff;
				}
				.decline, .up-btn img, footer img, .available {
					margin-left: 0;
				}
				footer img {
					width: 90%;
				}
			}
		</style>
<?php include_once('includes/headaddons.php'); ?>

	</head>
	<div class="upsell">
		<header>
			<div class="ribbon ribbon-top-left"><span>SPECIAL OFFER</span></div>
			<center><img src="images/steps2.png"></center>
		</header>
		<hr>
		<form name="is-upsell" class="is-upsell" id="upsell_form" action="/can-cbd-ease-pain/process/up.php?<?php echo $querystring; ?>" accept-charset="utf-8" enctype="application/x-www-form-urlencoded;charset=utf-8" method="post">
			<input type="hidden" id="order_id" name="order_id" value="<?php echo $_GET['order_id']; ?>">
			<input type="hidden" name="step" id="step" value="3">
		</form>

		<div class="main">
			<p class="expire text-center pulse" style="font-size: 16px">This Offer Expires When Sold Out!</p>
			<h1 class="text-center"><span style="color: #ff0000;">Wait!</span><br>Your order is not complete...</h1>
			<p class="text-center subtitle">You qualify for this <b>bonus discounted</b> offer...</p>		
			<center><img class="prod-img" src="images/upsell1.jpg"></center>
			<p class="text-center" style="font-size: 12px; color: #666;"><b>Ingredients:</b> Hemp-Derived Cannabidiol, Rice Flour, Vegetable Cellulose, Magnesium Steartate, Silivon Dioxide.</p>
			<p class="available text-center">ONLY <span id="counter">19</span> LEFT!</p>
			<div class="up-btn">
				<a href="#" onclick="submitUpsell()"><center><img src="images/up1_button.png"></center></a>
			</div>
			<div class="no-btn">
				<a href="/<?php echo $declineLink; ?>"><center><img src="images/up1no.png"></center></a>
			</div>
			
		</div>
	</div>
	<footer>
		<center><img src="images/secure-logo.png"></center>
		<p class="copyright">&copy; <?php echo date("Y"); ?> Verified CBD.  All Rights Reserved</p>
	</footer>
<?php
if(isset($_GET['decline'])){
?>
<div class="modal-bg"><div class="modal-info"><h3>ERROR</h3><p><?php echo $_GET['decline']; ?></p></div></div>
<?php
}
?>
</html>
<script type="text/javascript">
	submitflag = false;
    function submitUpsell() {
	    if(!submitflag){
		    document.getElementById("upsell_form").submit();
		    dataLayer.push({'event': 'submitUpsell'});
		    submitflag = true;
	    }
    }

	$(document).ready(function() {
		$('.modal-bg').click(function(){
			//alert('do it');
			$('.modal-bg').hide();
		});
	});
	
	var down = true;
	var value = 22;
	var increment = 1;
	var ceiling = 3;
	var interval = setInterval(PerformCalc, 20000);
	
	function PerformCalc() {
		if (down == true && value >= ceiling) {
	    	value -= increment
	
		    if (value == ceiling) {
		      down = false;
		    }
		} else {
	      down = false;
	
	      if (value == 3) {
	        down = false;  
	      }
	       clearInterval(interval);
		}
		document.getElementById('counter').innerHTML = value;
	}
	
</script>

<?php include_once('includes/bodyaddons.php'); ?>
