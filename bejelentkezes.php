<?php
require_once 'system/common.php';

if (!isset($_SESSION['cookie'])){
    $_SESSION['cookie']='N';
}


echo template('xhtml',[
    'title'=>'Foglalj magánórát - Bejelentkezés',
    'cookie'=>$_SESSION['cookie'],
    'frame'=> template('frame',[
        'content'=>template('login',[
            'name'=>isset($_GET['name']) ? $_GET['name']:'',
            'last'=>isset($_GET['last']) ? $_GET['last']:''
        ])
    ])
]);
