<?php
require_once 'system/common.php';

if(isset($_POST['m'])){
    if(identitas($_SESSION['hash'])){
        switch($_POST['m']){
            case 1:
                echo template('teacher_dash',[]);
                echo $_SESSION['hash'];
                break;
            case 2:
                $sql="SELECT username,name,phonenumber,email,taxnumber,access,licensed,barion_email,barion_myposkey,szamlazz_email,szamlazz_password,image,postcode,city,address FROM users INNER JOIN `addresses` ON users.addresses_id=addresses.id WHERE hash='{$_SESSION['hash']}' ;";
                $result=$GLOBALS['conn']->query($sql)->fetch_assoc();
                echo template('teacher_settings',$result);
                break;
            case 3:
                $sql="SELECT date,start,end FROM `reserved_times` INNER JOIN users ON reserved_times.userid=users.id WHERE type=1 AND users.hash='{$_SESSION['hash']}' ORDER BY date ASC,start ASC,end ASC;";
                $result=$GLOBALS['conn']->query($sql);
                $formcontent="";
                while ($row = mysqli_fetch_assoc($result)) {
                    $formcontent.="<tr>
                            <td>{$row['date']}</td>
                            <td>{$row['start']}</td>
                            <td>{$row['end']}</td>
                            </tr>";
                }
                echo template('reserved_times',[
                    'formcontent'=>$formcontent
                ]);
                break;
            default:
                break;
        }
    }
}