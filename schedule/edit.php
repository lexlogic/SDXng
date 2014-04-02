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

    if(Input::exists()) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'techlist' => array(
                'required' => true
            ),
            'startmonthlist' => array(
                'required' => true
            ),
            'startdaylist' => array(
                'required' => true
            ),
            'startyearlist' => array(
                'required' => true
            ),
            'notes' => array(
                'required' => true
            )
        ));
        if($validation->passed()) {
            $startday = strtotime($_POST['startyearlist'].'-'.$_POST['startmonthlist'].'-'.$_POST['startdaylist']);

            if(isset($_POST["isLocked"]))
            {
                $isLocked = 1;
                $locked_user = $user->data()->full_name;
            } else {
                $isLocked = 0;
            }

            if(isset($_POST["isConfirmed"]))
            {
                $isConfirmed = 1;
            } else {
                $isConfirmed = 0;
            }

            if(isset($_POST["callConfirmed"]))
            {
                $callConfirmed = 1;
            } else {
                $callConfirmed = 0;
            }

            if($callConfirmed == 1) {
                $isConfirmed = 0;
            }

            $schedule = DB::getInstance()->update('sched', $id, array(
                        '`date`' => date('Y-m-d',$startday),
                        'site' => $_POST['sitelist'],
                        'full_name' => $_POST['techlist'],
                        'type' => $_POST['type'],
                        'nid' => $_POST['nid'],
                        'notes' => $_POST['notes'],
                        'start_time' => $_POST['start_time'],
                        'stop_time' => $_POST['stop_time'],
                        'isLocked' => $isLocked,
                        'locked_user' => $locked_user,
                        'isConfirmed' => $isConfirmed,
                        'callConfirmed' => $callConfirmed,
                        'madeUser' => $user->data()->full_name,
			'oscname' => $_POST['oscname'],
			'oscnumber' => $_POST['oscnumber']
            ));
            Redirect::to('notification.php?id='.$id);
        } else {
            foreach($validation->errors() as $error) {
                $error = ucfirst($error);
                echo '<script type="text/javascript"> alert(\''.$error.'\'); </script>';
            }
        }
    }


    $schedRows = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE id = ?", array($id));
    foreach($schedRows->results() as $results) {
        $sched_rows[] = $results;
    }
    $usersRows = DB::getInstance()->getAssoc("SELECT * FROM users ORDER BY full_name ASC");
    foreach($usersRows->results() as $results) {
        $user_rows[] = $results;
    }
    $siteRows = DB::getInstance()->getAssoc("SELECT * FROM sites ORDER BY site_name ASC");
    foreach($siteRows->results() as $results) {
        $site_rows[] = $results;
    }
    if ($sched_rows[0]['type'] == 'btn-sch btn-brown'){
        $type = "Non-Emergency";
    }
    if ($sched_rows[0]['type'] == 'btn-sch btn-red') {
        $type = "Emergency";
    }
    if ($sched_rows[0]['type'] == 'btn-sch btn-green') {
        $type = "PM";
    }
    if ($sched_rows[0]['type'] == 'btn-sch btn-orange') {
        $type = "Holiday";
    }
    if ($sched_rows[0]['type'] == 'btn-sch btn-purple') {
        $type = "PTO";
    }
    if ($sched_rows[0]['type'] == 'btn-sch btn-primary') {
        $type = "T&M";
    }
    if ($sched_rows[0]['type'] == 'btn-sch btn-blue') {
        $type = "Installed";
    }

    if ($sched_rows[0]['type'] == 'btn-sch btn-black'){
        $type = "Training";
    }
    if ($sched_rows[0]['type'] == 'btn-sch btn-other'){
        $type = "Other";
    }

    $day = date('j', strtotime($sched_rows[0]['date']));
    $daynum = date('d', strtotime($sched_rows[0]['date']));
    $month = date('F', strtotime($sched_rows[0]['date']));
    $monthnum = date('m', strtotime($sched_rows[0]['date']));
    $year = date('Y', strtotime($sched_rows[0]['date']));

    $page = new Page;
    $page->setTitle('Edit Notification');
    $page->startBody();
    echo $page->render('../includes/menu.php');
    ?>


    <div id="content">
        <div id="contentHeader"></div>
        <div class="container">
            <div class="grid-24">
                <div class="row">
                    <div class="widget">
                        <form action="" method="post" accept-charset="utf-8" class="form uniformForm">
                            <div class="widget-content">

                                <div class="field-group">
                                    <div class="field">
                                        <label for="site">Choose Site</label>
                                        <select name="sitelist" id="sitelist">
                                            <option value="<?php echo $sched_rows[0]['site']; ?>"><?php echo $sched_rows[0]['site']; ?></option>
                                            <?php
                                            foreach($site_rows as $site_row) {
                                                $site_name = escape($site_row['site_name']);
                                                echo '<option value="'.escape($site_name).'">';
                                                echo escape($site_row['site_name']);
                                                echo '</option>';
                                            }
                                            echo '<input type="hidden" name="site" value="'.$site_name.'">';
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="field-group">
                                    <div class="field">
                                        <label for="full_name">Choose Technician</label>
                                        <select name="techlist" id="techlist">
                                            <option value="<?php echo $sched_rows[0]['full_name']; ?>">
                                                <?php echo $sched_rows[0]['full_name']; ?>
                                            </option>
                                            <?php
                                            foreach($user_rows as $user_row) {
                                                $user_name = escape($user_row['full_name']);
                                                echo '<option value="'.$user_name.'">';
                                                echo $user_name;
                                                echo '</option>';
                                            }
                                            echo '<input type="hidden" name="full_name" value="'.$user_name.'">';
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="field-group">
                                    <div class="field">
                                        <label for="city">Call Type</label>
                                        <select name="type" id="type" required>
                                            <option value="<?php echo $sched_rows[0]['type']; ?>"><?php echo $type; ?></option>
                                            <option value="btn-sch btn-brown">Non-Emergency</option>
                                            <option value="btn-sch btn-red">Emergency</option>
                                            <option value="btn-sch btn-green">PM</option>
                                            <option value="btn-sch btn-blue">Installed</option>
                                            <option value="btn-sch btn-orange">Holiday</option>
                                            <option value="btn-sch btn-purple">PTO</option>
                                            <option value="btn-sch btn-primary">T&M</option>
                                            <option value="btn-sch btn-black">Training</option>
                                            <option value="btn-sch btn-other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="date">Date</label>
                                        <select name="startmonthlist" id="startmonthlist">
                                            <option value="<?php echo $monthnum; ?>"><?php echo $month; ?></option>
                                            <option>- Month -</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                        <select name="startdaylist" id="startdaylist">
                                            <option value="<?php echo $daynum; ?>"><?php echo $daynum; ?></option>
                                            <option>- Day -</option>
                                            <?php
                                            for ($i=01; $i<32; $i++) {
                                                $value = $i;
                                                if ($i < 10) {
                                                    $value = str_pad($i, 2, "0", STR_PAD_LEFT);
                                                }
                                                echo '<option value="'.$value.'">'.$value.'</option>';
                                            } ?>
                                        </select>
                                        <select name="startyearlist" id="startyearlist">
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                            <option>- Year -</option>
                                            <?php
                                            for ($i=2013; $i<2021; $i++) {
                                                echo '<option value="'.$i.'">'.$i.'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="start_time">Start Time</label>
                                        <input type="text" name="start_time" size="63" value="<?php echo $sched_rows[0]['start_time']; ?>" id="start_time" tabindex="1" placeholder="Start Time" />
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="stop_time">Stop Time</label>
                                        <input type="text" name="stop_time" size="63" value="<?php echo $sched_rows[0]['stop_time']; ?>" id="stop_time" tabindex="1" placeholder="Stop Time" />
                                    </div>
                                </div>

                                <div class="field-group">
                                    <div class="field">
                                        <label for="nid">Svc Ord/Network Number</label>
                                        <input type="text" name="nid" size="63" value="<?php echo $sched_rows[0]['nid']; ?>" id="nid" tabindex="1" placeholder="Network ID" />
                                    </div>
                                </div>

 				<div class="field-group">
                                    <div class="field">
                                        <label for="nid">On-Site Contact Name</label>
                                        <input type="text" name="oscname" size="63" value="<?php echo $sched_rows[0]['oscname']; ?>" id="nid" tabindex="1" placeholder="On-Site Contact Name" />
                                    </div>
                                </div>

 				<div class="field-group">
                                    <div class="field">
                                        <label for="nid">On-Site Contact Number</label>
                                        <input type="text" name="oscnumber" size="63" value="<?php echo $sched_rows[0]['oscnumber']; ?>" id="nid" tabindex="1" placeholder="On-Site Contact Number" />
                                    </div>
                                </div>

                                <div class="field-group">
                                    <div class="field">
                                        <label for="notes">Description</label>
                                        <textarea name="notes" value="" id="notes" placeholder="Notes"  rows="10" cols="63" tabindex="1" /><?php echo $sched_rows[0]['notes']; ?></textarea>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="isLocked">Lock Task
                                        <input type="checkbox" name="isLocked" value="locked" <?php if($sched_rows[0]['isLocked'] == 1) {echo "checked";} ?>>
                                        </label>

                                        <label for="isConfirmed">Requires Confirmation
                                        <input type="checkbox" name="isConfirmed" value="confirmed" <?php if($sched_rows[0]['isConfirmed'] == 1) {echo "checked";} ?>>
                                        </label>

                                        <label for="callConfirmed">Call Confirmed
                                            <input type="checkbox" name="callConfirmed" value="callConfirmed" <?php if($sched_rows[0]['callConfirmed'] == 1) {echo "checked";} ?>>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                                <button type="submit" class="btn btn-primary" tabindex="3">Update Schedule</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../login/');
}