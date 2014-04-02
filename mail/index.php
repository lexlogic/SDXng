<?php
require_once '/var/www/Init.php';

$usersRows = DB::getInstance()->getAssoc("SELECT full_name, msg_address, email FROM users");
foreach($usersRows->results() as $results) {
    $user_rows[] = $results;
}

$tomorrow = date('Y-m-d',strtotime('tomorrow'));
foreach ($user_rows as $rows) {
    $schedRows = DB::getInstance()->getAssoc("SELECT notes, site, nid FROM sched WHERE full_name = ? AND date = ?", array($rows['full_name'], $tomorrow));
    foreach($schedRows->results() as $results) {
        $mailArray[$rows['full_name']]['PM Info'] = $results;
        $mailArray[$rows['full_name']]['To'] = $rows['msg_address'];
    }
}

foreach($mailArray as $items => $array) {
    $siteRows = DB::getInstance()->getAssoc("SELECT * FROM sites WHERE site_name = ?", array($array['PM Info']['site']));
    foreach($siteRows->results() as $results) {
        $mailArray[$items]['Site Info'] = $results;
    }
}
foreach ($mailArray as $array) {
    $to = $array['To'];
    $subject = "";
    $message =  "Site Name: ".$array['Site Info']['site_name']."\n\n";
    $message =  "Network ID: ".$array['PM Info']['nid']."\n\n";
    $message .= "Site Address: ".$array['Site Info']['site_address']." ".$array['Site Info']['site_city']." ".$array['Site Info']['site_state']." ".$array['Site Info']['site_zip']."\n\n";
    $message .= "Primary Contact: ".$array['Site Info']['primary_contact_name']."\n\n";
    $message .= "Primary Number: ".$array['Site Info']['primary_contact_number']."\n\n";
    $message .= "Site Notes\n".$array['Site Info']['site_notes']."\n\n";
    $message .= "PM Notes\n".$array['PM Info']['notes'];
    $message = wordwrap($message, 70, "\r\n");
    $headers = "From: notifications@sdxng.com";
    mail($to,$subject,$message,$headers);
}
Redirect::to('../schedule/');