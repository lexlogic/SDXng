<?php
require_once 'Init.php';
$user = new User();

if($user->isLoggedIn()) {
    Redirect::to('dashboard/');
} else {
    Redirect::to('login/');
}