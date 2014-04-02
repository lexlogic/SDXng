<?php
require_once '../Init.php';
$user = new User();
if($user->isLoggedIn()) {


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

    $assignedRows = DB::getInstance()->getAssoc("SELECT DISTINCT full_name FROM sched WHERE site = ? AND date = ?", array($sched_rows[0]['site'], $sched_rows[0]['date']));
    foreach($assignedRows->results() as $results) {
        $assigned_rows[] = $results;
    }

    $page = new Page;
    $page->setTitle('Notification');
    $page->startBody();
    echo $page->render('../includes/menu.php');
    ?>

    <div id="content">
        <div id="contentHeader"></div>
        <div class="container">
            <div class="grid-24">
                <div class="row">
                    <div class="widget">
                        <div class="form uniformForm" action="" name="form">
                            <?php foreach($sched_rows as $row): ?>
                            <div class="widget-content">
                                <div class="field">
                                    <?php if($user->hasPermission('edit')) { ?>
                                        <a href="copy.php?id=<?php echo escape($id); ?>"><button class="btn btn-primary" tabindex="3">Copy PM</button></a>
                                        <a href="../mail/push.php?id=<?php echo escape($id); ?>"><button class="btn btn-primary" tabindex="3">Push Notification</button></a>
                                        <?php if($user->hasPermission('edit') || $row['locked_user'] == $user->data()->full_name || $row['isLocked'] == 0) { ?>
                                            <a href="edit.php?id=<?php echo escape($id); ?>"><button class="btn btn-primary" tabindex="3">Edit Notification</button></a>
                                        <?php } }?>
                                    <button onclick="goBack()" class="btn btn-primary" tabindex="3">Go Back</button>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="email">Site Name</label>
                                        <input type="text" name="site_name" size="63" value="<?php echo escape($site_rows[0]['site_name']); ?>" id="site_name" tabindex="1" placeholder="Site Name" readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="email">Network ID</label>
                                        <input type="text" name="nid" size="63" value="<?php echo escape($row['nid']); ?>" id="nid" tabindex="1" placeholder="Network ID" readonly/>
                                    </div>
                                </div>

                                <div class="field-group">
                                    <div class="field">
                                        <label for="start_time">Start Time</label>
                                        <input type="text" name="start_time" size="63" value="<?php echo escape($row['start_time']); ?>" id="start_time" tabindex="1" placeholder="Start Time" readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="stop_time">Stop Time</label>
                                        <input type="text" name="stop_time" size="63" value="<?php echo escape($row['stop_time']); ?>" id="stop_time" tabindex="1" placeholder="Stop Time" readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="full_name">Address</label>
                                        <input type="text" name="site_address" size="63" value="<?php echo escape($site_rows[0]['site_address']); ?>" id="site_address" tabindex="1" placeholder="Site Address" readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="city">City</label>
                                        <input type="text" name="site_city" size="63" value="<?php echo escape($site_rows[0]['site_city']); ?>" id="site_city" tabindex="1" placeholder="City" readonly/>
                                    </div>
                                    <div class="field">
                                        <label for="zip">State</label>
                                        <input type="text" name="site_state" id="site_state" value="<?php echo escape($site_rows[0]['site_state']); ?>" placeholder="State"  rows="1" cols="10" readonly/>
                                    </div>
                                    <div class="field">
                                        <label for="zip">Zip</label>
                                        <input type="text" name="site_zip" id="site_zip" value="<?php echo escape($site_rows[0]['site_zip']); ?>" placeholder="Zip"  readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="primary_contact_name">Primary Contact Name</label>
                                        <input type="text" name="primary_contact_name" size="63" value="<?php echo escape($site_rows[0]['primary_contact_name']); ?>" id="primary_contact_name" tabindex="1" placeholder="Primary Contact Name" readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="primary_contact_number">Primary Contact Number</label>
                                        <input type="text" name="primary_contact_number" size="63" value="<?php echo escape($site_rows[0]['primary_contact_number']); ?>" id="primary_contact_number" tabindex="1" placeholder="Primary Contact Number" readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="secondary_contact_name">Secondary Contact Name</label>
                                        <input type="text" name="secondary_contact_name" size="63" value="<?php echo escape($site_rows[0]['secondary_contact_name']); ?>" id="secondary_contact_name" tabindex="1" placeholder="Secondary Contact Name" readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="secondary_contact_number">Secondary Contact Number</label>
                                        <input type="text" name="secondary_contact_number" size="63" value="<?php echo escape($site_rows[0]['secondary_contact_number']); ?>" id="secondary_contact_number" tabindex="1" placeholder="Secondary Contact Number" readonly/>
                                    </div>
                                </div>

 				<div class="field-group">
                                    <div class="field">
                                        <label for="nid">On-Site Contact Name</label>
                                        <input type="text" name="oscname" size="63" value="<?php echo escape($row['oscname']); ?>" id="nid" tabindex="1" placeholder="On-Site Contact Name" />
                                    </div>
                                </div>

 				<div class="field-group">
                                    <div class="field">
                                        <label for="nid">On-Site Contact Number</label>
                                        <input type="text" name="oscnumber" size="63" value="<?php echo escape($row['oscnumber']); ?>" id="nid" tabindex="1" placeholder="On-Site Contact Number" />
                                    </div>
                                </div>

                                <div class="field-group">
                                    <div class="field">
                                        <label for="site_notes">Site Notes</label>
                                        <textarea name="site_notes" id="site_notes" placeholder="Site Notes"  rows="10" cols="63" readonly/><?php echo escape($site_rows[0]['site_notes']); ?></textarea>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="site_notes">PM Notes</label>
                                        <textarea name="pm_notes" id="pm_notes" placeholder="PM Notes"  rows="10" cols="63" readonly/><?php echo escape($row['notes']); ?></textarea>
                                        <input type="hidden" name="tech" value="<?php echo $row['full_name']; ?>" id="tech"/>
                                    </div>
                                </div>

                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th><?php echo "Tech(s) Assigned";?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($assigned_rows as $assigned_techs) {
                                        echo "<tr class='gradeA'>";
                                        echo "<td>";
                                        echo $assigned_techs['full_name'];
                                        echo "</td>";
                                        echo "</tr>";
                                    } ?>
                                    </tbody>
                                </table>
                                <div class="field-group">
                                    <div class="field">
					                        <label for="whoCreated">Task Created by <?php echo $row['madeUser']; ?></label>
                                        <?php if ($row['isLocked'] == 1) { ?>
                                            <label for="isLocked">Task Locked by <?php echo $row['locked_user']; ?></label>
                                        <?php } else {?>
                                            <label for="isLocked">Task Unlocked</label>
                                        <?php } ?>

                                        <?php if ($row['isConfirmed'] == 1) { ?>
                                            <label for="isConfirmed">Requires Confirmation</label>
                                        <?php } ?>
                                    </div>
                                </div>
                        </div>
                        <div class="widget-content">
                            <div class="field">
                                <?php if($user->hasPermission('edit')) { ?>
                                    <a href="copy.php?id=<?php echo escape($id); ?>"><button class="btn btn-primary" tabindex="3">Copy PM</button></a>
                                    <a href="../mail/push.php?id=<?php echo escape($id); ?>"><button class="btn btn-primary" tabindex="3">Push Notification</button></a>
                                <?php if($user->hasPermission('edit') || $row['locked_user'] == $user->data()->full_name || $row['isLocked'] == 0) { ?>
                                    <a href="edit.php?id=<?php echo escape($id); ?>"><button class="btn btn-primary" tabindex="3">Edit Notification</button></a>
                                <?php } } endforeach; ?>
                                <button onclick="goBack()" class="btn btn-primary" tabindex="3">Go Back</button>
                            </div>
                        </div>
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
