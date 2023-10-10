<?php
require_once 'system/common.php';
if (!isset($_SESSION['cookie'])){
    $_SESSION['cookie']='N';
}
echo template('xhtml',[
    'title'=>'Foglalj magánórát - Időpontfoglalás',
    'cookie'=>$_SESSION['cookie'],
    'frame'=> template('frame',[
        'content'=>template('tanarkereses')
    ])
]);