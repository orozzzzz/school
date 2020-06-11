<?php
session_start();
unset($_SESSION['status']);
unset($_SESSION['fio']);
unset($_SESSION['sid']);
unset($_COOKIE['email']);
unset($_COOKIE['FIO']);
unset($_COOKIE['id']);
session_destroy();
header("Location: http://school/");
?>