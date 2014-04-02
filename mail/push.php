<?php
require_once '../Init.php';
$user = new User();
if($user->isLoggedIn() && $user->hasPermission('edit')) {

    if (isset($_GET["id"])) {
        $id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['id']);
    }
    if (!isset($id)) {
        Redirect::to('../schedule/');
    }

    $schedRows = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE id = ?", array($id));
    foreach($schedRows->results() as $results) {
        $sched_rows[] = $results;
    }
    $siteRows = DB::getInstance()->getAssoc("SELECT * FROM sites WHERE site_name = ?", array($sched_rows[0]['site']));
    foreach($siteRows->results() as $results) {
        $site_rows[] = $results;
    }
    $usersRows = DB::getInstance()->getAssoc("SELECT * FROM users WHERE full_name = ?", array($sched_rows[0]['full_name']));
    foreach($usersRows->results() as $results) {
        $user_rows[] = $results;
    }

    $to = $user_rows[0]['msg_address'];
    $subject = "";
    $message =  "Site Name: ".$site_rows[0]['site_name']."\n\n";
    $message =  "Network ID: ".$sched_rows[0]['nid']."\n\n";
    $message .= "Site Address: ".$site_rows[0]['site_address']." ".$site_rows[0]['site_city']." ".$site_rows[0]['site_state']." ".$site_rows[0]['site_zip']."\n\n";
    $message .= "Primary Contact: ".$site_rows[0]['primary_contact_name']."\n\n";
    $message .= "Primary Number: ".$site_rows[0]['primary_contact_number']."\n\n";
    $message .= "Site Notes\n".$site_rows[0]['site_notes']."\n\n";
    $message .= "PM Notes\n".$sched_rows[0]['notes'];
    $message = wordwrap($message, 70, "\r\n");
    $headers = "From: notifications@sdxng.com";
    mail($to,$subject,$message,$headers);
    Redirect::to('../schedule/');

} else {
    Redirect::to('../login/');
}