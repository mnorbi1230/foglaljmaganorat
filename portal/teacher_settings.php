<?php
require_once 'system/common.php';
$nev=$_POST['ps_nev'];
$taxnumber=$_POST['taxnumber'];
$phnumber=$_POST['phnumber'];
$irsz=$_POST['irsz'];
$city=$_POST['city'];
$street=$_POST['street'];

$barion_email=$_POST['barion_email'];
$barion_myposkey=$_POST['barion_myposkey'];
$szamlazz_email=$_POST['szamlazz_email'];
$szamlazz_password=$_POST['szamlazz_password'];

$abc = 'abcdefghijklmnopqrstuvwxyz';
$ABC = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$numbers = '0123456789';
$abc_HUN = 'áéíóöőúüű';
$ABC_HUN = 'ÁÉÍÓÖŐÚÜŰ';
$basic_specials=' ,.-@*/!';
//security
$last="1";
$OK=filter($nev,$abc.$abc_HUN.$ABC.$ABC_HUN.$basic_specials,3,40);
file_put_contents('OK.txt',$taxnumber);

if($OK) {
        $OK = filter($taxnumber,  $numbers . $basic_specials, 10, 13) and $taxnumber!="";
        $last="3";
}
if($OK)
{
    $last=$phnumber;
    $OK=filter($phnumber,$numbers,8,12);
    $last="4";
}
if($OK)
{
    $OK=filter($irsz,$numbers,4,4);
    $last="5";
}
if($OK)
{
    $OK=filter($city,$abc.$ABC.$abc_HUN.$ABC_HUN.$basic_specials,2,25);
    $last="6";
}

if($OK)
{
    $OK=filter($street,$abc.$numbers.$abc_HUN.$ABC_HUN.$ABC.$basic_specials,7,80);
    $last="7";
}


//2.
if($OK)
{
    $OK=filter($barion_email,$abc.$numbers.$abc_HUN.$ABC.$abc_HUN.$basic_specials,3,40);
    $last="8";
}
if($OK)
{
    $OK=filter($barion_myposkey,$abc.$numbers.$abc_HUN.$ABC.$abc_HUN.$basic_specials,3,40);
    $last="9";
}

if($OK)
{
    $OK=filter($szamlazz_email,$abc.$numbers.$abc_HUN.$ABC.$abc_HUN.$basic_specials,3,40);
    $last="11";
}
if($OK)
{
    $OK=filter($szamlazz_password,$abc.$numbers.$abc_HUN.$ABC.$abc_HUN.$basic_specials,3,255);
    $last="12";
}

$message='';
if($OK){
    $sql="SELECT addresses_id FROM users WHERE hash='{$_SESSION['hash']}';";
    $result =$GLOBALS['conn']->query($sql)->fetch_assoc();
    $add_id=$result['addresses_id'];

    $sql="UPDATE addresses SET postcode='{$irsz}',city='{$city}',address='{$street}' WHERE id='{$add_id}';";
    file_put_contents("barmi.txt",$sql);//kiiratas
    $result =$GLOBALS['conn']->query($sql);

    $sql="UPDATE users SET phonenumber='{$phnumber}',taxnumber='{$taxnumber}',name='{$nev}',barion_email='{$barion_email}',barion_myposkey='{$barion_myposkey}',szamlazz_email='{$szamlazz_email}',szamlazz_password='{$szamlazz_password}' WHERE hash='{$_SESSION['hash']}';";
    //file_put_contents("barmi.txt",$_SESSION['hash']);//kiiratas
    $result =$GLOBALS['conn']->query($sql);

    echo("<div id='siker'>Sikeres módosítás</div>");
}
else{
    //számlázási cím lekérdezés
    $sql="SELECT username,name,phonenumber,email,taxnumber,access,licensed,barion_email,barion_myposkey,szamlazz_email,szamlazz_password,image,postcode,city,address FROM users INNER JOIN `addresses` ON users.addresses_id=addresses.id WHERE hash='{$_SESSION['hash']}';";
    $result =$GLOBALS['conn']->query($sql)->fetch_assoc();

    $error = [];
    echo "Érték: " . $last ;
    for($i=0;$i<=13;++$i){
        $valami=[];
        if($i==$last){
            $valami=["{$i}"=>"error"];
        }
        else{
            $valami=["{$i}"=>"mas"];
        }
        $error=array_merge($error,$valami);
    }


    $osszevont=array_merge($result,$error);
    //file_put_contents("barmi.txt",implode("\n", array_keys($osszevont)));
    //file_put_contents("barmi2.txt",$error);
    echo template('teacher_settings',$osszevont);

}