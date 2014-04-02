<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {

    if (isset($_GET["id"])) {
        $id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['id']);
    }

    if (!isset($id)) {
        Redirect::to('../user/');
    }

    $userRows = DB::getInstance()->getAssoc("SELECT * FROM users WHERE id = ?", array($id));
    foreach($userRows->results() as $results) {
        $user_rows[] = $results;
    }

    $page = new Page;
    $page->setTitle('View Employee');
    $page->startBody();
    echo $page->render('../includes/menu.php');

?>

    <div id="content">
        <div id="contentHeader"></div>
        <div class="container">
            <div class="grid-24">
                <div class="row">
                    <div class="widget">
                        <div class="form uniformForm">
                            <?php foreach($user_rows as $row): ?>
                                <div class="widget-content">
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="full_name">Name</label>
                                            <input type="text" name="full_name" size="63" value="<?php echo escape($row['full_name']); ?>" id="work_number" tabindex="1" placeholder="Name" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="tech_id">Tech ID</label>
                                            <input type="text" name="tech_id" size="63" value="<?php echo escape($row['id']); ?>" id="tech_id" tabindex="1" placeholder="tech_id" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="msg_address">Msg Address</label>
                                            <input type="text" name="msg_address" size="63" value="<?php echo str_replace("-", "", escape($row['work_number']))."@txt.att.net"; ?>" id="msg_address" tabindex="1" placeholder="msg_address" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="work_group">Work Group</label>
                                            <input type="text" name="work_group" size="63" value="<?php echo escape($row['work_group']); ?>" id="work_group" tabindex="1" placeholder="work_group" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="work_group">Access Level</label>
                                            <?php
                                            if($row['group'] == 1) {
                                                $current = 'View only';
                                            } else {
                                                $current = 'View/Edit';
                                            }
                                            ?>
                                            <input type="text" name="work_group" size="63" value="<?php echo escape($current); ?>" id="work_group" tabindex="1" placeholder="work_group" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="work_number">Work Number</label>
                                            <input type="text" name="work_number" size="63" value="<?php echo escape($row['work_number']); ?>" id="work_number" tabindex="1" placeholder="Work Number" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="alt_number">Alternate Number</label>
                                            <input type="text" name="alt_number" size="63" value="<?php echo escape($row['alt_number']); ?>" id="alt_number" tabindex="1" placeholder="Alternate Number" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="start_time">Day Starts</label>
                                            <input type="text" name="start_time" size="47" value="<?php echo escape($row['start_time']); ?>" id="start_time" tabindex="1" placeholder="Day Starts" readonly/>
                                        </div>
                                        <div class="field">
                                            <label for="stop_time">Day Ends</label>
                                            <input type="text" name="stop_time" size="48" value="<?php echo escape($row['stop_time']); ?>" id="stop_time" tabindex="1" placeholder="Day Stops" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" size="63" value="<?php echo escape($row['email']); ?>" id="email" tabindex="1" placeholder="Email" readonly/>
                                        </div>
                                    </div>
                                    <?php if($user->data()->id === $id || $user->hasPermission('edit')) { ?>
                                        <div class="field-group">
                                            <div class="field">
                                                <label for="pto">Total PTO Left</label>
                                                <input type="text" name="pto" size="63" value="<?php echo escape($row['pto']); ?>" id="pto" tabindex="1" placeholder="PTO Remaining" readonly/>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php endforeach; ?>
                            <div class="widget-content">
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