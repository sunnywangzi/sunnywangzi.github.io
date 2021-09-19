<?php
date_default_timezone_set('Asia/Shanghai');
define('ROOT',__DIR__);
try{
  $db = new PDO('sqlite:'.ROOT.'/book.db');
}catch (Exception $e) {
  echo $e->getMessage();
  exit;
}
$db->exec('set names utf8');



function get_ip() {
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }

function cookie($name,$val=FALSE){
    if($val){
      setcookie($name,$val,0);
    }else{
      return @$_COOKIE[$name];
    }
}

function redir($uri){
    header('Location:'.$uri);
    exit;
}

function checklogin(){
    $pass=cookie('pass');
    if($pass==MD5(PASSWORD)){
      return true;
    }
    else{
      return false;
    }
}

function load_config($key){
  global $db;
  $data=$db->query("select value from config where key='$key'")->fetch();
  //var_dump($data);
  if($data)
    return $data['value'];
  else
    return false;
}

function save_config($key,$value){
  global $db;
  $eof=$db->exec("update config set value='$value' where key='$key'");
  if(!$eof){
    $db->exec("insert into config(key,value) values('$key','$value')");
  }
}

