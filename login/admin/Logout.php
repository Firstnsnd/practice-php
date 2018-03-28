<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-28
 * Time: 下午1:56
 */
session_start();
unset($_SESSION['user']);
unset($_COOKIE['user']);
echo "<script>alert('You hava logouted!');location.href = '/welcome.php'</script>";
exit();