<?php
require_once 'system/common.php';

if (!isset($_SESSION['cookie'])){
    $_SESSION['cookie']='N';
}

if($_SESSION['loggedIn']==false or $_SESSION['hash']==''){
    header('Location: https://foglaljmaganorat.hu/bejelentkezes');
}

$frame='';
if(identitas($_SESSION['hash'])){
    $frame=template('teacher_frame');
}
else{
    echo 'Valami';
}

echo template('xhtml',[
    'title'=>'Foglalj magánórát - Portál',
    'cookie'=>$_SESSION['cookie'],
    'frame'=> $frame
]);
