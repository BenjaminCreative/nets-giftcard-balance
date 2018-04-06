<?php
$SenderID = "SENDERID"; // change to correct sender id from Nets...
$Cardnr = $_POST['Cardnr'];
$soapUrl = "https://gavekort.pbs.dk/atsws/ATSWS001.asmx";

$xml_post_string = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><BalanceInquiry xmlns="http://tempuri.org/"><Sender>' . $SenderID . '</Sender><CardNr>' . $Cardnr . '</CardNr></BalanceInquiry></soap:Body></soap:Envelope>';

$headers = array(
"POST /atsws/ATSWS001.asmx HTTP/1.1",
"Host: gavekort.pbs.dk",
"Content-Type: text/xml; charset=utf-8",
"Content-Length: ".strlen($xml_post_string),
"SOAPAction: http://tempuri.org/BalanceInquiry"
); 

$url = $soapUrl;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch); 
curl_close($ch);

echo '<pre>';
 print_r($response);
echo '</pre>';
?>


