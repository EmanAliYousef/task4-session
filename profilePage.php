<?php
session_start();

echo $_SESSION['name'].'<br>';
echo $_SESSION['email'].'<br>';
echo $_SESSION['password'].'<br>';
echo $_SESSION['address'].'<br>';
echo $_SESSION['image'].'<br>';
echo $_SESSION['linkedin'].'<br>';
echo $_SESSION['gender'].'<br>';


print_r($_SESSION['user']);

?>