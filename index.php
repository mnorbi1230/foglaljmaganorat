<?php
require_once 'system/common.php';

if (!isset($_SESSION['cookie'])){
    $_SESSION['cookie']='N';
}

echo template('xhtml',[
    'title'=>'Foglalj magánórát - Kezdőlap',
    'cookie'=>$_SESSION['cookie'],
    'frame'=> template('frame',[
        'content'=>template('main')
    ])
]);
