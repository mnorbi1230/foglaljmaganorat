<?php
require_once 'system/common.php';
if(isset($_POST['name']) and isset($_POST['email']) and isset($_POST['phonenumber']) and isset($_POST['irsz']) and isset($_POST['street']) and isset($_POST['username']) and isset($_POST['pass1']) and isset($_POST['pass2']) and isset($_POST['mode'])){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $name=$_POST['name'];
    $phnumber=$_POST['phonenumber'];
    $irsz=$_POST['irsz'];
    $city=$_POST['city'];
    $street=$_POST['street'];

    $password=$_POST['pass1'];
    $password2=$_POST['pass2'];
    $abc = 'abcdefghijklmnopqrstuvwxyz';
    $ABC = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $abc_HUN = 'áéíóöőúüű';
    $ABC_HUN = 'ÁÉÍÓÖŐÚÜŰ';
    $basic_specials=' ,.-@*/!';

    $OK=true;
    $last=0;
    if($OK){
        $OK=filter($username,$abc.$numbers,3,25);
        $last=1;
    }
    if($OK)
    {
        $OK=filter($email,$abc.$numbers.$basic_specials,6,100);
        $last=2;
    }
    if($OK)
    {
        $OK=filter($phnumber,$numbers,8,12);
        $last=3;
    }
    if($OK)
    {
        $OK=filter($name,$abc.$numbers.$abc_HUN.$ABC.$abc_HUN.$basic_specials,3,80);
        $last=4;
    }
    if($OK)
    {
        $OK=filter($irsz,$numbers,4,4);
        $last=5;
    }
    if($OK)
    {
        $OK=filter($city,$abc.$ABC.$abc_HUN.$ABC_HUN.$basic_specials,2,25);
        $last=6;
    }

    if($OK)
    {
        $OK=filter($street,$abc.$numbers.$abc_HUN.$ABC_HUN.$ABC.$basic_specials,7,80);
        $last=7;
    }
    if($OK) {
        $OK = filter($password, $abc . $numbers . $abc_HUN . $ABC_HUN . $ABC . $basic_specials, 8, 255);
        $last=8;
        }
    if($OK){
        if($password!=$password2){
            $OK=false;
            $last=11;
        }
    }

    if($_POST['mode']=='tanar'){
        if($OK) {
            $OK = filter($_POST['taxnumber'],  $numbers . $basic_specials, 10, 12) and $_POST['taxnumber']!="";
            $last=12;
        }
        if ($OK) { // Ha minden adat megfelelő

            $regtime = date('Y-m-d H:i');

            $sql = "SELECT id FROM users WHERE username='{$username}';";
            $result = $GLOBALS['conn']->query($sql);
            $sql2 = "SELECT id FROM students WHERE username='{$username}';";
            $result2 = $GLOBALS['conn']->query($sql2);
            if ($result->num_rows > 0 or $result2->num_rows > 0) {
                $OK = false;
                $last = 9;
            } else {
                $sql = "SELECT id FROM addresses WHERE email='{$email}';";
                $result2 = $GLOBALS['conn']->query($sql);
                if ($result2->num_rows > 0) {

                    $OK = false;
                    $last = 10;
                }
                else {
                    $regtime = date('Y-m-d H:i');
                    $password=hash('sha256',$password);
                    $hash=hash('sha256',$regtime.$username);
                    $sql="INSERT INTO `addresses`( `postcode`, `city`, `address`) VALUES ('{$irsz}','{$city}','{$street}');";
                    $result=$GLOBALS['conn']->query($sql);
                    $add_id=$GLOBALS['conn'] -> insert_id;
                    $sql="INSERT INTO `users`(`name`, `email`, `username`, `hash`, `password`, `licensed`,addresses_id,phonenumber,taxnumber) VALUES ('{$name}','{$email}','{$username}','{$hash}','{$password}','0','{$add_id}','{$phnumber}','{$_POST['taxnumber']}');";
                    $result=$GLOBALS['conn']->query($sql);

                }
            }
        }
    }
    else{
        if ($OK) { // Ha minden adat megfelelő

            $regtime = date('Y-m-d H:i');

            $sql = "SELECT id FROM students WHERE username='{$username}';";
            $result = $GLOBALS['conn']->query($sql);

            $sql2 = "SELECT id FROM users WHERE username='{$username}';";
            $result2 = $GLOBALS['conn']->query($sql2);
            if ($result->num_rows > 0 or $result2->num_rows > 0) {
                $OK = false;
                $last = 9;
            } else {
                $sql = "SELECT id FROM addresses WHERE email='{$email}';";
                $result2 = $GLOBALS['conn']->query($sql);
                if ($result2->num_rows > 0) {
                    $OK = false;
                    $last = 10;
                } else {
                    $regtime = date('Y-m-d H:i');
                    $password = hash('sha256', $password);
                    $hash = hash('sha256', $regtime . $username);
                    $sql = "INSERT INTO `addresses`( `postcode`, `city`, `address`) VALUES ('{$irsz}','{$city}','{$street}');";
                    $result = $GLOBALS['conn']->query($sql);
                    $add_id = $GLOBALS['conn']->insert_id;
                    $sql = "INSERT INTO `students`(`name`, `email`, `username`, `hash`, `password`,addresses_id,phonenumber) VALUES ('{$name}','{$email}','{$username}','{$hash}','{$password}','{$add_id}','{$phnumber}');";

                    $result = $GLOBALS['conn']->query($sql);
                }
            }
        }
    }

    if($OK){
        if(isset($_POST['tanar']) and isset($_POST['theme']) and isset($_POST['date']) and isset($_POST['times'])){
            if($_POST['tanar']!='' and $_POST['theme']!='' and $_POST['date']!='' and $_POST['times']!='') {
                header("Location: adatmegadas?tanar={$_POST['tanar']}&theme={$_POST['theme']}&date={$_POST['date']}&times={$_POST['times']}");
            }
            else{
                header("Location: siker");
            }
        }
        else{
            header("Location: siker");
        }
    }
    else{
        if(isset($_POST['tanar']) and isset($_POST['theme']) and isset($_POST['date']) and isset($_POST['times'])){
            if($_POST['tanar']!='' and $_POST['theme']!='' and $_POST['date']!='' and $_POST['times']!='') {
                header("Location: regisztracio?tanar={$_POST['tanar']}&theme={$_POST['theme']}&date={$_POST['date']}&times={$_POST['times']}&mode={$_POST['mode']}&user={$username}&email={$email}&name={$name}&phnumber={$phnumber}&irsz={$irsz}&city={$city}&street={$street}&hibakod={$last}");
            }
            else{
                header("Location: regisztracio?mode={$_POST['mode']}&user={$username}&email={$email}&name={$name}&phnumber={$phnumber}&irsz={$irsz}&city={$city}&street={$street}&hibakod={$last}");
            }
        }
        else{
            header("Location: regisztracio?mode={$_POST['mode']}&user={$username}&email={$email}&name={$name}&phnumber={$phnumber}&irsz={$irsz}&city={$city}&street={$street}&hibakod={$last}");
        }

    }
}
else{
    header("Location: regisztracio");
}