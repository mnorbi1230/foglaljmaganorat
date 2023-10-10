<?php

$config = parse_ini_file('config.ini', true);

if ($config['base']['developer_mode']){

    ini_set('display_errors','On');

    error_reporting(E_ALL & ~E_NOTICE);

}

require_once 'Functions.php';

$conn= new mysqli(  $config['database']['server'],

                $config['database']['user'],

                $config['database']['password'],

                $config['database']['database_name']);
$conn->set_charset("utf8");


if ($conn -> connect_error) die('Hiba az adatbázis futtatásakor!');

session_start();

if (isset($_SESSION['loggedIn'])){

    if ($_SESSION['loggedIn']){

        //megnézzük hogy a felhasználó az időkereten belül van e

        if (time()-$_SESSION['last_refresh']<1200){

            //Még időn belül van

            $_SESSION['last_refresh']=time();

        }

        else{

            header('Location: logout.php');

        }

    }

}

else{

    $_SESSION['loggedIn']=false;//Be van e jelentkezve

    $_SESSION['hash']='';

    $_SESSION['loginTime']=0;//Mikor jelentkezett be

    $_SESSION['last_refresh']=0;//Mikor frissitett utoljára

    $_SESSION['username']='';//Felh.név

    $_SESSION['nickset']='';//Felh. név saját kis és nagybetű verzió

    $_SESSION['userlevel']=0;//Jogosultsági szint






}

