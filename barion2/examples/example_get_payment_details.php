<?php

/*
*  Barion PHP library usage example
*  
*  Getting detailed information about a payment
*  
*  � 2015 Barion Payment Inc.
*/

require_once '../library/BarionClient.php';


function getPaymentDetails($paymentId){
    $myPosKey = "19cd055e-aabd-412f-bd6c-bbefb415ab27";
    $BC = new BarionClient($myPosKey, 2, BarionEnvironment::Test);

    $paymentDetails = $BC->GetPaymentState($paymentId);

    return $paymentDetails;

}

