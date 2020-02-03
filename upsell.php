<?php

include_once 'settings.php';

$thisstep = 2;

$_SESSION['shipping_address2'];
$_SESSION['shipping_city'];
$_SESSION['shipping_state'];
$_SESSION['shipping_country'];
$_SESSION['shipping_zipcode'];

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--[if lt IE 9]>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <![endif]-->
    <title>Verified CBD - Joint and Inflamation Relief </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW" />
    <meta name="googlebot" content="noindex" />
    <meta name="Slurp" content="noindex" />
    <link rel="icon" type="image/png" href="images/favicon-16x16.png">

    <script type="text/javascript" src="assets/js/jquery-3.4.1.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Oswald:500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/upsell.css">

    <?php include_once('includes/headaddons.php'); ?>

</head>

<body>
    <div class="container-fluid" style="background: #D11836; height: 2px;">
    </div>
    <div class="container-fluid" style="background: #fff; padding-top: 30px; padding-bottom: 30px; position: relative;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-6">
                    <img src="./assets/images/VC%20logo.png" alt="logo">
                </div>
                <div class="col-md-4 col-6" style="text-align:right;">
                    <img src="assets/images/GMP_icon.png" alt="GMP">
                    <img style="margin-left: 20px;" src="./assets/images/USA_icon.png" alt="USA">
                </div>
            </div>			
            <div class="d-none" style="position: absolute; top: 0px; left: 80%;">
                <img src="./assets/images/Money_Back.png">
                <span style="position: absolute; font-size: 22px; color: #fff; left: 23%; top: 6px;">60</span>
            </div>
        </div>
    </div>
    <div class="container mainbody">

        <form name="is-upsell" class="is-upsell" id="upsell_form"
            action="/can-cbd-ease-pain/process/up.php?<?php echo $querystring; ?>" accept-charset="utf-8"
            enctype="application/x-www-form-urlencoded;charset=utf-8" method="post">
            <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>">
            <input type="hidden" name="step" id="step" value="2">
        </form>

        <div class="text-center specialoffer">
            <span style="color: #ff0000; ">WAIT!</span><span> We have a Special Offer for you!</span>
        </div>
        <div class="box text-center">
            Offer Expires In
        </div>
        <div class="time-box">
            <div class="minute-text">00<span>MINUTES<span></div>
            <div class="minute-text align-self-center">:</div>
            <div class="minute-text" id="second">59<span>SECONDS<span></div>
        </div>
        <div class="col-md-12 d-none d-sm-block" style="margin-bottom:5px;">
            <img style="width:100%;" src="assets/images/splitter.png">
        </div>

        <div class="row">
            <div class="col-md-5 col-12 text-center" style="margin-bottom:5px;">
                <img style="vertical-align:top; width:100%;"
                    src="assets/images/hemp-intensive-healing-pain-rub-with-emu-oil-cbd-oil-skin-care-cream-1.jpg">
            </div>
            <div class="col-md-6 col-12">
                <p class="capsules_off" style="margin-bottom: 0px;">Hemp Intensive Pain Relief Rub | <span
                        style="color: #AE2D1E;">50% OFF!</span></p>
                <p style="margin-bottom:10px;">
                    <img src="./assets/images/stars.png">
                    <span
                        style="margin-left: 10px;font-size: 17px;font-weight: 500;color: #CD9C2F; vertical-align: middle;">Rated
                        Excellent</span>
                </p>

                <div style="text-align:justify;"><b>Natural way to relieve pain. Say goodbye to Sore Muscles, Joint
                        Pain, Aches & More</b></div>
                <br />


                <div style="font-size: 23px; text-decoration: line-through;color: #616161;">
                    Was: $105.99
                </div>
                <div style="margin-top:-5px;">
                    <span style="font-size: 23.4px;">Sale:</span>
                    <span style="color: #AE2D1E; font-size: 23.4px; font-weight: bold;"><sup
                            style="top:-.3em">$</sup>34<sup style="top:-.25em">.99</sup></span>
                </div>


                <div style="margin-top:10px; margin-bottom:20px;">
                    <img src="assets/images/path.png">
                    <span class="feature_bene">Contains non-GMO</span>
                    <br>
                    <img src="assets/images/path.png">
                    <span class="feature_bene">Organically grown</span>
                    <br>
                    <img src="assets/images/path.png">
                    <span class="feature_bene">High quality CBD (USA made)</span>
                    <br>

                </div>
                <a href="#" onclick="submitUpsell()" class="btn col-md-12"
                    style="background: #F0812E; text-align: center; color: #fff; font-size: 20.3085px;font-weight: bold; padding:10px;">
                    <img style="margin-top: -2px; height: 20px; width: auto;"
                        src="assets/images/right_double_arrow.png"> YES! UPGRADE MY ORDER
                </a>

                <a href="/<?php echo $declineLink; ?>" class="btn col-md-10 offset-md-1"
                    style="background: #898989; text-align: center; color: #fff; margin-top: 10px; padding:8px;">
                    No thanks, I'll pass
                </a>

            </div>
        </div>
    </div>
    <div class="container text-center" style="color: #616161;">
        Ingredients: Purified Water, Emu Oil, Aloe Barbadensis Leaf Extract, Squalane, Glycerin, Stearic Acid, Cetyl
        Alcohol, Stearyl Alcohol, Ethylene Glycol Distearate, Menthol, Cetyl Phosphate, PCR Hemp Oil, Arnica Montana
        Flower Extract, Boswellia Serrata Extract, Allantoin, Phenoxyethanol, Caprylyl Glycol, Potassium Sorbate,
        Hexylene Glycol, Disodium EDTA, Tocopheryl Acetate (Vitamin E).
    </div>
</body>
<footer>
    <div class="container-fluid prefooter">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="tel:1 (800) 454 0472 ">1 (800) 454 0472</a>
                            <a href="mailto:info@verifiedcbdoil.com"> info@verifiedcbdoil.com</a>
                        </div>
                        <div>
                            <a href="/can-cbd-ease-pain/terms.php" target="_blank">Terms and Conditions</a>
                            <a href="/can-cbd-ease-pain/privacy.php" target="_blank">Privacy Policy</a>
                            <a href="/can-cbd-ease-pain/refund.php" target="_blank">Refund Policy</a>
                            <a href="/can-cbd-ease-pain/contact.php" target="_blank">Contact Us</a><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>Verified CBD, 1031 Ives Dairy Road, Miami, FL 33179</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container terms">
        <div class="row">
            <div class="col-12">
                <p>
                    This product is not for use by or sale to persons under the age of 21. This product should be used
                    only as
                    directed on the label. It should not be used if you are pregnant or nursing. Consult with a
                    physician before
                    use if you have a serious medical condition or use prescription medications. A Doctor’s advice
                    should be
                    sought before using this and any supplemental dietary product. All trademarks and copyrights are
                    property of
                    their respective owners and not affiliated with nor do they endorse this product. These statements
                    have not
                    been evaluated by the FDA. This product is not intended to diagnose, treat, cure or prevent any
                    disease.
                    Individual weight loss results will vary. By using this site you agree to follow the Privacy Policy
                    and all
                    Terms & Conditions printed on this site. Void Where Prohibited By Law.
                </p>
                <h3 class="d-lg-none d-block">© 2014-2019 Verifiedcbd.com all rights Reserved</h3>
            </div>
        </div>
    </div>
</footer>
<?php
if(isset($_GET['decline'])){
?>
<div class="modal-bg">
    <div class="modal-info">
        <h3>ERROR</h3>
        <p><?php echo $_GET['decline']; ?></p>
    </div>
</div>
<?php
}
?>

</html>

<script type="text/javascript">
var myVar = setInterval(myTimer, 1000);
var current = 59;

function myTimer() {

    current--;
    if (current == 0) {
        clearInterval(myVar);
    }


    var val = current;
    if (current < 10)
        val = "0" + val;

    document.getElementById("second").innerHTML = val + '<span>SECONDS<span>';

}
</script>

<script type="text/javascript">
submitflag = false;

function submitUpsell() {
    if (!submitflag) {
        document.getElementById("upsell_form").submit();
        dataLayer.push({
            'event': 'submitUpsell'
        });
        submitflag = true;
    }
}

$(document).ready(function() {
    $('.modal-bg').click(function() {
        //alert('do it');
        $('.modal-bg').hide();
    });
});

var down = true;
var value = 11;
var increment = 1;
var ceiling = 2;
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

<!-- GTM purchase script -->
<script>
var totalRevenue = 0 + 47.95; // shipping + product cost
var orderId = <?php echo $_GET['order_id']; ?>;
dataLayer.push({ // purchase event GA
  'event': 'purchase',
  'ecommerce': {
    'purchase': {
        'actionField': {
        'id': orderId,              
        'revenue': totalRevenue,                     
        'shipping': 0,
        'tax': 0
      },
      'products': [{                            
        'name': 'Hemp Intensive Healing Pain Rub',    
        'id': '15',
        'price': 47.95,
        'quantity': 1
       }]
    }
  }
});
</script>
<!-- End GTM purchase script -->

<?php include_once('includes/bodyaddons.php'); ?>