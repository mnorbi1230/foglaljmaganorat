<?php
function calculateAvailability($startTime, $endTime, $duration, $breakDuration, $reservedTimes) {
    $availability = array();
    $current = strtotime($startTime);
    $end = strtotime($endTime);

    foreach ($reservedTimes as $reserved) {
        $reservedStart = strtotime($reserved[0]);
        $reservedEnd = strtotime($reserved[1]);
        if($current<$reservedStart){


            while ($current+$duration*60 <= $reservedStart) {
                $availability[] = date('H:i', $current);
                $current += $duration * 60;
                $current += $breakDuration * 60;
            }


        }
        $current = $reservedEnd;
    }

    while ($current+$duration*60 <= $end) {
        $availability[] = date('H:i', $current);
        $current += $duration * 60;
        $current += $breakDuration * 60;
    }

    return $availability;
}
/*
$startTime = "08:00";
$endTime = "20:00";
$duration = 31;
$breakDuration = 10;
$reservedTimes = array(
    array("08:30", "09:00"),
    array("09:31", "10:40")
);

$availableTimes = calculateAvailability($startTime, $endTime, $duration, $breakDuration, $reservedTimes);
print_r($availableTimes);*/
