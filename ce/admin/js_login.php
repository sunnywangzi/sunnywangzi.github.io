<?php
include '../function.php';
session_start();
$name=@$_POST['name'];
$pass=@$_POST['pass'];
$pass=md5($pass);
$ps=$db->prepare("select * from admin where name=:name and pass=:pass");
$ps->execute(array(':name'=>$name,':pass'=>$pass));
$data=$ps->fetch();

if($data){
    $_SESSION['login']='OK';
    echo 'success';
}