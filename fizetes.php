<?php
require_once 'system/common.php';
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
// Megnézni, hogy a single_studentsnél létezik-e ilyen user
function singleStudentExists($email){
    $sql_query = "SELECT id FROM single_students WHERE email = '{$email}'";
    $result=$GLOBALS['conn']->query($sql_query);

    return $result->num_rows > 0;
}
function getStudentId($email){
    $sql_query = "SELECT id FROM single_students WHERE email = '{$email}'";
    $result=$GLOBALS['conn']->query($sql_query);

    while ($row = $result->fetch_assoc()){
        return $row["id"];
    }


}
function getTeacherId($username){
    $sql_query = "SELECT id FROM users WHERE username = '{$username}'";
    $result=$GLOBALS['conn']->query($sql_query);

    while ($row = $result->fetch_assoc()){
        return $row["id"];
    }
}


$termekek = array();
$idopontok=json_decode($_POST['times']);
for($i=0;$i<count($idopontok);++$i){
    $oravege=addMinutesToTime($idopontok[$i],$_POST['theme_duration']);
    $seged=[
        "name" => "Magánóra-Tanár: {$_POST['tanar']}",
        "description" => "{$idopontok[$i]}-{$oravege}",
        "quantity" => 1,
        "unit" => "óra",
        "unitPrice" => intval($_POST['price']),
        "id" => "3"
    ];
    array_push($termekek,$seged);
}

$diak_neve=explode(' ',"{$_POST['name']}");
$vevo_adat = array(
    "city" => "{$_POST['city']}",
    "postCode" => intval($_POST['irsz']),
    "street" => "{$_POST['street']}",
    "lastname" => "{$diak_neve[0]}",
    "firstname" => "{$diak_neve[1]}"
);





if(!singleStudentExists($_POST['email'])){ // Ha nem létezik ilyen single student akkor létrehozza
    $sql_query = "INSERT INTO single_students(`name`, `email`, `phone`) VALUES('{$_POST['name']}','{$_POST['email']}', '{$_POST['phonenumber']}')";
    $result=$GLOBALS['conn']->query($sql_query);
}

// Lekérem a diák és a tanár id-ját
$studentId = getStudentId($_POST['email']);
$teacherId = getTeacherId($_POST['tanar']);


// Berakja az összes időpontot az adatbázisba
for ($i = 0; $i < count($termekek); $i++){
    $startTime = explode( '-',$termekek[$i]["description"])[0];
    $endTime = explode( '-',$termekek[$i]["description"])[1];

    $reserveTimeQuery = "INSERT INTO reserved_times(`userid`, `studentid`, `studentid_guest`, `date`, `start`, `end`, `type`, `status`) VALUES('{$teacherId}', '0', '{$studentId}','{$_POST['date']}','{$startTime}', '{$endTime}', '1', '0')";

    $GLOBALS['conn']->query($reserveTimeQuery);

    $termekek[$i]["id"] = $GLOBALS['conn']->insert_id;
}


require_once 'barion2/examples/azonnaliFizetes.php';
$BC = new BarionClient($myPosKey, 2, BarionEnvironment::Test);
createPayment($BC, "TRANS-005", $_POST['email'], $vevo_adat, $termekek);