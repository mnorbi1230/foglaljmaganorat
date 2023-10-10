<?php
require_once 'system/common.php';
function cF($inputTime) {
    $formattedTime = date("H:i", strtotime($inputTime));
    return $formattedTime;
}
if (!isset($_SESSION['cookie'])){
    $_SESSION['cookie']='N';
}
if(!isset($_GET['tanar'])){
    header('Location: idopontfoglalas');
}
elseif (!isset($_GET['theme'])){
    header('Location: temavalasztas?tanar='.$_GET['tanar']);
}
else{
// Aktuális dátum
    $currentDate = date("Y-m-d");
    $sql = "SELECT free_times.id, free_times.date,users.name FROM free_times INNER JOIN users On free_times.userid=users.id WHERE users.username='{$_GET['tanar']}' AND date>'{$currentDate}';";

    $result = $conn->query($sql);
    $dates=[];
    $name="";
    while ($row = mysqli_fetch_assoc($result)) {
        $name=$row['name'];



        $sql = "SELECT reserved_times.start,reserved_times.end FROM `reserved_times` INNER JOIN users ON reserved_times.userid=users.id WHERE users.username='{$_GET['tanar']}' AND date='{$row['date']}';";

        $result2 = $conn->query($sql);
        $reserved=[];
        while ($row1 = mysqli_fetch_assoc($result2)) {
            $valami = [cF($row1['start']),cF($row1['end'])];
            array_push($reserved, $valami);
        }
        $sql = "SELECT free_times.start,free_times.end FROM `free_times` INNER JOIN users ON free_times.userid=users.id WHERE users.username='{$_GET['tanar']}' AND date='{$row['date']}' LIMIT 1;";

        $result2 = $conn->query($sql);
        $free_start='';
        $free_end='';
        while ($row1 = mysqli_fetch_assoc($result2)) {
            $free_start=$row1['start'];
            $free_end=$row1['end'];
        }
        $sql = "SELECT theme.name,minute, breaktime FROM theme INNER JOIN `user_theme`ON theme.id=user_theme.themeid INNER JOIN users ON user_theme.userid=users.id WHERE users.username='{$_GET['tanar']}' AND user_theme.themeid='{$_GET['theme']}';";
        $result2 = $conn->query($sql);

        $theme_duration='';
        $theme_break='';
        $theme_name='';
        while ($row1 = mysqli_fetch_assoc($result2)) {
            $theme_duration=$row1['minute'];
            $theme_break=$row1['breaktime'];
            $theme_name=$row1['name'];
        }
        require_once 'idopont.php';

        $free_times=calculateAvailability(cF($free_start),cF($free_end),$theme_duration,$theme_break,$reserved);
        if(count($free_times)>0){
            $valami = [
                'id' => $row['id'],
                'date' => $row['date']
            ];
            array_push($dates, $valami);
        }

    }
    echo template('xhtml',[
        'title'=>'Foglalj magánórát - Dátum kiválasztása',
        'cookie'=>$_SESSION['cookie'],
        'frame'=> template('frame',[
            'content'=>template('napvalaszto',[
                'dates'=>json_encode($dates, JSON_UNESCAPED_UNICODE),
                'username'=>$_GET['tanar'],
                'theme'=>$_GET['theme'],
                'name'=>$name
            ])
        ])
    ]);
}