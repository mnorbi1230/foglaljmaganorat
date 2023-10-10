<?php
require_once 'system/common.php';
if (!isset($_SESSION['cookie'])){
    $_SESSION['cookie']='N';
}
if(!isset($_GET['tanar'])){
    header('Location: idopontfoglalas');
}
else{
    $sql = "SELECT theme.id,theme.name, users.name as user_name FROM theme INNER JOIN user_theme ON theme.id =user_theme.themeid INNER JOIN users ON user_theme.userid=users.id WHERE users.username='{$_GET['tanar']}';";
    $result = $conn->query($sql);
    $eredmeny=[];
    while ($row = mysqli_fetch_assoc($result)) {
        $valami = [
            'id' => $row['id'],
            'name' => $row['name'],
            'user_name' => $row['user_name']
        ];
        array_push($eredmeny, $valami);
    }
    echo template('xhtml',[
        'title'=>'Foglalj magánórát - Témaválasztás',
        'cookie'=>$_SESSION['cookie'],
        'frame'=> template('frame',[
            'content'=>template('temavalaszto',[
                'themes'=>json_encode($eredmeny, JSON_UNESCAPED_UNICODE),
                'username'=>$_GET['tanar']
            ])
        ])
    ]);
}
