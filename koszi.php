<?php
require_once 'system/common.php';
require_once 'barion2/library/BarionClient.php';

// Megkapom a tranzakció azonosítóját
if (isset($_GET['paymentId'])){
    $paymentId = $_GET['paymentId'];

    $myPosKey = "19cd055e-aabd-412f-bd6c-bbefb415ab27";
    $BC = new BarionClient($myPosKey, 2, BarionEnvironment::Test);


    // Lekérem a Bariontól a tranzakció részleteit
    $paymentDetails = $BC->GetPaymentState($paymentId);


    // Végig megyek a tranzakciókon, azon belül a termékeken

    foreach ($paymentDetails->Transactions as $transaction) {
        foreach ($transaction->Items as $item){

            // A reserved_timesba 1-esre állítom azt ahol az id = $item->SKU-val az SKU szolgál azonosítóként
            $reserveTimeQuery = "UPDATE reserved_times SET status = 1 WHERE id = {$item->SKU}";

            $GLOBALS['conn']->query($reserveTimeQuery);
        }

    }
    echo "Sikeres fizetés!";
}