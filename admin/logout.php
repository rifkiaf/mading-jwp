<?php
session_start();

//unset Semua Session Variabel
unset($_SESSION['username']);
unset($_SESSION['id_users']);

//unset all
session_unset();

//Destroy Session
session_destroy();

//Arahkan ke halaman login
header('location: ../login.php?pesan=logout');
exit;
?>