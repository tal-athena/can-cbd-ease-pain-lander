<script>      
    function validateEmailAddress(email) {
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }

    function updateValidity(e, id) {
      
        var inpObj = document.getElementById(id);
        //console.log(id);
        if (!inpObj.checkValidity()) {
            inpObj.classList.remove("valid-field");
            inpObj.classList.add("invalid-field");
            if(id == "shipping_country" || id == "shipping_state"){
                inpObj.parentNode.classList.remove("passing-select");
                inpObj.parentNode.classList.add("failing-select");
            } else if(id == "shipping_email"){
                inpObj.parentNode.classList.remove("passing-email");
                inpObj.parentNode.classList.add("failing-email");
            } else {
                inpObj.parentNode.classList.remove("passing");
                inpObj.parentNode.classList.add("failing");
            }
        } else if ($("#shipping_firstname").val() == "") {
            inpObj.classList.remove("valid-field");
            inpObj.classList.add("invalid-field");
        } else {
            inpObj.classList.remove("invalid-field");
            inpObj.classList.add("valid-field");
            if(id == "shipping_country" || id == "shipping_state"){
                inpObj.parentNode.classList.remove("failing-select");
                inpObj.parentNode.classList.add("passing-select"); 
            } else if(id == "shipping_email"){
              /*
                inpObj.classList.remove("valid-field");
                inpObj.classList.add("invalid-field");
                inpObj.parentNode.classList.remove("passing-email");
                inpObj.parentNode.classList.add("failing-email"); 
                if(validateEmailAddress(document.getElementById("shipping_email").value) != false){
                    inpObj.classList.remove("invalid-field");
                    inpObj.classList.add("valid-field");
                    inpObj.parentNode.classList.remove("failing-email");
                    inpObj.parentNode.classList.add("passing-email");   
                }
                */
            } else {
                inpObj.parentNode.classList.remove("failing");
                inpObj.parentNode.classList.add("passing");    
            }
        } 
        
    };

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    function validateForm() {   
        var shipping_firstname1 = document.forms["frm"]["shipping_firstname"].value;
       
        var shipping_email1 = document.forms["frm"]["shipping_email"].value;
        var shipping_email1_tf = isEmail(shipping_email1);
        if ( shipping_firstname1 == "" || shipping_email1 == "" || !shipping_email1_tf) {
          console.log('form error!');
          //alert('Please fill in all fields or check your email address!');
          return false;
        } else {
            dataLayer.push({
              'event': 'addToCart',
              'ecommerce': {
                'currencyCode': 'USD',
                'add': {                              
                  'products': [{                       
                    'name': 'Full Spectrum CBD Oil 300mg (1%) 1oz Natural Flavor',
                    'id': '10'
                   }]
                }
              }
            });
          console.log('OK!');

          $('#frm').data('bootstrapValidator').resetForm();                
        }
      return true;
    }

</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P788K96');</script>
<!-- End Google Tag Manager -->