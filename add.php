<?php


header('Content-type:text/html;charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['username'])) {
        echo "<script>alert('用户名不能为空！');location.href='login.html';</script>";
    } else {
        $username = trim($_POST['username']);
    }
    if (empty($_POST['password'])) {
        echo "<script>alert('密码不能为空！');location.href='login.html';</script>";
    } else {
        $password = $_POST['password'];
    }
    if (empty($_POST['repassword'])) {
        echo "<script>alert('确认密码不能为空！');location.href='login.html';</script>";
    } else {
        $repassword = $_POST['repassword'];
    }
    if ($password != $repassword) {
        echo "<script>alert('两次输入密码不一致！');location.href='login.html';</script>";
    }
}

$mysqli = new mysqli('123.207.140.186', 'root', 'root', 'myDB');
$result = $mysqli->query("SELECT userpwd FROM user WHERE username = " . "'$username'");
$rs = $result->fetch_row();
if (!empty($rs)) {
    echo "<script>alert('用户已存在！');location.href='login.html';</script>";
} else {
  //  $mysqli = new mysqli('123.207.140.186', 'root', 'root', 'myDB');
    $time = time();
    $userpwd =md5($_POST['password']);
    $remoteip =ip2long('1.202.240.202');;

    echo $remoteip;
    $sql = "INSERT INTO user (username,userpwd,createtime,createip) VALUES ('$_POST[username]', '$userpwd','$time', $remoteip )";
    $rs = $mysqli->query($sql);
    if (!$rs) {
        echo "<script>alert('注册失败！');location.href='register.html';</script>";
    } else {
        echo "<script>alert('注册成功！返回登录页面');location.href='login.html';</script>";
    }
}

 