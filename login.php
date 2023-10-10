<?php
require_once 'system/common.php';

if(isset($_POST['name']) and isset($_POST['password'])){
    $abc = 'abcdefghijklmnopqrstuvwxyz';
    $ABC = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $abc_HUN = 'áéíóöőúüű';
    $ABC_HUN = 'ÁÉÍÓÖŐÚÜŰ';
    $basic_specials=' ,.-@*/!';
    $last=1;
    $OK=filter($_POST['name'],$abc.$numbers,3,25) or filter($_POST['name'],$abc.$numbers.$basic_specials,6,100);
    if($OK){
        $OK=filter($_POST['password'], $abc . $numbers . $abc_HUN . $ABC_HUN . $ABC . $basic_specials, 8, 255);
        $last=2;
    }
    if($OK){
        $password=hash('sha256',$_POST['password']);
        $last=3;
        $sql="SELECT hash FROM users WHERE (username='{$_POST['name']}' or email='{$_POST['name']}') AND password='{$password}';";
        $result = $GLOBALS['conn']->query($sql);
        if ($result->num_rows > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['hash']=$row['hash'];
            }
            $_SESSION['loggedIn']=true;
            $_SESSION['last_refresh']=time();
            header("Location: https://foglaljmaganorat.hu/portal");

        }
        else{
            $sql="SELECT hash FROM students WHERE (username='{$_POST['name']}' or email='{$_POST['name']}') AND password='{$password}';";
            $result = $GLOBALS['conn']->query($sql);
            if ($result->num_rows > 0){
                while ($row = mysqli_fetch_assoc($result)) {
                    $_SESSION['hash']=$row['hash'];
                }
                $_SESSION['loggedIn']=true;
                $_SESSION['last_refresh']=time();
                header("Location: https://foglaljmaganorat.hu/portal");
            }
            else{
                header("Location: bejelentkezes?name={$_POST['name']}&last={$last}");
            }
        }
    }
    else{
        header("Location: bejelentkezes?name={$_POST['name']}&last={$last}");
    }
}
else{
    header("Location: bejelentkezes");
}
