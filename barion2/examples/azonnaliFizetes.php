<?php

/*
*  Barion PHP library usage example
*  
*  Starting an immediate payment with one product
*  
*  � 2015 Barion Payment Inc.
*/

require_once 'barion2/library/BarionClient.php';

$myPosKey = "19cd055e-aabd-412f-bd6c-bbefb415ab27"; // <-- Replace this with your POSKey!

/*
// Barion Client that connects to the TEST environment
$termekek = array();
$termekek[0] = array(
  "name" => "Magánóra",
  "description" => "15:00-16:00",
  "quantity" => 1,
  "unit" => "óra",
  "unitPrice" => 6000,
  "id" => "3"
);
$termekek[1]=array(
    "name" => "Magánóra",
    "description" => "16:00-17:00",
    "quantity" => 1,
    "unit" => "óra",
    "unitPrice" => 6000,
    "id" => "3"
);

$vevo_adat = array(
  "city" => "Budapest",
  "postCode" => 1193,
  "street" => "Fő utca 3",
  "lastname" => "Teszt",
  "firstname" => "Elek"
);
$emailAddress='szamla2@matusnorbert.hu';
*/

function createPayment($BC, $transaction_id, $emailAddress, $vevo_adat, $termekek)
{
  $trans = new PaymentTransactionModel();
  $trans->POSTransactionId = $transaction_id;
  $trans->Payee =  $emailAddress;

  $vegosszeg = 0;
  for ($i = 0; $i < count($termekek); $i++) {
    $item = new ItemModel();
    $item->Name = $termekek[$i]["name"];
    $item->Description = $termekek[$i]["description"];
    $item->Quantity = $termekek[$i]["quantity"]; // mennyiség
    $item->Unit = $termekek[$i]["unit"];
    $item->UnitPrice = $termekek[$i]["unitPrice"]; // egység ár
    $item->ItemTotal = $termekek[$i]["quantity"] * $termekek[$i]["unitPrice"];
    $item->SKU = $termekek[$i]["id"];
    $trans->AddItem($item);
    $vegosszeg += $termekek[$i]["quantity"] * $termekek[$i]["unitPrice"];
  }

  $trans->Total = $vegosszeg;
  $trans->Comment = "";


  $shippingAddress = new ShippingAddressModel();
  $shippingAddress->Country = "HU";
  $shippingAddress->Region = null;
  $shippingAddress->City = $vevo_adat["city"];
  $shippingAddress->Zip = $vevo_adat["postCode"];
  $shippingAddress->Street = $vevo_adat["street"];
  $shippingAddress->Street2 = "";
  $shippingAddress->Street3 = "";
  $shippingAddress->FullName = $vevo_adat["lastname"] . " " . $vevo_adat["firstname"];


  // create the request model
  $psr = new PreparePaymentRequestModel();
  $psr->GuestCheckout = true;
  $psr->PaymentType = PaymentType::Reservation;
  $psr->ReservationPeriod = '0.00:10:00';
  $psr->FundingSources = array(FundingSourceType::All);
  $psr->PaymentRequestId = "TESTPAY-01"; // EZ MAJD KELL
  $psr->PayerHint = "user@example.com";
  $psr->Locale = UILocale::HU;
  $psr->Currency = Currency::HUF;
  $psr->OrderNumber = "ORDER-0001"; // EZ MAJD KELL
  $psr->ShippingAddress = $shippingAddress;
  $psr->RedirectUrl = "http://foglaljmaganorat.hu/koszi"; // EZ MAJD KELL
  $psr->AddTransaction($trans);


  $myPayment = $BC->PreparePayment($psr);


  if ($myPayment->RequestSuccessful === true) {



    header("Location: " . BARION_WEB_URL_TEST . "?id=" . $myPayment->PaymentId); // ez dob át az egyéni fizető oldalra

  } else { // Itt valami hiba történt a tranzakció során

      // Email, nem sikerült a tranzakció probald a fizetést újra
      // Külön php script ami beazonosítja a még nem teljesített fizetést és azt visszatölti
    echo 'nem siker';
  }
}


//createPayment($BC, "TRANS-001", "szamla2@matusnorbert.hu", $vevo_adat, $termekek);
