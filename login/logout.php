<?php
require_once '../Init.php';
$user = new User();
$user->logout();
Redirect::to('../login/');
