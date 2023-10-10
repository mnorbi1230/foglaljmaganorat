<?php
require_once 'system/common.php';

if (!isset($_SESSION['cookie'])){
    $_SESSION['cookie']='N';
}
$content='';
$datas=[];
if(isset($_GET['tanar']) and isset($_GET['theme']) and isset($_GET['date']) and isset($_GET['ok_times'])){
    $datas=[
        'ok_times'=>$_GET['ok_times'],
        'username'=>$_GET['tanar'],
        'theme'=>$_GET['theme'],
        'date'=>$_GET['date']
    ];
}


if(isset($_GET['name'])) {
    $datas=array_merge($datas,['name'=>$_GET['name']]);
}
if(isset($_GET['email'])){
    $datas=array_merge($datas,['email'=>$_GET['email']]);
}
if(isset($_GET['phnumber'])){
    $datas=array_merge($datas,['phonenumber'=>$_GET['phnumber']]);
}
if(isset($_GET['irsz'])){
    $datas=array_merge($datas,['irsz'=>$_GET['irsz']]);
}
if(isset($_GET['city'])){
    $datas=array_merge($datas,['city'=>$_GET['city']]);
}
if(isset($_GET['street'])){
    $datas=array_merge($datas,['street'=>$_GET['street']]);
}
if(isset($_GET['user'])){
    $datas=array_merge($datas,['user'=>$_GET['user']]);
}
if(isset($_GET['password'])){
    $datas=array_merge($datas,['password'=>$_GET['password']]);
}
if(isset($_GET['mode'])){
    $datas=array_merge($datas,['mode'=>$_GET['mode']]);
}
if(isset($_GET['hibakod'])){
    $datas=array_merge($datas,['hibakod'=>$_GET['hibakod']]);
}
if(isset($_GET['mode'])){
    if($_GET['mode']=='tanar'){
        $content=template('reg_tanar',$datas);
    }
    else{
        $content=template('reg_diak',$datas);
    }
}
else{
    $content=template('reg_diak',$datas);
}
echo template('xhtml',[
    'title'=>'Foglalj magánórát - Regisztráció',
    'cookie'=>$_SESSION['cookie'],
    'frame'=> template('frame',[
        'content'=>$content
    ])
]);
