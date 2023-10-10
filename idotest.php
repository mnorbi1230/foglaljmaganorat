<?php
function addMinutesToTime($time, $minutesToAdd) {
    // Szétválasztjuk az időpontot órára és percre
    list($hour, $minute) = explode(':', $time);

    // Összegzzük a percet és a hozzáadott percet
    $totalMinutes = $hour * 60 + $minute + $minutesToAdd;

    // Számoljuk újra az órát és percet a teljes percből
    $newHour = floor($totalMinutes / 60);
    $newMinute = $totalMinutes % 60;

    // Ellenőrizzük, hogy az új óra és perc formátum megfelelő legyen (pl. 8:03 helyett 08:03)
    $formattedHour = str_pad($newHour, 2, '0', STR_PAD_LEFT);
    $formattedMinute = str_pad($newMinute, 2, '0', STR_PAD_LEFT);

    // Visszaadjuk az új időpontot
    return $formattedHour . ':' . $formattedMinute;
}

// Példa használat
$originalTime = "15:45";
$minutesToAdd = 30;
$newTime = addMinutesToTime($originalTime, $minutesToAdd);
echo "Új időpont: " . $newTime;