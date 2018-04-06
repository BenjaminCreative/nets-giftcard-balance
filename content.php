<form id="giftcard">
<h3>Vis saldo på dit gavekort</h3>
Kortnummer:
<input type="text" name="Cardnr" id="cardnr" style="margin-right: 20px;" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
<input type="submit" id="cardsubmit" value="Send" style="display:inline-block" />
</form>
<div id="spinner" style="display:none;">
   <img src="<?php echo plugins_url(); ?>/gavekort-saldo/assets/img/spin.gif" />
</div>
<div id="result"></div>
<script>
// Variable to hold request
var request;

// Bind to the submit event of our form
jQuery("#giftcard").submit(function(event){
   
          // Abort any pending request
    if (request) {
        request.abort();
    }
   
   jQuery("#spinner").show();
    var jQueryform = jQuery(this);
    var jQueryinputs = jQueryform.find("input");
    var serializedData = jQueryform.serialize();
    jQueryinputs.prop("disabled", true);

   var sanity = jQuery('#cardnr').val();
   if (sanity.length != 19) {
     jQuery("#result").html('<br><span style="color:red">Dette er ikke et korrekt kortnummer!</span>');
     jQuery("#spinner").hide();
      event.preventDefault();
      jQueryinputs.prop("disabled", false);
     return;
   }

 jQuery.ajax({
    type: 'POST',
    url: '<?php echo plugins_url(); ?>/gavekort-saldo/postdata.php',
    crossDomain: true,
    data: serializedData,
    dataType: 'text',
      success: function(responseData, textStatus, jqXHR) {
 
  var resultvalue = parseReturnedXML(responseData, 'ResultValue'); 
     if (resultvalue == "0") {
          
          var balance = parseReturnedXML(responseData, 'Balance');
          var txtArray = balance.split('');
              txtArray.splice(txtArray.length-2,0,",");
              balance = txtArray.join('');
              
          var expirydate = parseReturnedXML(responseData, 'ExpiryDate');
          var year = ', 20' + expirydate.substring(0, 2);
          var month =  expirydate.substring(2);
               if (month == "01") { month = "Januar"};
               if (month == "02") { month = "Februar"};
               if (month == "03") { month = "Marts"};
               if (month == "04") { month = "April"};
               if (month == "05") { month = "Maj"};
               if (month == "06") { month = "Juni"};
               if (month == "07") { month = "Juli"};
               if (month == "08") { month = "August"};
               if (month == "09") { month = "September"};
               if (month == "10") { month = "Oktober"};
               if (month == "11") { month = "November"};
               if (month == "12") { month = "December"};
         
         var cardstatus = parseReturnedXML(responseData, 'CardStatus'); 
              if (cardstatus == "0") {cardstatus = "Aktivt"};
              if (cardstatus == "2") {cardstatus = "Ikke aktiveret"};
              if (cardstatus == "10") {cardstatus = "Blokeret"};
              if (cardstatus == "11") {cardstatus = "Deaktiveret"};
              if (cardstatus == "12") {cardstatus = "Udløbet"};  
         
         
          
         jQuery("#result").html('<pre><h3><strong>Saldo: ' + balance + ' kr.</strong></h3>• Status: ' + cardstatus + '<br>• Udløbsdato: ' + month + year + ' </pre>');
   		jQuery("#spinner").hide();
   		jQueryinputs.prop("disabled", false);
     } else {
        jQuery("#result").html('<br><span style="color:red">Kort nummer er ugyldigt...</span>');
         jQuery("#spinner").hide();
         jQueryinputs.prop("disabled", false);
     };
    
    },
      error: function (responseData, textStatus, errorThrown) {
        jQuery("#result").html("Der er sket en fejl, prøv igen... Fejlmeddelse: " + textStatus);
        console.log('Error:', responseData);
        jQuery("#spinner").hide();
        jQueryinputs.prop("disabled", false);
    }
  });


  event.preventDefault();
});
 
function parseReturnedXML(strToParse, str) { 
     var str = strToParse.match('<' + str + '>(.*?)</' + str + '>');
      return str[1];
 }
 
</script>
