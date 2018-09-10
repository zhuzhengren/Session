<?php

header('Content-type:text/html;charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 if (empty($_POST['username'])){
 echo "<script>alert('用户名不能为空！');location.href='login.html';</script>";
 }else {
 $username=trim($_POST['username']);
 }
 if (empty($_POST['password'])){
 echo "<script>alert('密码不能为空！');location.href='login.html';</script>";
 }else{
 $password=$_POST['password'];
 }
}
$mysqli = new mysqli('123.207.140.186', 'root', 'root', 'myDB');
$result = $mysqli->query("SELECT userpwd FROM user WHERE username = "."'$username'");
$rs=$result->fetch_row();
if (!empty($rs)){
 if (md5($password) != $rs[0]) {
      echo "<script>alert('密码错误！');location.href='login.html';</script>";
    }else{
        $expire=3600;
        ini_set('session.gc_maxlifetime', $expire);//保存1小时
        if (empty($_COOKIE['PHPSESSID'])) {
            session_set_cookie_params($expire);
            session_start();
        }else{
            session_start();
            setcookie('PHPSESSID', session_id(), time() + $expire);
        }
        if(isset($_SESSION['username'])){
            exit("您已经登入了，请不要重新登入！用户名：{$_SESSION['username']}---<a href='logout.php'>注销</a>");
        }else{
            $_SESSION['username']=$_POST['username'];
        }
        echo "<script>alert('登录成功！');</script><br>";
        echo "您好！{$_SESSION['username']},欢迎回来！";
        echo "<a href='logout.php'>注销</a>";
    }
}else{
    echo "<script>alert('没有此用户！');location.href='login.html';</script>";
}
 