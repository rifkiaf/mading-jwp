<?php
$pass = password_hash('admin123',PASSWORD_DEFAULT);
var_dump( $pass );
die;