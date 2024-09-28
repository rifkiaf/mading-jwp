<?php

include('admin/config_query.php');
$db = new database;

// inisialisasi session
session_start();

// cek session
if (isset($_SESSION['username']) || isset($_SESSION['id_users'])) {
  header('location: admin/index.php');
} else {

  if (isset($_POST['submit'])) {

    // hilangkan backslash
    $username = stripcslashes($_POST['username']);
    $password = stripcslashes($_POST['password']);

    // cek nilai username dan password
    if (!empty(trim($username)) && !empty(trim($password))) {

      // memilih data dari tb_users berdasarkan username
      $query = $db->get_data_users($username);

      if ($query) {
        $rows = mysqli_num_rows($query);
      } else {
        $rows = 0;
      }

      // cek ketersediaan data username dan disimpan pada variabel getData
      if ($rows != 0) {
        $getData = $query->fetch_assoc();
        if (password_verify($password, $getData['password'])) {
          $_SESSION['username'] = $username;
          $_SESSION['id_users'] = $getData['id_users'];
  
          header('location: admin/index.php');
        } else {
          header('location:login.php?pesan=gagal');
        }
      } else {
        header('location:login.php?pesan=notfound');
      }
    } else {
      header('location:login.php?pesan=empty');
    }
  }
}