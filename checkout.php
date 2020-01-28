<?php

require_once('settings.php');

$_SESSION['shipping_address'];
$_SESSION['shipping_address2'];
$_SESSION['shipping_city'];
$_SESSION['shipping_state'];
$_SESSION['shipping_country'];
$_SESSION['shipping_zipcode'];

?>

<!DOCTYPE html>
<html lang="en" data-mobile-id="7253">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>100% Pure CBD Hemp Oil</title>
    <link rel="shortcut icon" href="#" type="image/png" />

    <!--
    <link rel="stylesheet" type="text/css" href="assets/css/style.min.css?v=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css?v=1">
-->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="assets/css/checkout.css" />
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="shortcut icon" href="./assets/images/favicon-16x16.png" type="image/png">

<?php include_once('includes/headaddons.php'); ?>

<style type="text/css" media="screen">
 .invalid-field {
    border: 3px solid red !important;
}

.valid-field {
    border: 3px solid #90ee90 !important;
}   
 
</style>

  </head>
  <body class="payment_form checkout" data-mobile-id="7253">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P788K96"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <header>
      <div class="container">
        <div class="row">
          <div class="col-12 d-flex justify-content-between">
            <img src="assets/images/VC logo.png" alt="logo" />
            <div class="logos d-none d-lg-block">
              <img src="assets/images/GMP-LOGO-1024x1024-e1462801725635 1.png" alt="icon" />
              <img src="assets/images/Group 61.png" alt="icon" />
            </div>
            <div class="security_icon d-flex d-lg-none align-self-center">
              <img src="assets/images/secure1.png" alt="secure" />
              <img src="assets/images/secure.png" alt="secure" />
            </div>
          </div>
        </div>
      </div>
    </header>
    
		
	
    <div class="container">
      <div class="row">
        <div class="col-lg-7">
          <h2 class="small">Please provide your billing and delivery information below.</h2>
          <div class="payment_block">
            <form name="frm" id="frm" method="post" action="/can-cbd-ease-pain/process/order.php<?php echo $query_string; ?>" onsubmit=" return validateFormCheckout();">
              <input type="hidden" id="hidden_autoship" name="autoship" value="0"> 
              <input type="hidden" name="prospect_id" value="<?php echo $_GET['prospectId']; ?>">
              <h3><span>1</span>Shipping address</h3>
              <div class="main_form">
                <div class="form-group" style="display: none;">
                  <label for="country">Country</label>
                  <select size="1" name="shipping_country" id="shipping_country" class="form-control input-field required" data-validation="required">
                      <option value='US' selected >United States</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="country">Address</label>
                  <input type="text" class="form-control input-field required" id="shipping_address" name="shipping_address" value="" placeholder="Shipping Address" data-validation="required" oninput="updateValidity(event, 'shipping_address')"/>
                </div>
                <div class="form-group">
                  <label for="country">City</label>
                  <input type="text" class="form-control input-field required" id="shipping_city" name="shipping_city" value="" placeholder="City" data-validation="required" oninput="updateValidity(event, 'shipping_city')"/>
                </div>
                <div class="form-group">
                  <label for="state">State</label>
                  <select size="1" name="shipping_state" id="shipping_state" class="form-control input-field valid-field required" data-validation="required" oninput="updateValidity(event, 'shipping_state')">
                        
                        <option value='AL' onclick='' selected >Alabama (AL)</option>
                        <option value='AK' onclick=''   >Alaska (AK)</option>
                        <option value='AZ' onclick=''   >Arizona (AZ)</option>
                        <option value='AR' onclick=''   >Arkansas (AR)</option>
                        <option value='CA' onclick=''   >California (CA)</option>
                        <option value='CO' onclick=''   >Colorado (CO)</option>
                        <option value='CT' onclick=''   >Connecticut (CT)</option>
                        <option value='DE' onclick=''   >Delaware (DE)</option>
                        <option value='FL' onclick=''   >Florida (FL)</option>
                        <option value='GA' onclick=''   >Georgia (GA)</option>
                        <option value='GU' onclick=''   >Guam (GU)</option>
                        <option value='HI' onclick=''   >Hawaii (HI)</option>
                        <option value='ID' onclick=''   >Idaho (ID)</option>
                        <option value='IL' onclick=''   >Illinois (IL)</option>
                        <option value='IN' onclick=''   >Indiana (IN)</option>
                        <option value='IA' onclick=''   >Iowa (IA)</option>
                        <option value='KS' onclick=''   >Kansas (KS)</option>
                        <option value='KY' onclick=''   >Kentucky (KY)</option>
                        <option value='LA' onclick=''   >Louisiana (LA)</option>
                        <option value='ME' onclick=''   >Maine (ME)</option>
                        <option value='MD' onclick=''   >Maryland (MD)</option>
                        <option value='MA' onclick=''   >Massachusetts (MA)</option>
                        <option value='MI' onclick=''   >Michigan (MI)</option>
                        <option value='MN' onclick=''   >Minnesota (MN)</option>
                        <option value='MS' onclick=''   >Mississippi (MS)</option>
                        <option value='MO' onclick=''   >Missouri (MO)</option>
                        <option value='MT' onclick=''   >Montana (MT)</option>
                        <option value='NE' onclick=''   >Nebraska (NE)</option>
                        <option value='NV' onclick=''   >Nevada (NV)</option>
                        <option value='NH' onclick=''   >New Hampshire (NH)</option>
                        <option value='NJ' onclick=''   >New Jersey (NJ)</option>
                        <option value='NM' onclick=''   >New Mexico (NM)</option>
                        <option value='NY' onclick=''   >New York (NY)</option>
                        <option value='NC' onclick=''   >North Carolina (NC)</option>
                        <option value='ND' onclick=''   >North Dakota (ND)</option>
                        <option value='OH' onclick=''   >Ohio (OH)</option>
                        <option value='OK' onclick=''   >Oklahoma (OK)</option>
                        <option value='OR' onclick=''   >Oregon (OR)</option>
                        <option value='PA' onclick=''   >Pennsylvania (PA)</option>
                        <option value='PR' onclick=''   >Puerto Rico (PR)</option>
                        <option value='RI' onclick=''   >Rhode Island (RI)</option>
                        <option value='SC' onclick=''   >South Carolina (SC)</option>
                        <option value='SD' onclick=''   >South Dakota (SD)</option>
                        <option value='TN' onclick=''   >Tennessee (TN)</option>
                        <option value='TX' onclick=''   >Texas (TX)</option>
                        <option value='UT' onclick=''   >Utah (UT)</option>
                        <option value='VT' onclick=''   >Vermont (VT)</option>
                        <option value='VA' onclick=''   >Virginia (VA)</option>
                        <option value='WA' onclick=''   >Washington (WA)</option>
                        <option value='WV' onclick=''   >West Virginia (WV)</option>
                        <option value='WI' onclick=''   >Wisconsin (WI)</option>
                        <option value='WY' onclick=''   >Wyoming (WY)</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="country">ZIP Code</label>
                  <input type="text" class="form-control input-field required" id="shipping_zipcode" name="shipping_zipcode" value="" placeholder="Zip Code" data-validation="required" oninput="updateValidity(event, 'shipping_zipcode')"/>
                </div>
              </div>

              <input id="product" type="hidden" name="product" value='1' />
              

              <div class="payment_header d-flex justify-content-between">
                <h3><span>2</span>Payment</h3>
                <div class="d-flex">
                  <h4>We accept:</h4>
                  <img src="assets/images/Bitmap.png" alt="Payment" />
                  <img src="assets/images/Bitmap (1).png" alt="Payment" />
                </div>
              </div>
              <div class="card_block">
                <div class="form-group">
                  <select name="cardtype" id="billing_cardtype" class="form-control valid-field" required>
                    <option value="VISA" selected="selected">VISA</option>
                    <option value="master">Mastercard</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="cardNumber">Card number</label>
                  <input id="card-number" class="form-control required" placeholder="xxxx xxxx xxxx xxxx" type="tel" name="card_number" minlength="13" maxlength="16"  autocomplete="cc-number" data-validation="required" data-threeds="pan" oninput="updateValidity(event, 'card-number')">
                </div>
                <!-- <div class="form-group">
                  <label for="nameOfCard">Name on card</label>
                  <input placeholder="Enter card holders name" class="form-control" id="nameOfCard" type="text" />
                </div> -->
                <div class="d-flex form-group date">
                  <select name="exp_month" id="billing_cardexp_month" class="form-control" required>
                      <option value="01" selected="selected" >01 - January</option>
                      <option value="02">02 - February</option>
                      <option value="03">03 - March</option>
                      <option value="04">04 - April</option>
                      <option value="05">05 - May</option>
                      <option value="06">06 - June</option>
                      <option value="07">07 - July</option>
                      <option value="08">08 - August</option>
                      <option value="09">09 - September</option>
                      <option value="10">10 - October</option>
                      <option value="11">11 - November</option>
                      <option value="12">12 - December</option>
                  </select>
                  <select name="exp_year" id="billing_cardexp_year" class="form-control" required>
                      <option value="20" selected="selected">2020</option>
                      <option value="21">2021</option>
                      <option value="22">2022</option>
                      <option value="23">2023</option>
                      <option value="24">2024</option>
                      <option value="25">2025</option>
                      <option value="26">2026</option>
                      <option value="27">2027</option>
                      <option value="28">2028</option>
                      <option value="29">2029</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="cvv">Security code / CVV</label>
                  <input id="cvv" class="form-control required CVV" type="tel" name="cvv" minlength="3" maxlength="3" placeholder="xxx" autocomplete="cc-csc" data-validation="required" oninput="updateValidity(event, 'cvv')">
                </div>
              </div>
               <div class="text-center">

            <button type="submit" class="btn_bg" id="showpopup" style="border-radius: 10px;border: solid 1.1px #cb6d00 !important;background-color: #e77c00;box-shadow: none !important;width: 80%;">
              <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
               d="M21.0246 4.57734C21.4307 4.75781 21.7465 4.9834 22.0172 5.34434C22.2428 5.70527 22.3781 6.11133 22.3781 6.5625C22.3781 9.67559 21.7916 12.518 20.6637 15.0896C19.6711 17.2553 18.3176 19.1502 16.6934 20.7744C15.2947 22.1279 13.851 23.1205 12.3621 23.707C11.8207 23.9777 11.2793 23.9777 10.7379 23.707C9.02344 23.0303 7.44434 21.9023 6.00059 20.3684C4.37637 18.7441 3.1582 16.8041 2.25586 14.5482C1.21816 12.0668 0.721875 9.40488 0.721875 6.5625C0.721875 6.11133 0.812109 5.70527 1.08281 5.34434C1.3084 4.9834 1.62422 4.75781 2.07539 4.57734L10.7379 0.967968C11.2793 0.742382 11.8207 0.742382 12.3621 0.967968L21.0246 4.57734ZM11.55 21.7219C12.9938 21.1354 14.3924 20.1428 15.6557 18.7441C17.0092 17.3004 18.092 15.5859 18.9041 13.6008C19.7613 11.4352 20.2125 9.08906 20.2125 6.5625L11.55 2.95312L2.8875 6.5625C2.8875 8.99883 3.29355 11.2998 4.15078 13.4654C4.91777 15.4506 6.00059 17.2102 7.3541 18.6539C8.61738 20.0977 10.016 21.0902 11.55 21.7219ZM18.2273 9.35977C18.3176 9.26953 18.3627 9.1793 18.3627 8.99883C18.3627 8.86348 18.3176 8.72812 18.2273 8.59277L17.1896 7.6002C17.0994 7.50996 16.9641 7.41973 16.8287 7.41973C16.6482 7.41973 16.5129 7.50996 16.4227 7.6002L10.0611 13.9166L7.3541 11.1645C7.26387 11.0742 7.12852 11.0291 6.99316 11.0291C6.8127 11.0291 6.67734 11.0742 6.58711 11.1645L5.59453 12.2021C5.45918 12.2924 5.41406 12.4277 5.41406 12.5631C5.41406 12.7436 5.45918 12.8789 5.54941 12.9691L9.65508 17.0748C9.74531 17.2102 9.88066 17.2553 10.0611 17.2553C10.1965 17.2553 10.3318 17.2102 10.4221 17.0748L18.2273 9.35977Z" fill="white" />
                </svg>
                SUBMIT MY ORDER
                </button> </div>
              <p>
                By placing an order, I confirm I have read and agree with the Terms and Conditions, Privacy Policy and
                Shipping and Returns Policy
              </p>
              <p>Charges on your statement will appear as VerifiedOffer442037463200</p>
              <p>Your bank may charge international processing fees</p>
            </form>
          </div>
        </div>
        <div class="col-lg-5 ">
          <div class="card_section">
            <div class="card_header">
              <h3>Order summary</h3>
            </div>
            <div class="card_body ">
              <div class="d-flex justify-content-between goods">
                <img style="width:100px; height:auto" src="assets/images/cream-pain-rub 1.png" alt="oil" />
                <div class="align-self-center" style="margin-left:10px;">
                  <h4 style ="margin-bottom: 10px !important;">Hemp Intensive Healing Pain Rub</h4>
                  <div class="d-flex justify-content-between">
                    <span style="font-family: Flama;font-size: 15px;">Qty: 1</span>
                    <div>
                      <span style="font-family: Lato;font-size:15px; text-decoration: line-through; color: #616161;">$105.99</span>
                      <span style="font-family: Flama;font-size: 14.5219px; font-weight:500; color: #DB0000;">$47.95</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="price">
                <h2>
                  Sub total:
                  <span>$105.99</span>
                </h2>
                <h2>
                  Shipping and handling
                  <span>FREE</span>
                </h2>
                <h2 style="color:#DB0000;">
                  Discount:
                  <span>-$58.04</span>
                </h2>
                <hr>
                <h3>Total (USD) <span>$47.95</span></h3>
              </div>
              <div class="card_footer d-flex">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M10.5 0.736876C12.2263 0.736876 13.8742 1.20769 15.3651 2.07084C16.856 2.934 18.033 4.11103 18.8962 5.60194C19.7593 7.09284 20.2301 8.74069 20.2301 10.467C20.2301 12.2325 19.7593 13.8412 18.8962 15.3321C18.033 16.823 16.856 18.0392 15.3651 18.9024C13.8742 19.7655 12.2263 20.1971 10.5 20.1971C8.73445 20.1971 7.12584 19.7655 5.63494 18.9024C4.14403 18.0392 2.92777 16.823 2.06461 15.3321C1.20145 13.8412 0.769875 12.2325 0.769875 10.467C0.769875 8.74069 1.20145 7.09284 2.06461 5.60194C2.92777 4.11103 4.14403 2.934 5.63494 2.07084C7.12584 1.20769 8.73445 0.736876 10.5 0.736876ZM10.5 2.62013C9.08756 2.62013 7.75359 2.97323 6.57656 3.67945C5.3603 4.38567 4.41867 5.36653 3.71245 6.54356C3.00623 7.75983 2.65313 9.05456 2.65313 10.467C2.65313 11.8794 3.00623 13.2134 3.71245 14.3904C4.41867 15.6067 5.3603 16.5483 6.57656 17.2545C7.75359 17.9608 9.08756 18.3139 10.5 18.3139C11.9124 18.3139 13.2072 17.9608 14.4234 17.2545C15.6005 16.5483 16.5813 15.6067 17.2875 14.3904C17.9938 13.2134 18.3469 11.8794 18.3469 10.467C18.3469 9.05456 17.9938 7.75983 17.2875 6.54356C16.5813 5.36653 15.6005 4.38567 14.4234 3.67945C13.2072 2.97323 11.9124 2.62013 10.5 2.62013ZM15.9928 7.72059C16.0713 7.8383 16.1497 7.956 16.1497 8.0737C16.1497 8.23064 16.0713 8.30911 15.9928 8.38758L9.2445 15.0967C9.1268 15.2144 9.00909 15.2536 8.89139 15.2536C8.73445 15.2536 8.65598 15.2144 8.57752 15.0967L5.00719 11.5263C4.88948 11.4479 4.85025 11.3302 4.85025 11.1732C4.85025 11.0555 4.88948 10.9378 5.00719 10.8593L5.90958 9.95695C5.98805 9.87848 6.06652 9.83925 6.22345 9.83925C6.34116 9.83925 6.45886 9.87848 6.57656 9.95695L8.89139 12.3503L14.4627 6.8182C14.5411 6.73973 14.6196 6.7005 14.7765 6.7005C14.8942 6.7005 15.012 6.77897 15.1297 6.85744L15.9928 7.72059Z"
                    fill="#11B800"
                  />
                </svg>
                <p>You’ve <span style="color: #0aad20;"><b>saved $58.04</b></span> today!</p>
              </div>
            </div>
          </div>
	  		<div class="d-flex justify-content-between goods" style="margin-left: 50px;margin-top: 25px;">
				<img src="assets/images/security_seals.png" alt="oil">
			</div>
        </div>
      </div>
    </div>
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
        <div class="row align-items-center justify-content-between">
          <div class="col">
            <p>Verified CBD, 1031 Ives Dairy Road, Miami, FL 33179</p>
          </div>
          <div>
            <img src = "assets/images/visa_master.png">
          </div>
        </div>
      </div>
    </div>
    <div class="container terms">
      <div class="row">
        <div class="col-12">
          <p>
            This product is not for use by or sale to persons under the age of 21. This product should be used only as
            directed on the label. It should not be used if you are pregnant or nursing. Consult with a physician before
            use if you have a serious medical condition or use prescription medications. A Doctor’s advice should be
            sought before using this and any supplemental dietary product. All trademarks and copyrights are property of
            their respective owners and not affiliated with nor do they endorse this product. These statements have not
            been evaluated by the FDA. This product is not intended to diagnose, treat, cure or prevent any disease.
            Individual weight loss results will vary. By using this site you agree to follow the Privacy Policy and all
            Terms & Conditions printed on this site. Void Where Prohibited By Law.
          </p>
          <h3 class="d-lg-none d-block">© 2014-2019 Verifiedcbd.com all rights Reserved</h3>
        </div>
      </div>
    </div>

<script src="assets/js/jquery-3.4.1.min.js"></script>
<!--
<script src="js/jquery-1.11.3.min.js" defer></script>



<script src="js/jquery.form-validator.min.js" defer></script>
-->
<script type="text/javascript">
function validateFormCheckout() {   
              var shipping_address1 = document.forms["frm"]["shipping_address"].value;
             
              var shipping_city1 = document.forms["frm"]["shipping_city"].value;
              var shipping_zipcode1 = document.forms["frm"]["shipping_zipcode"].value;
              var card_number1 = document.forms["frm"]["card-number"].value;
              var cvv1 = document.forms["frm"]["cvv"].value;
            
              if ( shipping_address1 == "" || shipping_city1 == "" || shipping_zipcode1 == "" || card_number1 == "" || cvv1 == "") {
                console.log('form error!');
                alert('Please fill in all fields!');
                return false;
              } else {
                console.log('OK!');
              }
            return true;
        }

    function updateValidity(e, id) {
        var inpObj = document.getElementById(id);
        if (inpObj.value == "") {
            inpObj.classList.remove("valid-field");
            inpObj.classList.add("invalid-field");
        } else {
            if(inpObj.id == "card-number") {
              var c_num = inpObj.value; 
              if(c_num.length != 16){
                  inpObj.classList.remove("valid-field");
                  inpObj.classList.add("invalid-field");
              } else {
                  inpObj.classList.remove("invalid-field");
                  inpObj.classList.add("valid-field");    
              }
            } else if(inpObj.id == "cvv") {
              var c_cvv = inpObj.value;
              if(c_cvv.length != 3){
                  inpObj.classList.remove("valid-field");
                  inpObj.classList.add("invalid-field");
              } else {
                  inpObj.classList.remove("invalid-field");
                  inpObj.classList.add("valid-field");    
              }
            } else {
              inpObj.classList.remove("invalid-field");
              inpObj.classList.add("valid-field");  
            }
        } 
    };

</script>

<!-- GTM checkout script -->
<script>
dataLayer.push({
    'event': 'checkout',
    'ecommerce': {
      'checkout': {
        'actionField': {'step': 1},
        'products': [{
          'name': 'Hemp Intensive Healing Pain Rub',
          'id': '15'
       }]
     }
   }
  });
<!-- End GTM view script -->
</script>
  </body>
</html>

