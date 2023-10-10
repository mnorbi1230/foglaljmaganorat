<?php
require_once 'system/common.php';
if (!isset($_SESSION['cookie'])){
    $_SESSION['cookie']='N';
}
if(!isset($_GET['tanar'])){
    header('Location: idopontfoglalas');
}
elseif (!isset($_GET['theme'])){
    header('Location: temavalasztas?tanar='.$_GET['tanar']);
}
elseif (!isset($_GET['date'])){
    header('Location: temavalasztas?tanar='.$_GET['tanar'].'?theme='.$_GET['theme']);
}
elseif (!isset($_GET['times'])){
    header('Location: idovalasztas?tanar='.$_GET['tanar'].'?theme='.$_GET['date']);
}
else{
    function cF($inputTime) {
        $formattedTime = date("H:i", strtotime($inputTime));
        return $formattedTime;
    }
    // Aktuális dátum
    $currentDate = date("Y-m-d");
    $sql = "SELECT reserved_times.start,reserved_times.end FROM `reserved_times` INNER JOIN users ON reserved_times.userid=users.id WHERE users.username='{$_GET['tanar']}' AND date='{$_GET['date']}';";
    $result = $conn->query($sql);
    $reserved=[];

    while ($row = mysqli_fetch_assoc($result)) {

        $valami = [cF($row['start']),cF($row['end'])];
        array_push($reserved, $valami);
    }
    $sql = "SELECT users.name,users.barion_email,free_times.start,free_times.end FROM `free_times` INNER JOIN users ON free_times.userid=users.id WHERE users.username='{$_GET['tanar']}' AND date='{$_GET['date']}' LIMIT 1;";
    $result = $conn->query($sql);
    $free_start='';
    $free_end='';
    $name="";
    $user_email="";
    while ($row = mysqli_fetch_assoc($result)) {
        $name=$row['name'];
        $free_start=$row['start'];
        $free_end=$row['end'];
        $user_email=$row['barion_email'];
    }
    $sql = "SELECT theme.name,minute, breaktime,user_theme.price FROM theme INNER JOIN `user_theme` ON theme.id=user_theme.themeid INNER JOIN users ON user_theme.userid=users.id WHERE users.username='{$_GET['tanar']}' AND user_theme.themeid='{$_GET['theme']}';";
    $result = $conn->query($sql);
    $theme_duration='';
    $theme_break='';
    $price='';
    $theme_name='';
    while ($row = mysqli_fetch_assoc($result)) {
        $price=$row['price'];
        $theme_duration=$row['minute'];
        $theme_break=$row['breaktime'];
        $theme_name=$row['name'];
    }
    require_once 'idopont.php';


    $free_times=calculateAvailability(cF($free_start),cF($free_end),$theme_duration,$theme_break,$reserved);
    $times=explode(',',$_GET['times']);
    $ok_times=[];
    foreach ($times as $time) {
       if(in_array($time,$free_times)){
           array_push($ok_times,$time);
       }
    }
    echo template('xhtml',[
    'title'=>'Foglalj magánórát - Adatok megadása',
    'cookie'=>$_SESSION['cookie'],
    'frame'=> template('frame',[
        'content'=>template('adatmegado',[
            'ok_times'=>json_encode($ok_times, JSON_UNESCAPED_UNICODE),
            'username'=>$_GET['tanar'],
            'price'=>$price,
            'theme'=>$_GET['theme'],
            'theme_name'=>$theme_name,
            'theme_duration'=>$theme_duration,
            'date'=>$_GET['date'],
            'name'=>$name,
            'email'=>$user_email
        ])
    ])
]);
}